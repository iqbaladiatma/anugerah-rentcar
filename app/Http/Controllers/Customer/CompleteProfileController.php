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
                ->with('info', 'Your profile is already complete.');
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
            'phone.required' => 'Phone number is required',
            'nik.required' => 'NIK (ID Number) is required',
            'nik.size' => 'NIK must be exactly 16 digits',
            'nik.unique' => 'This NIK is already registered',
            'address.required' => 'Address is required',
            'ktp_photo.required' => 'KTP photo is required',
            'ktp_photo.image' => 'KTP photo must be an image',
            'ktp_photo.max' => 'KTP photo must not exceed 2MB',
            'sim_photo.required' => 'SIM photo is required',
            'sim_photo.image' => 'SIM photo must be an image',
            'sim_photo.max' => 'SIM photo must not exceed 2MB',
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
        
        // Mark profile as completed
        $validated['profile_completed'] = true;
        
        // Update customer
        $customer->update($validated);
        
        return redirect()->route('customer.dashboard')
            ->with('success', 'Profile completed successfully! You can now access all features.');
    }
}
