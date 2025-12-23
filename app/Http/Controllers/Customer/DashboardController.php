<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the customer dashboard.
     */
    public function index(): View
    {
        $customer = auth('customer')->user();
        
        $stats = [
            'total_bookings' => $customer->bookings()->count(),
            'active_bookings' => $customer->activeBookings()->count(),
            'completed_bookings' => $customer->completedBookings()->count(),
            'total_spent' => $customer->bookings()
                ->whereIn('payment_status', ['paid', 'partial', 'verifying'])
                ->sum('paid_amount'),
        ];

        $recentBookings = $customer->bookings()
            ->with(['car'])
            ->latest()
            ->limit(5)
            ->get();

        // Get pending payments for alert (belum bayar sama sekali)
        $pendingPayments = $customer->bookings()
            ->with(['car'])
            ->where('payment_status', 'pending')
            ->whereIn('booking_status', ['pending', 'confirmed'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Get partial payments for alert (sudah bayar deposit, belum lunas)
        $partialPayments = $customer->bookings()
            ->with(['car'])
            ->where('payment_status', 'partial')
            ->whereIn('booking_status', ['confirmed', 'active'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('customer.dashboard', compact('stats', 'recentBookings', 'pendingPayments', 'partialPayments'));
    }

    /**
     * Display customer bookings.
     */
    public function bookings(): View
    {
        $customer = auth('customer')->user();
        
        $bookings = $customer->bookings()
            ->with(['car'])
            ->latest()
            ->paginate(10);

        return view('customer.bookings', compact('bookings'));
    }

    /**
     * Display customer profile.
     */
    public function profile(): View
    {
        $customer = auth('customer')->user();
        
        return view('customer.profile', compact('customer'));
    }

    /**
     * Update customer profile.
     */
    public function updateProfile(Request $request)
    {
        $customer = auth('customer')->user();
        
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:customers,email,' . $customer->id],
        ]);

        $customer->update($request->only(['name', 'phone', 'address', 'email']));

        return back()->with('success', 'Profile updated successfully.');
    }

    /**
     * Show booking details.
     */
    public function showBooking(Booking $booking)
    {
        $customer = auth('customer')->user();
        
        // Ensure the booking belongs to the authenticated customer
        if ($booking->customer_id !== $customer->id) {
            abort(403, 'Unauthorized access to booking. Booking Customer: ' . $booking->customer_id . ', Auth User: ' . $customer->id);
        }

        return view('customer.booking-details', compact('booking'));
    }

    /**
     * Cancel a booking.
     */
    public function cancelBooking(Request $request, Booking $booking)
    {
        $customer = auth('customer')->user();
        
        // Ensure the booking belongs to the authenticated customer
        if ($booking->customer_id !== $customer->id) {
            abort(403, 'Unauthorized access to booking. Booking Customer: ' . $booking->customer_id . ', Auth User: ' . $customer->id);
        }

        // Check if booking can be cancelled
        if (!$booking->canBeCancelled()) {
            return back()->with('error', 'This booking cannot be cancelled.');
        }

        $request->validate([
            'cancellation_reason' => ['required', 'string', 'max:500'],
        ]);

        // Cancel the booking
        $booking->cancel();
        $booking->update([
            'notes' => ($booking->notes ? $booking->notes . "\n\n" : '') . 
                      "Cancelled by customer: " . $request->cancellation_reason
        ]);

        return redirect()->route('customer.bookings')
                        ->with('success', 'Booking cancelled successfully.');
    }

    /**
     * Download e-ticket for a booking.
     */
    public function downloadTicket(Booking $booking)
    {
        $customer = auth('customer')->user();
        
        // Ensure the booking belongs to the authenticated customer
        if ($booking->customer_id !== $customer->id) {
            abort(403, 'Unauthorized access to booking. Booking Customer: ' . $booking->customer_id . ', Auth User: ' . $customer->id);
        }

        // Only allow ticket download for confirmed or active bookings
        if (!in_array($booking->booking_status, ['confirmed', 'active'])) {
            return back()->with('error', 'E-ticket is only available for confirmed bookings.');
        }

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('customer.ticket-pdf', compact('booking'));
        
        return $pdf->download('e-ticket-' . $booking->booking_number . '.pdf');
    }

    /**
     * Show payment confirmation page.
     */
    public function showPayment(Booking $booking)
    {
        $customer = auth('customer')->user();
        
        // Ensure the booking belongs to the authenticated customer
        if ($booking->customer_id != $customer->id) {
             abort(403, "Unauthorized access. Booking Owner ID: {$booking->customer_id}, Your ID: {$customer->id}");
        }

        // Only allow payment upload for pending or partial payments
        if (!in_array($booking->payment_status, ['pending', 'partial'])) {
            return back()->with('error', 'Payment confirmation is only available for pending or partial payments.');
        }

        return view('customer.payment-confirmation', compact('booking'));
    }

    /**
     * Submit payment proof.
     */
    public function submitPayment(Request $request, Booking $booking)
    {
        $customer = auth('customer')->user();
        
        // Ensure the booking belongs to the authenticated customer
        if ($booking->customer_id !== $customer->id) {
            abort(403, 'Unauthorized access to booking. Booking Customer: ' . $booking->customer_id . ', Auth User: ' . $customer->id);
        }

        $request->validate([
            'payment_proof' => ['required', 'image', 'max:5120'], // 5MB max
            'payment_type' => ['required', 'in:deposit,full'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        // Store payment proof
        $path = $request->file('payment_proof')->store('payment-proofs', 'public');

        // Calculate paid amount based on payment type
        $paidAmount = $request->payment_type === 'full' 
            ? $booking->total_amount 
            : $booking->deposit_amount;

        // If this is a full payment (pelunasan) and previous status was partial,
        // save the existing payment proof (deposit) to deposit_proof column
        // so we don't lose the history
        $depositProof = $booking->deposit_proof;
        if ($request->payment_type === 'full' && $booking->payment_status === 'partial') {
            $depositProof = $booking->payment_proof;
        }

        // Update booking with payment proof
        $booking->update([
            'payment_proof' => $path,
            'deposit_proof' => $depositProof,
            'payment_notes' => $request->notes,
            'payment_type' => $request->payment_type,
            'paid_amount' => $paidAmount,
            'payment_status' => Booking::PAYMENT_VERIFYING,
        ]);

        $message = $request->payment_type === 'full'
            ? 'Bukti pembayaran lunas berhasil diupload. Menunggu verifikasi admin.'
            : 'Bukti pembayaran deposit berhasil diupload. Sisanya dibayar setelah mobil dikembalikan.';

        return redirect()->route('customer.bookings.show', $booking)
            ->with('success', $message);
    }

    /**
     * Show booking modification form.
     */
    public function editBooking(Booking $booking)
    {
        $customer = auth('customer')->user();
        
        // Ensure the booking belongs to the authenticated customer
        if ($booking->customer_id !== $customer->id) {
            abort(403, 'Unauthorized access to booking. Booking Customer: ' . $booking->customer_id . ', Auth User: ' . $customer->id);
        }

        // Check if booking can be modified
        if (!$booking->canBeModified()) {
            return back()->with('error', 'This booking cannot be modified.');
        }

        return view('customer.edit-booking', compact('booking'));
    }

    /**
     * Update booking details.
     */
    public function updateBooking(Request $request, Booking $booking)
    {
        $customer = auth('customer')->user();
        
        // Ensure the booking belongs to the authenticated customer
        if ($booking->customer_id !== $customer->id) {
            abort(403, 'Unauthorized access to booking. Booking Customer: ' . $booking->customer_id . ', Auth User: ' . $customer->id);
        }

        // Check if booking can be modified
        if (!$booking->canBeModified()) {
            return back()->with('error', 'This booking cannot be modified.');
        }

        $request->validate([
            'start_date' => ['required', 'date', 'after:today'],
            'end_date' => ['required', 'date', 'after:start_date'],
            'pickup_location' => ['required', 'string', 'max:255'],
            'return_location' => ['required', 'string', 'max:255'],
            'with_driver' => ['boolean'],
            'is_out_of_town' => ['boolean'],
            'out_of_town_fee' => ['nullable', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        // Check vehicle availability for new dates
        $availabilityService = app(\App\Services\AvailabilityService::class);
        $isAvailable = $availabilityService->checkAvailability(
            $booking->car_id,
            $request->start_date,
            $request->end_date,
            $booking->id // Exclude current booking from availability check
        );

        if (!$isAvailable) {
            return back()->with('error', 'Vehicle is not available for the selected dates.');
        }

        // Update booking details
        $booking->update([
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'pickup_location' => $request->pickup_location,
            'return_location' => $request->return_location,
            'with_driver' => $request->boolean('with_driver'),
            'is_out_of_town' => $request->boolean('is_out_of_town'),
            'out_of_town_fee' => $request->is_out_of_town ? ($request->out_of_town_fee ?? 0) : 0,
            'notes' => $request->notes,
        ]);

        // Recalculate pricing
        $booking->updatePricing();

        return redirect()->route('customer.bookings')
                        ->with('success', 'Booking updated successfully.');
    }

    /**
     * Show customer support page.
     */
    public function support()
    {
        $customer = auth('customer')->user();
        
        // Get customer's recent bookings for support context
        $recentBookings = $customer->bookings()
            ->with(['car'])
            ->latest()
            ->limit(5)
            ->get();

        return view('customer.support', compact('recentBookings'));
    }

    /**
     * Submit support request.
     */
    public function submitSupportRequest(Request $request)
    {
        $customer = auth('customer')->user();
        
        $request->validate([
            'subject' => ['required', 'string', 'max:255'],
            'category' => ['required', 'in:booking,payment,vehicle,general'],
            'booking_id' => ['nullable', 'exists:bookings,id'],
            'message' => ['required', 'string', 'max:2000'],
            'priority' => ['required', 'in:low,medium,high'],
        ]);

        // For now, we'll just store this in the session and show a success message
        // In a real implementation, this would be stored in a support tickets table
        // and potentially sent via email to support staff
        
        session()->flash('support_request', [
            'subject' => $request->subject,
            'category' => $request->category,
            'booking_id' => $request->booking_id,
            'message' => $request->message,
            'priority' => $request->priority,
            'submitted_at' => now(),
        ]);

        return back()->with('success', 'Your support request has been submitted. We will contact you within 24 hours.');
    }
}