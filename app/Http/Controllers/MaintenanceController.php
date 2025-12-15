<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Maintenance;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class MaintenanceController extends Controller
{
    /**
     * Display a listing of maintenance records.
     */
    public function index(Request $request): View
    {
        $query = Maintenance::with(['car'])
            ->orderBy('service_date', 'desc');

        // Apply filters
        if ($request->filled('car_id')) {
            $query->where('car_id', $request->car_id);
        }

        if ($request->filled('maintenance_type')) {
            $query->where('maintenance_type', $request->maintenance_type);
        }

        if ($request->filled('service_provider')) {
            $query->where('service_provider', 'like', '%' . $request->service_provider . '%');
        }

        if ($request->filled('date_from')) {
            $query->where('service_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('service_date', '<=', $request->date_to);
        }

        $maintenances = $query->paginate(15);
        $cars = Car::orderBy('license_plate')->get();

        // Get summary statistics
        $totalCost = Maintenance::sum('cost');
        $thisMonthCost = Maintenance::whereMonth('service_date', Carbon::now()->month)
            ->whereYear('service_date', Carbon::now()->year)
            ->sum('cost');
        $overdueMaintenance = $this->getOverdueMaintenanceCount();
        $dueSoonMaintenance = $this->getDueSoonMaintenanceCount();

        return view('admin.maintenance.index', compact(
            'maintenances',
            'cars',
            'totalCost',
            'thisMonthCost',
            'overdueMaintenance',
            'dueSoonMaintenance'
        ));
    }

    /**
     * Show the form for creating a new maintenance record.
     */
    public function create(): View
    {
        $cars = Car::orderBy('license_plate')->get();
        return view('admin.maintenance.create', compact('cars'));
    }

    /**
     * Store a newly created maintenance record.
     */
    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'car_id' => 'required|exists:cars,id',
            'maintenance_type' => 'required|in:routine,repair,inspection',
            'description' => 'required|string|max:1000',
            'cost' => 'required|numeric|min:0|max:999999.99',
            'service_date' => 'required|date|before_or_equal:today',
            'next_service_date' => 'nullable|date|after:service_date',
            'odometer_at_service' => 'required|integer|min:0',
            'service_provider' => 'required|string|max:255',
            'receipt_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $validator->validated();

        // Handle receipt photo upload
        if ($request->hasFile('receipt_photo')) {
            $file = $request->file('receipt_photo');
            $filename = 'maintenance_' . time() . '_' . $file->getClientOriginalName();
            $data['receipt_photo'] = $file->storeAs('maintenance/receipts', $filename, 'public');
        }

        // Auto-schedule next service if not provided
        if (!$data['next_service_date'] && $data['maintenance_type'] === 'routine') {
            $data['next_service_date'] = Carbon::parse($data['service_date'])->addDays(90);
        }

        $maintenance = Maintenance::create($data);

        // Update car status if it was in maintenance
        $car = Car::find($data['car_id']);
        if ($car->status === Car::STATUS_MAINTENANCE) {
            $car->markAsAvailable();
        }

        return redirect()->route('admin.maintenance.index')
            ->with('success', 'Maintenance record created successfully.');
    }

    /**
     * Display the specified maintenance record.
     */
    public function show(Maintenance $maintenance): View
    {
        $maintenance->load(['car']);
        
        // Get related maintenance records for the same car
        $relatedMaintenances = Maintenance::where('car_id', $maintenance->car_id)
            ->where('id', '!=', $maintenance->id)
            ->orderBy('service_date', 'desc')
            ->limit(5)
            ->get();

        return view('admin.maintenance.show', compact('maintenance', 'relatedMaintenances'));
    }

    /**
     * Show the form for editing the specified maintenance record.
     */
    public function edit(Maintenance $maintenance): View
    {
        $cars = Car::orderBy('license_plate')->get();
        return view('admin.maintenance.edit', compact('maintenance', 'cars'));
    }

    /**
     * Update the specified maintenance record.
     */
    public function update(Request $request, Maintenance $maintenance): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'car_id' => 'required|exists:cars,id',
            'maintenance_type' => 'required|in:routine,repair,inspection',
            'description' => 'required|string|max:1000',
            'cost' => 'required|numeric|min:0|max:999999.99',
            'service_date' => 'required|date|before_or_equal:today',
            'next_service_date' => 'nullable|date|after:service_date',
            'odometer_at_service' => 'required|integer|min:0',
            'service_provider' => 'required|string|max:255',
            'receipt_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $validator->validated();

        // Handle receipt photo upload
        if ($request->hasFile('receipt_photo')) {
            // Delete old photo if exists
            if ($maintenance->receipt_photo) {
                Storage::disk('public')->delete($maintenance->receipt_photo);
            }

            $file = $request->file('receipt_photo');
            $filename = 'maintenance_' . time() . '_' . $file->getClientOriginalName();
            $data['receipt_photo'] = $file->storeAs('maintenance/receipts', $filename, 'public');
        }

        $maintenance->update($data);

        return redirect()->route('admin.maintenance.show', $maintenance)
            ->with('success', 'Maintenance record updated successfully.');
    }

    /**
     * Remove the specified maintenance record.
     */
    public function destroy(Maintenance $maintenance): RedirectResponse
    {
        // Delete receipt photo if exists
        if ($maintenance->receipt_photo) {
            Storage::disk('public')->delete($maintenance->receipt_photo);
        }

        $maintenance->delete();

        return redirect()->route('admin.maintenance.index')
            ->with('success', 'Maintenance record deleted successfully.');
    }

    /**
     * Get maintenance reminders for dashboard.
     */
    public function getReminders(): JsonResponse
    {
        $overdue = Maintenance::overdue()
            ->with(['car'])
            ->get()
            ->map(function ($maintenance) {
                return $maintenance->createReminderNotification();
            });

        $dueSoon = Maintenance::dueSoon(7)
            ->with(['car'])
            ->get()
            ->map(function ($maintenance) {
                return $maintenance->createReminderNotification();
            });

        return response()->json([
            'overdue' => $overdue,
            'due_soon' => $dueSoon,
            'total_count' => $overdue->count() + $dueSoon->count(),
        ]);
    }

    /**
     * Schedule maintenance for a car.
     */
    public function schedule(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'car_id' => 'required|exists:cars,id',
            'maintenance_type' => 'required|in:routine,repair,inspection',
            'description' => 'required|string|max:1000',
            'scheduled_date' => 'required|date|after:today',
            'estimated_cost' => 'nullable|numeric|min:0',
            'service_provider' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = $validator->validated();
        
        // Create maintenance record with future date
        $maintenance = Maintenance::create([
            'car_id' => $data['car_id'],
            'maintenance_type' => $data['maintenance_type'],
            'description' => $data['description'],
            'cost' => $data['estimated_cost'] ?? 0,
            'service_date' => $data['scheduled_date'],
            'next_service_date' => null,
            'odometer_at_service' => 0, // Will be updated when actual service is done
            'service_provider' => $data['service_provider'],
        ]);

        // Mark car as scheduled for maintenance if date is soon
        $car = Car::find($data['car_id']);
        if (Carbon::parse($data['scheduled_date'])->diffInDays(Carbon::now()) <= 3) {
            $car->markAsInMaintenance();
        }

        return response()->json([
            'success' => true,
            'message' => 'Maintenance scheduled successfully.',
            'maintenance' => $maintenance->load('car'),
        ]);
    }

    /**
     * Get maintenance analytics data.
     */
    public function analytics(Request $request): JsonResponse
    {
        $startDate = $request->get('start_date', Carbon::now()->subYear());
        $endDate = $request->get('end_date', Carbon::now());

        // Monthly cost trends
        $monthlyCosts = Maintenance::selectRaw('
                YEAR(service_date) as year,
                MONTH(service_date) as month,
                SUM(cost) as total_cost,
                COUNT(*) as maintenance_count
            ')
            ->whereBetween('service_date', [$startDate, $endDate])
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        // Cost by maintenance type
        $costByType = Maintenance::selectRaw('
                maintenance_type,
                SUM(cost) as total_cost,
                COUNT(*) as count,
                AVG(cost) as average_cost
            ')
            ->whereBetween('service_date', [$startDate, $endDate])
            ->groupBy('maintenance_type')
            ->get();

        // Top service providers by cost
        $topProviders = Maintenance::selectRaw('
                service_provider,
                SUM(cost) as total_cost,
                COUNT(*) as service_count
            ')
            ->whereBetween('service_date', [$startDate, $endDate])
            ->groupBy('service_provider')
            ->orderBy('total_cost', 'desc')
            ->limit(10)
            ->get();

        // Vehicle maintenance costs
        $vehicleCosts = Maintenance::selectRaw('
                car_id,
                SUM(cost) as total_cost,
                COUNT(*) as maintenance_count,
                AVG(cost) as average_cost
            ')
            ->with(['car:id,license_plate,brand,model'])
            ->whereBetween('service_date', [$startDate, $endDate])
            ->groupBy('car_id')
            ->orderBy('total_cost', 'desc')
            ->get();

        return response()->json([
            'monthly_costs' => $monthlyCosts,
            'cost_by_type' => $costByType,
            'top_providers' => $topProviders,
            'vehicle_costs' => $vehicleCosts,
            'total_cost' => Maintenance::whereBetween('service_date', [$startDate, $endDate])->sum('cost'),
            'total_count' => Maintenance::whereBetween('service_date', [$startDate, $endDate])->count(),
        ]);
    }

    /**
     * Export maintenance data to Excel.
     */
    public function export(Request $request): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $startDate = $request->get('start_date', Carbon::now()->subYear());
        $endDate = $request->get('end_date', Carbon::now());

        return (new \App\Exports\MaintenanceExport($startDate, $endDate))->download(
            'maintenance_report_' . Carbon::now()->format('Y-m-d') . '.xlsx'
        );
    }

    /**
     * Get maintenance history for a specific car.
     */
    public function carHistory(Car $car): JsonResponse
    {
        $history = Maintenance::getHistorySummaryForCar($car->id);
        
        $maintenances = Maintenance::where('car_id', $car->id)
            ->orderBy('service_date', 'desc')
            ->get();

        return response()->json([
            'summary' => $history,
            'maintenances' => $maintenances,
        ]);
    }

    /**
     * Mark maintenance as completed.
     */
    public function markCompleted(Request $request, Maintenance $maintenance): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'actual_cost' => 'required|numeric|min:0',
            'actual_odometer' => 'required|integer|min:0',
            'completion_notes' => 'nullable|string|max:1000',
            'receipt_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = $validator->validated();

        // Handle receipt photo upload
        if ($request->hasFile('receipt_photo')) {
            $file = $request->file('receipt_photo');
            $filename = 'maintenance_' . time() . '_' . $file->getClientOriginalName();
            $data['receipt_photo'] = $file->storeAs('maintenance/receipts', $filename, 'public');
        }

        // Update maintenance record
        $maintenance->update([
            'cost' => $data['actual_cost'],
            'odometer_at_service' => $data['actual_odometer'],
            'service_date' => Carbon::now(),
            'receipt_photo' => $data['receipt_photo'] ?? $maintenance->receipt_photo,
        ]);

        // Add completion notes if provided
        if (!empty($data['completion_notes'])) {
            $maintenance->update([
                'description' => $maintenance->description . "\n\nCompletion Notes: " . $data['completion_notes']
            ]);
        }

        // Schedule next maintenance if routine
        if ($maintenance->maintenance_type === Maintenance::TYPE_ROUTINE) {
            $maintenance->scheduleNextMaintenance();
        }

        // Update car status back to available
        $maintenance->car->markAsAvailable();

        return response()->json([
            'success' => true,
            'message' => 'Maintenance marked as completed.',
            'maintenance' => $maintenance->fresh()->load('car'),
        ]);
    }

    /**
     * Get overdue maintenance count.
     */
    private function getOverdueMaintenanceCount(): int
    {
        return Maintenance::overdue()->count();
    }

    /**
     * Get maintenance due soon count.
     */
    private function getDueSoonMaintenanceCount(): int
    {
        return Maintenance::dueSoon(7)->count();
    }
}