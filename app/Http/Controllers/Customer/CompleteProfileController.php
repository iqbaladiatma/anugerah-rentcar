<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File;

class CompleteProfileController extends Controller
{
    /**
     * Show the complete profile form.
     */
    public function show()
    {
        $customer = auth('customer')->user();
        
        // If already completed, redirect to dashboard
        if ($customer->profile_completed) {
            return redirect()->route('customer.dashboard')
                ->with('info', 'Profil Anda sudah lengkap.');
        }
        
        return view('customer.complete-profile', compact('customer'));
    }
    
    /**
     * Update the customer profile.
     */
    public function update(Request $request)
    {
        $customer = auth('customer')->user();
        
        $validated = $request->validate([
            'phone' => ['required', 'string', 'max:20'],
            'nik' => ['required', 'string', 'size:16', 'unique:customers,nik,' . $customer->id],
            'address' => ['required', 'string', 'max:500'],
            'ktp_photo' => ['required', File::image()->max(2048)],
            'sim_photo' => ['required', File::image()->max(2048)],
        ], [
            'phone.required' => 'Nomor telepon wajib diisi',
            'nik.required' => 'NIK wajib diisi',
            'nik.size' => 'NIK harus tepat 16 digit',
            'nik.unique' => 'NIK ini sudah terdaftar',
            'address.required' => 'Alamat wajib diisi',
            'ktp_photo.required' => 'Foto KTP wajib diunggah',
            'ktp_photo.image' => 'Foto KTP harus berupa gambar',
            'ktp_photo.max' => 'Foto KTP tidak boleh melebihi 2MB',
            'sim_photo.required' => 'Foto SIM wajib diunggah',
            'sim_photo.image' => 'Foto SIM harus berupa gambar',
            'sim_photo.max' => 'Foto SIM tidak boleh melebihi 2MB',
        ]);
        
        // Handle KTP photo upload
        if ($request->hasFile('ktp_photo')) {
            // Delete old photo if exists
            if ($customer->ktp_photo) {
                Storage::disk('public')->delete($customer->ktp_photo);
            }
            
            $ktpPath = $request->file('ktp_photo')->store('customers/ktp', 'public');
            $validated['ktp_photo'] = $ktpPath;
        }
        
        // Handle SIM photo upload
        if ($request->hasFile('sim_photo')) {
            // Delete old photo if exists
            if ($customer->sim_photo) {
                Storage::disk('public')->delete($customer->sim_photo);
            }
            
            $simPath = $request->file('sim_photo')->store('customers/sim', 'public');
            $validated['sim_photo'] = $simPath;
        }
        
        // Update customer with specific fields only
        $customer->phone = $validated['phone'];
        $customer->nik = $validated['nik'];
        $customer->address = $validated['address'];
        $customer->ktp_photo = $validated['ktp_photo'];
        $customer->sim_photo = $validated['sim_photo'];
        $customer->profile_completed = true;
        $customer->save();
        
        return redirect()->route('customer.dashboard')
            ->with('success', 'Profil berhasil dilengkapi! Anda sekarang dapat mengakses semua fitur.');
    }
}
