<?php

namespace App\Livewire\Admin;

use App\Models\Booking;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

class BookingList extends Component
{
    use WithPagination;

    // Component state
    public $selected_bookings = [];
    public $select_all = false;
    public $show_actions = false;
    public $bulk_action = '';

    // Modal state
    public $show_confirm_modal = false;
    public $show_cancel_modal = false;
    public $show_delete_modal = false;
    public $confirm_booking_id = null;
    public $cancel_booking_id = null;
    public $delete_booking_id = null;
    public $cancellation_reason = '';
    public $delete_reason = '';

    // Quick filters
    public $quick_filter = '';

    protected $listeners = [
        'bookingUpdated' => 'refreshBookings',
        'bookingCreated' => 'refreshBookings',
    ];

    public function mount()
    {
        //
    }

    public function updatedSelectAll()
    {
        if ($this->select_all) {
            $this->selected_bookings = $this->getBookings()->pluck('id')->toArray();
        } else {
            $this->selected_bookings = [];
        }
        
        $this->updateShowActions();
    }

    public function updatedSelectedBookings()
    {
        $this->updateShowActions();
        
        // Update select all checkbox state
        $totalBookings = $this->getBookings()->count();
        $this->select_all = count($this->selected_bookings) === $totalBookings && $totalBookings > 0;
    }

    public function updatedQuickFilter()
    {
        $this->resetPage();
    }

    public function updateShowActions()
    {
        $this->show_actions = count($this->selected_bookings) > 0;
    }

    public function getBookings()
    {
        $query = Booking::with(['customer:id,name,phone', 'car:id,license_plate,brand,model', 'driver:id,name'])
            ->orderBy('created_at', 'desc');

        // Apply quick filter
        if (!empty($this->quick_filter)) {
            switch ($this->quick_filter) {
                case 'pending':
                    $query->where('booking_status', Booking::STATUS_PENDING);
                    break;
                case 'confirmed':
                    $query->where('booking_status', Booking::STATUS_CONFIRMED);
                    break;
                case 'active':
                    $query->where('booking_status', Booking::STATUS_ACTIVE);
                    break;
                case 'overdue':
                    $query->overdue();
                    break;
                case 'today_checkout':
                    $query->whereDate('start_date', Carbon::today())
                          ->where('booking_status', Booking::STATUS_CONFIRMED);
                    break;
                case 'today_checkin':
                    $query->whereDate('end_date', Carbon::today())
                          ->where('booking_status', Booking::STATUS_ACTIVE);
                    break;
                case 'walkin':
                    $query->where('booking_type', Booking::TYPE_WALKIN);
                    break;
                case 'online':
                    $query->where('booking_type', Booking::TYPE_ONLINE);
                    break;
            }
        }

        return $query->paginate(15);
    }

    public function confirmBooking($bookingId)
    {
        $this->confirm_booking_id = $bookingId;
        $this->show_confirm_modal = true;
    }

    public function processConfirmation()
    {
        $booking = Booking::findOrFail($this->confirm_booking_id);
        
        if ($booking->booking_status !== Booking::STATUS_PENDING) {
            session()->flash('error', 'Only pending bookings can be confirmed.');
            $this->closeConfirmModal();
            return;
        }

        try {
            $booking->confirm();
            session()->flash('success', 'Booking confirmed successfully.');
            $this->dispatch('bookingUpdated');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to confirm booking: ' . $e->getMessage());
        }

        $this->closeConfirmModal();
    }

    public function closeConfirmModal()
    {
        $this->show_confirm_modal = false;
        $this->confirm_booking_id = null;
    }

    public function cancelBooking($bookingId)
    {
        $this->cancel_booking_id = $bookingId;
        $this->cancellation_reason = '';
        $this->show_cancel_modal = true;
    }

    public function processCancellation()
    {
        $this->validate([
            'cancellation_reason' => 'nullable|string|max:500',
        ]);

        $booking = Booking::findOrFail($this->cancel_booking_id);
        
        if (!$booking->canBeCancelled()) {
            session()->flash('error', 'This booking cannot be cancelled.');
            $this->closeCancelModal();
            return;
        }

        try {
            if (!empty($this->cancellation_reason)) {
                $booking->update(['notes' => $this->cancellation_reason]);
            }
            
            $booking->cancel();
            session()->flash('success', 'Booking cancelled successfully.');
            $this->dispatch('bookingUpdated');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to cancel booking: ' . $e->getMessage());
        }

        $this->closeCancelModal();
    }

    public function closeCancelModal()
    {
        $this->show_cancel_modal = false;
        $this->cancel_booking_id = null;
        $this->cancellation_reason = '';
    }

    // Delete Booking Methods
    public function deleteBooking($bookingId)
    {
        $this->delete_booking_id = $bookingId;
        $this->delete_reason = '';
        $this->show_delete_modal = true;
    }

    public function processDelete()
    {
        $this->validate([
            'delete_reason' => 'required|string|min:10|max:500',
        ], [
            'delete_reason.required' => 'Alasan penghapusan wajib diisi.',
            'delete_reason.min' => 'Alasan minimal 10 karakter.',
        ]);

        $booking = Booking::findOrFail($this->delete_booking_id);

        try {
            // Log the deletion reason before deleting
            \Log::info("Booking {$booking->booking_number} deleted by admin. Reason: {$this->delete_reason}");
            
            $bookingNumber = $booking->booking_number;
            $booking->delete();
            
            session()->flash('success', "Pemesanan {$bookingNumber} berhasil dihapus.");
            $this->dispatch('bookingUpdated');
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menghapus pemesanan: ' . $e->getMessage());
        }

        $this->closeDeleteModal();
    }

    public function closeDeleteModal()
    {
        $this->show_delete_modal = false;
        $this->delete_booking_id = null;
        $this->delete_reason = '';
    }

    public function activateBooking($bookingId)
    {
        $booking = Booking::findOrFail($bookingId);
        
        if ($booking->booking_status !== Booking::STATUS_CONFIRMED) {
            session()->flash('error', 'Only confirmed bookings can be activated.');
            return;
        }

        try {
            $booking->activate();
            session()->flash('success', 'Booking activated successfully. Vehicle is now checked out.');
            $this->dispatch('bookingUpdated');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to activate booking: ' . $e->getMessage());
        }
    }

    public function completeBooking($bookingId)
    {
        $booking = Booking::findOrFail($bookingId);
        
        if ($booking->booking_status !== Booking::STATUS_ACTIVE) {
            session()->flash('error', 'Only active bookings can be completed.');
            return;
        }

        try {
            $booking->update(['actual_return_date' => Carbon::now()]);
            $booking->updateLatePenalty();
            $booking->complete();
            session()->flash('success', 'Booking completed successfully.');
            $this->dispatch('bookingUpdated');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to complete booking: ' . $e->getMessage());
        }
    }

    public function processBulkAction()
    {
        if (empty($this->bulk_action) || empty($this->selected_bookings)) {
            return;
        }

        $bookings = Booking::whereIn('id', $this->selected_bookings)->get();
        $processed = 0;
        $errors = [];

        foreach ($bookings as $booking) {
            try {
                switch ($this->bulk_action) {
                    case 'confirm':
                        if ($booking->booking_status === Booking::STATUS_PENDING) {
                            $booking->confirm();
                            $processed++;
                        }
                        break;
                    
                    case 'cancel':
                        if ($booking->canBeCancelled()) {
                            $booking->cancel();
                            $processed++;
                        }
                        break;
                }
            } catch (\Exception $e) {
                $errors[] = "Booking {$booking->booking_number}: " . $e->getMessage();
            }
        }

        if ($processed > 0) {
            session()->flash('success', "Successfully processed {$processed} booking(s).");
        }

        if (!empty($errors)) {
            session()->flash('error', 'Some bookings could not be processed: ' . implode(', ', $errors));
        }

        $this->selected_bookings = [];
        $this->select_all = false;
        $this->bulk_action = '';
        $this->show_actions = false;
        $this->dispatch('bookingUpdated');
    }

    public function refreshBookings()
    {
        // Reset selections and refresh the component
        $this->selected_bookings = [];
        $this->select_all = false;
        $this->show_actions = false;
    }

    public function getStatusBadgeClass($status)
    {
        return match($status) {
            Booking::STATUS_PENDING => 'bg-yellow-100 text-yellow-800',
            Booking::STATUS_CONFIRMED => 'bg-blue-100 text-blue-800',
            Booking::STATUS_ACTIVE => 'bg-green-100 text-green-800',
            Booking::STATUS_COMPLETED => 'bg-gray-100 text-gray-800',
            Booking::STATUS_CANCELLED => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    public function getPaymentStatusBadgeClass($status)
    {
        return match($status) {
            Booking::PAYMENT_PENDING => 'bg-yellow-100 text-yellow-800',
            Booking::PAYMENT_PARTIAL => 'bg-orange-100 text-orange-800',
            Booking::PAYMENT_PAID => 'bg-green-100 text-green-800',
            Booking::PAYMENT_REFUNDED => 'bg-purple-100 text-purple-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    public function isOverdue($booking)
    {
        return $booking->booking_status === Booking::STATUS_ACTIVE && 
               Carbon::now() > Carbon::parse($booking->end_date);
    }

    public function formatCurrency($amount)
    {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }

    public function getQuickFilterOptions()
    {
        return [
            '' => 'Semua Pemesanan',
            'pending' => 'Menunggu Konfirmasi',
            'confirmed' => 'Terkonfirmasi',
            'active' => 'Sedang Aktif',
            'overdue' => 'Terlambat Kembali',
            'today_checkout' => 'Checkout Hari Ini',
            'today_checkin' => 'Check-in Hari Ini',
            'walkin' => 'Walk-in',
            'online' => 'Online',
        ];
    }

    public function getBulkActionOptions()
    {
        return [
            '' => 'Pilih Aksi',
            'confirm' => 'Konfirmasi Pemesanan',
            'cancel' => 'Batalkan Pemesanan',
        ];
    }

    public function render()
    {
        return view('livewire.admin.booking-list', [
            'bookings' => $this->getBookings(),
        ]);
    }
}