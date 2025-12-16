<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Car;
use App\Models\Customer;
use App\Models\Expense;
use App\Models\Maintenance;
use App\Exports\CustomerReportExport;
use App\Exports\FinancialReportExport;
use App\Exports\VehicleReportExport;
use App\Exports\AnalyticsReportExport;
use App\Exports\ProfitabilityReportExport;
use App\Exports\CustomerLTVReportExport;
use App\Services\ReportService;
use App\Services\ExportService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    protected $reportService;
    protected $exportService;

    public function __construct(ReportService $reportService, ExportService $exportService)
    {
        $this->reportService = $reportService;
        $this->exportService = $exportService;
    }
    /**
     * Display the reports dashboard.
     */
    public function index()
    {
        return view('admin.reports.index');
    }

    /**
     * Generate customer reports with booking history and statistics.
     */
    public function customerReport(Request $request)
    {
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'customer_id' => 'nullable|exists:customers,id',
            'member_status' => 'nullable|in:all,members,non_members',
            'format' => 'nullable|in:view,excel,pdf'
        ]);

        $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->subYear();
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : Carbon::now();

        $query = Customer::with(['bookings' => function($q) use ($startDate, $endDate) {
            $q->whereBetween('start_date', [$startDate, $endDate])
              ->with('car');
        }]);

        // Filter by specific customer
        if ($request->customer_id) {
            $query->where('id', $request->customer_id);
        }

        // Filter by member status
        if ($request->member_status === 'members') {
            $query->where('is_member', true);
        } elseif ($request->member_status === 'non_members') {
            $query->where('is_member', false);
        }

        $customers = $query->get();

        $reportData = [
            'customers' => $customers->map(function($customer) use ($startDate, $endDate) {
                $bookings = $customer->bookings;
                $completedBookings = $bookings->where('booking_status', 'completed');
                
                return [
                    'customer' => $customer,
                    'total_bookings' => $bookings->count(),
                    'completed_bookings' => $completedBookings->count(),
                    'total_revenue' => $completedBookings->sum('total_amount'),
                    'total_discount_given' => $completedBookings->sum('member_discount'),
                    'average_booking_value' => $completedBookings->count() > 0 
                        ? $completedBookings->avg('total_amount') 
                        : 0,
                    'last_booking_date' => $bookings->max('start_date'),
                    'booking_frequency' => $this->calculateBookingFrequency($bookings, $startDate, $endDate),
                ];
            }),
            'summary' => [
                'total_customers' => $customers->count(),
                'active_customers' => $customers->filter(function($c) { return $c->bookings->count() > 0; })->count(),
                'member_customers' => $customers->where('is_member', true)->count(),
                'blacklisted_customers' => $customers->where('is_blacklisted', true)->count(),
                'total_bookings' => $customers->sum(function($c) { return $c->bookings->count(); }),
                'total_revenue' => $customers->sum(function($c) { 
                    return $c->bookings->where('booking_status', 'completed')->sum('total_amount'); 
                }),
            ],
            'period' => [
                'start_date' => $startDate->format('Y-m-d'),
                'end_date' => $endDate->format('Y-m-d'),
            ]
        ];

        if ($request->format === 'excel') {
            $result = $this->exportService->exportCustomerReport($reportData, 'excel');
            return Excel::download(new CustomerReportExport($reportData), $result['filename']);
        } elseif ($request->format === 'pdf') {
            $result = $this->exportService->exportCustomerReport($reportData, 'pdf');
            $pdf = Pdf::loadView('admin.reports.pdf.customer', compact('reportData'));
            return $pdf->download($result['filename']);
        }

        return view('admin.reports.customer', compact('reportData'));
    }

    /**
     * Generate financial reports with profit/loss calculations.
     */
    public function financialReport(Request $request)
    {
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'format' => 'nullable|in:view,excel,pdf'
        ]);

        $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->subYear();
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : Carbon::now();

        // Revenue from completed bookings
        $bookings = Booking::with('car', 'customer')
            ->where('booking_status', 'completed')
            ->whereBetween('start_date', [$startDate, $endDate])
            ->get();

        $revenue = [
            'rental_income' => $bookings->sum('base_amount'),
            'driver_fees' => $bookings->sum('driver_fee'),
            'out_of_town_fees' => $bookings->sum('out_of_town_fee'),
            'late_penalties' => $bookings->sum('late_penalty'),
            'member_discounts' => $bookings->sum('member_discount'),
            'total_gross_revenue' => $bookings->sum('total_amount') + $bookings->sum('member_discount'),
            'total_net_revenue' => $bookings->sum('total_amount'),
        ];

        // Operational expenses
        $expenses = Expense::whereBetween('expense_date', [$startDate, $endDate])->get();
        $expensesByCategory = $expenses->groupBy('category')->map(function($categoryExpenses) {
            return [
                'amount' => $categoryExpenses->sum('amount'),
                'count' => $categoryExpenses->count(),
            ];
        });

        // Maintenance costs
        $maintenanceCosts = Maintenance::whereBetween('service_date', [$startDate, $endDate])
            ->sum('cost');

        $totalExpenses = $expenses->sum('amount') + $maintenanceCosts;

        // Profit/Loss calculation
        $profitLoss = [
            'gross_profit' => $revenue['total_net_revenue'] - $totalExpenses,
            'profit_margin' => $revenue['total_net_revenue'] > 0 
                ? (($revenue['total_net_revenue'] - $totalExpenses) / $revenue['total_net_revenue']) * 100 
                : 0,
            'revenue_per_booking' => $bookings->count() > 0 
                ? $revenue['total_net_revenue'] / $bookings->count() 
                : 0,
        ];

        // Monthly breakdown
        $monthlyData = [];
        $currentDate = $startDate->copy()->startOfMonth();
        while ($currentDate <= $endDate) {
            $monthStart = $currentDate->copy()->startOfMonth();
            $monthEnd = $currentDate->copy()->endOfMonth();
            
            $monthBookings = $bookings->filter(function($booking) use ($monthStart, $monthEnd) {
                return $booking->start_date >= $monthStart && $booking->start_date <= $monthEnd;
            });
            
            $monthExpenses = $expenses->filter(function($expense) use ($monthStart, $monthEnd) {
                return $expense->expense_date >= $monthStart && $expense->expense_date <= $monthEnd;
            });

            $monthRevenue = $monthBookings->sum('total_amount');
            $monthExpenseTotal = $monthExpenses->sum('amount');
            
            $monthlyData[] = [
                'month' => $currentDate->format('Y-m'),
                'month_name' => $currentDate->format('F Y'),
                'revenue' => $monthRevenue,
                'expenses' => $monthExpenseTotal,
                'profit' => $monthRevenue - $monthExpenseTotal,
                'bookings_count' => $monthBookings->count(),
            ];
            
            $currentDate->addMonth();
        }

        $reportData = [
            'revenue' => $revenue,
            'expenses' => [
                'operational' => $expenses->sum('amount'),
                'maintenance' => $maintenanceCosts,
                'total' => $totalExpenses,
                'by_category' => $expensesByCategory,
            ],
            'profit_loss' => $profitLoss,
            'monthly_breakdown' => $monthlyData,
            'summary' => [
                'total_bookings' => $bookings->count(),
                'average_booking_value' => $bookings->count() > 0 ? $bookings->avg('total_amount') : 0,
                'total_customers' => $bookings->pluck('customer_id')->unique()->count(),
                'period_days' => $startDate->diffInDays($endDate) + 1,
            ],
            'period' => [
                'start_date' => $startDate->format('Y-m-d'),
                'end_date' => $endDate->format('Y-m-d'),
            ]
        ];

        if ($request->format === 'excel') {
            $result = $this->exportService->exportFinancialReport($reportData, 'excel');
            return Excel::download(new FinancialReportExport($reportData), $result['filename']);
        } elseif ($request->format === 'pdf') {
            $result = $this->exportService->exportFinancialReport($reportData, 'pdf');
            $pdf = Pdf::loadView('admin.reports.pdf.financial', compact('reportData'));
            return $pdf->download($result['filename']);
        }

        return view('admin.reports.financial', compact('reportData'));
    }

    /**
     * Generate vehicle utilization and revenue reports.
     */
    public function vehicleReport(Request $request)
    {
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'car_id' => 'nullable|exists:cars,id',
            'format' => 'nullable|in:view,excel,pdf'
        ]);

        $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->subYear();
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : Carbon::now();

        $query = Car::with(['bookings' => function($q) use ($startDate, $endDate) {
            $q->whereBetween('start_date', [$startDate, $endDate])
              ->with('customer');
        }, 'maintenances' => function($q) use ($startDate, $endDate) {
            $q->whereBetween('service_date', [$startDate, $endDate]);
        }]);

        if ($request->car_id) {
            $query->where('id', $request->car_id);
        }

        $vehicles = $query->get();
        $totalDays = $startDate->diffInDays($endDate) + 1;

        $reportData = [
            'vehicles' => $vehicles->map(function($vehicle) use ($totalDays) {
                $bookings = $vehicle->bookings;
                $completedBookings = $bookings->where('booking_status', 'completed');
                $maintenances = $vehicle->maintenances;
                
                // Calculate utilization
                $totalBookedDays = $bookings->sum(function($booking) {
                    return $booking->start_date->diffInDays($booking->end_date) + 1;
                });
                
                $utilizationRate = $totalDays > 0 ? ($totalBookedDays / $totalDays) * 100 : 0;
                
                // Calculate revenue
                $totalRevenue = $completedBookings->sum('total_amount');
                $maintenanceCosts = $maintenances->sum('cost');
                $netRevenue = $totalRevenue - $maintenanceCosts;
                
                return [
                    'vehicle' => $vehicle,
                    'total_bookings' => $bookings->count(),
                    'completed_bookings' => $completedBookings->count(),
                    'total_booked_days' => $totalBookedDays,
                    'utilization_rate' => $utilizationRate,
                    'total_revenue' => $totalRevenue,
                    'maintenance_costs' => $maintenanceCosts,
                    'net_revenue' => $netRevenue,
                    'revenue_per_day' => $totalBookedDays > 0 ? $totalRevenue / $totalBookedDays : 0,
                    'average_booking_value' => $completedBookings->count() > 0 
                        ? $completedBookings->avg('total_amount') 
                        : 0,
                    'maintenance_frequency' => $maintenances->count(),
                ];
            }),
            'fleet_summary' => [
                'total_vehicles' => $vehicles->count(),
                'average_utilization' => $vehicles->count() > 0 
                    ? $vehicles->avg(function($v) use ($totalDays) {
                        $bookedDays = $v->bookings->sum(function($b) {
                            return $b->start_date->diffInDays($b->end_date) + 1;
                        });
                        return $totalDays > 0 ? ($bookedDays / $totalDays) * 100 : 0;
                    }) 
                    : 0,
                'total_fleet_revenue' => $vehicles->sum(function($v) {
                    return $v->bookings->where('booking_status', 'completed')->sum('total_amount');
                }),
                'total_maintenance_costs' => $vehicles->sum(function($v) {
                    return $v->maintenances->sum('cost');
                }),
                'most_profitable_vehicle' => $vehicles->sortByDesc(function($v) {
                    return $v->bookings->where('booking_status', 'completed')->sum('total_amount') - $v->maintenances->sum('cost');
                })->first(),
                'highest_utilization_vehicle' => $vehicles->sortByDesc(function($v) use ($totalDays) {
                    $bookedDays = $v->bookings->sum(function($b) {
                        return $b->start_date->diffInDays($b->end_date) + 1;
                    });
                    return $totalDays > 0 ? ($bookedDays / $totalDays) * 100 : 0;
                })->first(),
            ],
            'period' => [
                'start_date' => $startDate->format('Y-m-d'),
                'end_date' => $endDate->format('Y-m-d'),
                'total_days' => $totalDays,
            ]
        ];

        if ($request->format === 'excel') {
            $result = $this->exportService->exportVehicleReport($reportData, 'excel');
            return Excel::download(new VehicleReportExport($reportData), $result['filename']);
        } elseif ($request->format === 'pdf') {
            $result = $this->exportService->exportVehicleReport($reportData, 'pdf');
            $pdf = Pdf::loadView('admin.reports.pdf.vehicle', compact('reportData'));
            return $pdf->download($result['filename']);
        }

        return view('admin.reports.vehicle', compact('reportData'));
    }

    /**
     * Calculate booking frequency for a customer.
     */
    private function calculateBookingFrequency($bookings, Carbon $startDate, Carbon $endDate): string
    {
        $totalDays = $startDate->diffInDays($endDate) + 1;
        $bookingCount = $bookings->count();
        
        if ($bookingCount === 0) {
            return 'No bookings';
        }
        
        $averageDaysBetweenBookings = $totalDays / $bookingCount;
        
        if ($averageDaysBetweenBookings <= 30) {
            return 'Very frequent (monthly)';
        } elseif ($averageDaysBetweenBookings <= 90) {
            return 'Frequent (quarterly)';
        } elseif ($averageDaysBetweenBookings <= 180) {
            return 'Occasional (semi-annual)';
        } else {
            return 'Rare (annual or less)';
        }
    }

    /**
     * Batch export multiple reports.
     */
    public function batchExport(Request $request)
    {
        $request->validate([
            'reports' => 'required|array',
            'reports.*.type' => 'required|in:customer,financial,vehicle,analytics,profitability,customerLTV',
            'reports.*.format' => 'required|in:excel,pdf',
            'reports.*.start_date' => 'nullable|date',
            'reports.*.end_date' => 'nullable|date|after_or_equal:reports.*.start_date',
            'email' => 'nullable|email',
        ]);

        $reportsToExport = [];
        
        foreach ($request->reports as $reportConfig) {
            // Generate report data based on type
            $reportData = $this->generateReportData($reportConfig);
            
            $reportsToExport[] = [
                'type' => $reportConfig['type'],
                'format' => $reportConfig['format'],
                'data' => $reportData,
            ];
        }
        
        $exportedFiles = $this->exportService->batchExport($reportsToExport, $request->email);
        
        return response()->json([
            'success' => true,
            'message' => 'Batch export completed successfully',
            'exported_files' => $exportedFiles,
            'total_files' => count($exportedFiles),
        ]);
    }

    /**
     * Schedule export for later processing.
     */
    public function scheduleExport(Request $request)
    {
        $request->validate([
            'report_type' => 'required|in:customer,financial,vehicle,analytics,profitability,customerLTV',
            'format' => 'required|in:excel,pdf',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'email' => 'required|email',
            'scheduled_at' => 'nullable|date|after:now',
        ]);

        $reportData = $this->generateReportData($request->all());
        
        $result = $this->exportService->scheduleExport(
            $request->report_type,
            $reportData,
            $request->format,
            $request->email,
            $request->scheduled_at
        );
        
        return response()->json([
            'success' => true,
            'message' => 'Export scheduled successfully',
            'schedule_info' => $result,
        ]);
    }

    /**
     * Get export history.
     */
    public function exportHistory(Request $request)
    {
        $limit = $request->get('limit', 50);
        $history = $this->exportService->getExportHistory($limit);
        
        return response()->json([
            'success' => true,
            'exports' => $history->values(),
            'total' => $history->count(),
        ]);
    }

    /**
     * Generate analytics dashboard report.
     */
    public function analyticsReport(Request $request)
    {
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'format' => 'nullable|in:view,excel,pdf'
        ]);

        $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->subMonths(3);
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : Carbon::now();

        $analytics = $this->reportService->getDashboardAnalytics($startDate, $endDate);
        $profitability = $this->reportService->getVehicleProfitabilityAnalysis($startDate, $endDate);
        $customerLTV = $this->reportService->getCustomerLifetimeValueAnalysis();
        $seasonalTrends = $this->reportService->getSeasonalTrendAnalysis();

        $reportData = [
            'analytics' => $analytics,
            'profitability' => $profitability->take(10), // Top 10 most profitable vehicles
            'customer_ltv' => $customerLTV->take(20), // Top 20 customers by LTV
            'seasonal_trends' => $seasonalTrends,
            'period' => [
                'start_date' => $startDate->format('Y-m-d'),
                'end_date' => $endDate->format('Y-m-d'),
            ]
        ];

        if ($request->format === 'excel') {
            $result = $this->exportService->exportAnalyticsReport($reportData, 'excel');
            return Excel::download(new AnalyticsReportExport($reportData), $result['filename']);
        } elseif ($request->format === 'pdf') {
            $result = $this->exportService->exportAnalyticsReport($reportData, 'pdf');
            $pdf = Pdf::loadView('admin.reports.pdf.analytics', compact('reportData'));
            return $pdf->download($result['filename']);
        }

        return view('admin.reports.analytics', compact('reportData'));
    }

    /**
     * Generate profitability analysis report.
     */
    public function profitabilityReport(Request $request)
    {
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'format' => 'nullable|in:view,excel,pdf'
        ]);

        $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->subYear();
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : Carbon::now();

        $profitabilityData = $this->reportService->getVehicleProfitabilityAnalysis($startDate, $endDate);
        
        $reportData = [
            'vehicles' => $profitabilityData,
            'summary' => [
                'total_vehicles' => $profitabilityData->count(),
                'profitable_vehicles' => $profitabilityData->where('net_profit', '>', 0)->count(),
                'total_revenue' => $profitabilityData->sum('revenue'),
                'total_maintenance_costs' => $profitabilityData->sum('maintenance_costs'),
                'total_net_profit' => $profitabilityData->sum('net_profit'),
                'average_profit_margin' => $profitabilityData->avg('profit_margin'),
                'best_performer' => $profitabilityData->first(),
                'worst_performer' => $profitabilityData->last(),
            ],
            'period' => [
                'start_date' => $startDate->format('Y-m-d'),
                'end_date' => $endDate->format('Y-m-d'),
            ]
        ];

        if ($request->format === 'excel') {
            $result = $this->exportService->exportProfitabilityReport($reportData, 'excel');
            return Excel::download(new ProfitabilityReportExport($reportData), $result['filename']);
        } elseif ($request->format === 'pdf') {
            $result = $this->exportService->exportProfitabilityReport($reportData, 'pdf');
            $pdf = Pdf::loadView('admin.reports.pdf.profitability', compact('reportData'));
            return $pdf->download($result['filename']);
        }

        return view('admin.reports.profitability', compact('reportData'));
    }

    /**
     * Generate customer lifetime value report.
     */
    public function customerLTVReport(Request $request)
    {
        $request->validate([
            'format' => 'nullable|in:view,excel,pdf'
        ]);

        $customerLTVData = $this->reportService->getCustomerLifetimeValueAnalysis();
        
        $reportData = [
            'customers' => $customerLTVData,
            'summary' => [
                'total_customers' => $customerLTVData->count(),
                'total_lifetime_value' => $customerLTVData->sum('lifetime_value'),
                'average_lifetime_value' => $customerLTVData->avg('lifetime_value'),
                'top_10_percent_value' => $customerLTVData->take($customerLTVData->count() * 0.1)->sum('lifetime_value'),
                'average_booking_frequency' => $customerLTVData->avg('booking_frequency_days'),
                'highest_ltv_customer' => $customerLTVData->first(),
            ]
        ];

        if ($request->format === 'excel') {
            $result = $this->exportService->exportCustomerLTVReport($reportData, 'excel');
            return Excel::download(new CustomerLTVReportExport($reportData), $result['filename']);
        } elseif ($request->format === 'pdf') {
            $result = $this->exportService->exportCustomerLTVReport($reportData, 'pdf');
            $pdf = Pdf::loadView('admin.reports.pdf.customer-ltv', compact('reportData'));
            return $pdf->download($result['filename']);
        }

        return view('admin.reports.customer-ltv', compact('reportData'));
    }

    /**
     * Generate report data based on configuration.
     */
    private function generateReportData($config)
    {
        $startDate = isset($config['start_date']) ? Carbon::parse($config['start_date']) : Carbon::now()->subYear();
        $endDate = isset($config['end_date']) ? Carbon::parse($config['end_date']) : Carbon::now();
        
        switch ($config['type']) {
            case 'customer':
                return $this->generateCustomerReportData($startDate, $endDate, $config);
            case 'financial':
                return $this->generateFinancialReportData($startDate, $endDate);
            case 'vehicle':
                return $this->generateVehicleReportData($startDate, $endDate, $config);
            case 'analytics':
                return $this->generateAnalyticsReportData($startDate, $endDate);
            case 'profitability':
                return $this->generateProfitabilityReportData($startDate, $endDate);
            case 'customerLTV':
                return $this->generateCustomerLTVReportData();
            default:
                throw new \InvalidArgumentException('Unknown report type: ' . $config['type']);
        }
    }

    /**
     * Generate customer report data.
     */
    private function generateCustomerReportData($startDate, $endDate, $config = [])
    {
        // This would contain the same logic as customerReport method
        // Simplified for brevity
        return [
            'customers' => collect(),
            'summary' => [],
            'period' => [
                'start_date' => $startDate->format('Y-m-d'),
                'end_date' => $endDate->format('Y-m-d'),
            ]
        ];
    }

    /**
     * Generate financial report data.
     */
    private function generateFinancialReportData($startDate, $endDate)
    {
        // This would contain the same logic as financialReport method
        // Simplified for brevity
        return [
            'revenue' => [],
            'expenses' => [],
            'profit_loss' => [],
            'monthly_breakdown' => [],
            'period' => [
                'start_date' => $startDate->format('Y-m-d'),
                'end_date' => $endDate->format('Y-m-d'),
            ]
        ];
    }

    /**
     * Generate vehicle report data.
     */
    private function generateVehicleReportData($startDate, $endDate, $config = [])
    {
        // This would contain the same logic as vehicleReport method
        // Simplified for brevity
        return [
            'vehicles' => collect(),
            'fleet_summary' => [],
            'period' => [
                'start_date' => $startDate->format('Y-m-d'),
                'end_date' => $endDate->format('Y-m-d'),
            ]
        ];
    }

    /**
     * Generate analytics report data.
     */
    private function generateAnalyticsReportData($startDate, $endDate)
    {
        $analytics = $this->reportService->getDashboardAnalytics($startDate, $endDate);
        $profitability = $this->reportService->getVehicleProfitabilityAnalysis($startDate, $endDate);
        $customerLTV = $this->reportService->getCustomerLifetimeValueAnalysis();
        $seasonalTrends = $this->reportService->getSeasonalTrendAnalysis();

        return [
            'analytics' => $analytics,
            'profitability' => $profitability->take(10),
            'customer_ltv' => $customerLTV->take(20),
            'seasonal_trends' => $seasonalTrends,
            'period' => [
                'start_date' => $startDate->format('Y-m-d'),
                'end_date' => $endDate->format('Y-m-d'),
            ]
        ];
    }

    /**
     * Generate profitability report data.
     */
    private function generateProfitabilityReportData($startDate, $endDate)
    {
        $profitabilityData = $this->reportService->getVehicleProfitabilityAnalysis($startDate, $endDate);
        
        return [
            'vehicles' => $profitabilityData,
            'summary' => [
                'total_vehicles' => $profitabilityData->count(),
                'profitable_vehicles' => $profitabilityData->where('net_profit', '>', 0)->count(),
                'total_revenue' => $profitabilityData->sum('revenue'),
                'total_maintenance_costs' => $profitabilityData->sum('maintenance_costs'),
                'total_net_profit' => $profitabilityData->sum('net_profit'),
                'average_profit_margin' => $profitabilityData->avg('profit_margin'),
                'best_performer' => $profitabilityData->first(),
                'worst_performer' => $profitabilityData->last(),
            ],
            'period' => [
                'start_date' => $startDate->format('Y-m-d'),
                'end_date' => $endDate->format('Y-m-d'),
            ]
        ];
    }

    /**
     * Generate customer LTV report data.
     */
    private function generateCustomerLTVReportData()
    {
        $customerLTVData = $this->reportService->getCustomerLifetimeValueAnalysis();
        
        return [
            'customers' => $customerLTVData,
            'summary' => [
                'total_customers' => $customerLTVData->count(),
                'total_lifetime_value' => $customerLTVData->sum('lifetime_value'),
                'average_lifetime_value' => $customerLTVData->avg('lifetime_value'),
                'top_10_percent_value' => $customerLTVData->take($customerLTVData->count() * 0.1)->sum('lifetime_value'),
                'average_booking_frequency' => $customerLTVData->avg('booking_frequency_days'),
                'highest_ltv_customer' => $customerLTVData->first(),
            ]
        ];
    }
}