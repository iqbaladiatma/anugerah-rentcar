<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KeyHandoverService
{
    /**
     * Process key handover (penyerahan kunci).
     *
     * @param Booking $booking
     * @param array $data
     * @return bool
     */
    public function serahKunci(Booking $booking, array $data): bool
    {
        DB::beginTransaction();
        
        try {
            // Upload foto kondisi
            $fotoPath = null;
            if (isset($data['foto_kondisi'])) {
                $fotoPath = $this->uploadFotoKondisi($data['foto_kondisi'], $booking->id, 'serah');
            }
            
            // Update booking
            $booking->update([
                'kunci_diserahkan' => true,
                'tanggal_serah_kunci' => Carbon::now(),
                'petugas_serah_kunci_id' => auth()->id(),
                'foto_serah_kunci' => $fotoPath,
                'catatan_serah_kunci' => $data['catatan'] ?? null,
                'tanda_tangan_customer' => $data['tanda_tangan'] ?? null,
                'booking_status' => Booking::STATUS_ACTIVE,
            ]);
            
            // Update car status
            $booking->car->update([
                'status' => 'rented',
            ]);
            
            // Send notification
            $this->sendNotificationSerahKunci($booking);
            
            DB::commit();
            return true;
            
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error serah kunci: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Process key return (pengembalian kunci).
     *
     * @param Booking $booking
     * @param array $data
     * @return bool
     */
    public function terimaKunci(Booking $booking, array $data): bool
    {
        DB::beginTransaction();
        
        try {
            // Upload foto kondisi
            $fotoPath = null;
            if (isset($data['foto_kondisi'])) {
                $fotoPath = $this->uploadFotoKondisi($data['foto_kondisi'], $booking->id, 'terima');
            }
            
            // Calculate additional fees
            $additionalFees = $this->calculateAdditionalFees($booking, $data);
            
            // Update booking
            $booking->update([
                'kunci_dikembalikan' => true,
                'tanggal_terima_kunci' => Carbon::now(),
                'petugas_terima_kunci_id' => auth()->id(),
                'foto_terima_kunci' => $fotoPath,
                'catatan_terima_kunci' => $data['catatan'] ?? null,
                'actual_return_date' => Carbon::now(),
                'booking_status' => Booking::STATUS_COMPLETED,
                'late_penalty' => $additionalFees['late_penalty'] ?? 0,
            ]);
            
            // Update car status
            $booking->car->update([
                'status' => 'available',
            ]);
            
            // Send notification
            $this->sendNotificationTerimaKunci($booking);
            
            DB::commit();
            return true;
            
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error terima kunci: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Upload foto kondisi kendaraan.
     *
     * @param mixed $files
     * @param int $bookingId
     * @param string $type
     * @return string|null
     */
    protected function uploadFotoKondisi($files, int $bookingId, string $type): ?string
    {
        try {
            $uploadedFiles = [];
            
            // Handle single or multiple files
            if (!is_array($files)) {
                $files = [$files];
            }
            
            foreach ($files as $index => $file) {
                $filename = "booking_{$bookingId}_{$type}_" . time() . "_{$index}." . $file->getClientOriginalExtension();
                $path = $file->storeAs("bookings/{$bookingId}/{$type}", $filename, 'public');
                $uploadedFiles[] = $path;
            }
            
            // Return JSON string of all uploaded files
            return json_encode($uploadedFiles);
            
        } catch (\Exception $e) {
            \Log::error('Error upload foto kondisi: ' . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Calculate additional fees (late penalty, damage, etc).
     *
     * @param Booking $booking
     * @param array $data
     * @return array
     */
    protected function calculateAdditionalFees(Booking $booking, array $data): array
    {
        $fees = [
            'late_penalty' => 0,
            'damage_fee' => 0,
            'total' => 0,
        ];
        
        // Calculate late penalty
        if (Carbon::now()->greaterThan($booking->end_date)) {
            $lateHours = $booking->end_date->diffInHours(Carbon::now());
            
            if ($lateHours <= 24) {
                // Hourly rate for first 24 hours
                $fees['late_penalty'] = $lateHours * 50000; // Rp 50.000 per jam
            } else {
                // Daily rate after 24 hours
                $lateDays = ceil($lateHours / 24);
                $fees['late_penalty'] = $lateDays * $booking->car->daily_rate * 1.5; // 150% dari harga normal
            }
        }
        
        // Damage fee from input
        if (isset($data['biaya_kerusakan']) && $data['biaya_kerusakan'] > 0) {
            $fees['damage_fee'] = $data['biaya_kerusakan'];
        }
        
        $fees['total'] = $fees['late_penalty'] + $fees['damage_fee'];
        
        return $fees;
    }
    
    /**
     * Send notification for key handover.
     *
     * @param Booking $booking
     * @return void
     */
    protected function sendNotificationSerahKunci(Booking $booking): void
    {
        // TODO: Implement notification
        // - Email to customer with berita acara
        // - SMS reminder (optional)
        // - Push notification (optional)
    }
    
    /**
     * Send notification for key return.
     *
     * @param Booking $booking
     * @return void
     */
    protected function sendNotificationTerimaKunci(Booking $booking): void
    {
        // TODO: Implement notification
        // - Email to customer with berita acara
        // - SMS thank you message (optional)
    }
    
    /**
     * Generate Berita Acara PDF.
     *
     * @param Booking $booking
     * @param string $type
     * @return string
     */
    public function generateBeritaAcara(Booking $booking, string $type = 'serah'): string
    {
        // TODO: Implement PDF generation
        // - Use DomPDF or similar
        // - Template: resources/views/pdf/berita-acara-{type}.blade.php
        // - Return PDF path or download response
        
        return '';
    }
}
