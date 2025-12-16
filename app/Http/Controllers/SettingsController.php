<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class SettingsController extends Controller
{
    /**
     * Check if user can manage settings.
     */
    private function checkPermission()
    {
        if (!auth()->user() || !auth()->user()->canManageSettings()) {
            abort(403, 'Unauthorized access to settings.');
        }
    }

    /**
     * Show company settings page.
     */
    public function company()
    {
        $this->checkPermission();
        return view('admin.settings.company');
    }

    /**
     * Show user management page.
     */
    public function users()
    {
        $this->checkPermission();
        return view('admin.settings.users');
    }

    /**
     * Show pricing configuration page.
     */
    public function pricing()
    {
        $this->checkPermission();
        return view('admin.settings.pricing');
    }

    /**
     * Show system configuration page.
     */
    public function system()
    {
        $this->checkPermission();
        return view('admin.settings.system');
    }

    /**
     * Update company settings.
     */
    public function updateCompany(Request $request)
    {
        $this->checkPermission();
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'company_address' => 'required|string|max:1000',
            'company_phone' => 'required|string|max:20',
            'company_logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $settings = Setting::current();
        $oldValues = $settings->toArray();

        // Handle logo upload
        if ($request->hasFile('company_logo')) {
            // Delete old logo if exists
            if ($settings->company_logo) {
                Storage::disk('public')->delete($settings->company_logo);
            }
            
            $logoPath = $request->file('company_logo')->store('company', 'public');
            $validated['company_logo'] = $logoPath;
        }

        $settings = Setting::updateSettings($validated);

        // Log the change
        $this->logSettingChange('company_settings', $oldValues, $settings->toArray());

        return response()->json([
            'success' => true,
            'message' => 'Company settings updated successfully.',
            'settings' => $settings
        ]);
    }

    /**
     * Update pricing configuration.
     */
    public function updatePricing(Request $request)
    {
        $this->checkPermission();
        $validated = $request->validate([
            'late_penalty_per_hour' => 'required|numeric|min:0|max:999999.99',
            'buffer_time_hours' => 'required|integer|min:0|max:24',
            'member_discount_percentage' => 'required|numeric|min:0|max:100',
        ]);

        $settings = Setting::current();
        $oldValues = $settings->toArray();

        $settings = Setting::updateSettings($validated);

        // Log the change
        $this->logSettingChange('pricing_configuration', $oldValues, $settings->toArray());

        return response()->json([
            'success' => true,
            'message' => 'Pricing configuration updated successfully.',
            'settings' => $settings
        ]);
    }

    /**
     * Get all users for management.
     */
    public function getUsersList(Request $request)
    {
        $this->checkPermission();
        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->get('role'));
        }

        if ($request->filled('status')) {
            $isActive = $request->get('status') === 'active';
            $query->where('is_active', $isActive);
        }

        $users = $query->orderBy('name')->paginate(15);

        return response()->json($users);
    }

    /**
     * Create a new user.
     */
    public function createUser(Request $request)
    {
        $this->checkPermission();
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'role' => ['required', Rule::in([User::ROLE_ADMIN, User::ROLE_STAFF, User::ROLE_DRIVER])],
            'password' => 'required|string|min:8|confirmed',
            'is_active' => 'boolean',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['is_active'] = $validated['is_active'] ?? true;

        $user = User::create($validated);

        // Log the change
        $this->logSettingChange('user_created', [], $user->toArray());

        return response()->json([
            'success' => true,
            'message' => 'User created successfully.',
            'user' => $user
        ]);
    }

    /**
     * Update an existing user.
     */
    public function updateUser(Request $request, User $user)
    {
        $this->checkPermission();
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => 'required|string|max:20',
            'role' => ['required', Rule::in([User::ROLE_ADMIN, User::ROLE_STAFF, User::ROLE_DRIVER])],
            'password' => 'nullable|string|min:8|confirmed',
            'is_active' => 'boolean',
        ]);

        $oldValues = $user->toArray();

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $validated['is_active'] = $validated['is_active'] ?? $user->is_active;

        $user->update($validated);

        // Log the change
        $this->logSettingChange('user_updated', $oldValues, $user->fresh()->toArray());

        return response()->json([
            'success' => true,
            'message' => 'User updated successfully.',
            'user' => $user->fresh()
        ]);
    }

    /**
     * Delete a user.
     */
    public function deleteUser(User $user)
    {
        $this->checkPermission();
        // Prevent deleting the current user
        if ($user->id === auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot delete your own account.'
            ], 422);
        }

        // Prevent deleting the last admin
        if ($user->isAdmin() && User::where('role', User::ROLE_ADMIN)->where('is_active', true)->count() <= 1) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete the last active administrator.'
            ], 422);
        }

        $oldValues = $user->toArray();
        $user->delete();

        // Log the change
        $this->logSettingChange('user_deleted', $oldValues, []);

        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully.'
        ]);
    }

    /**
     * Toggle user active status.
     */
    public function toggleUserStatus(User $user)
    {
        $this->checkPermission();
        // Prevent deactivating the current user
        if ($user->id === auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot deactivate your own account.'
            ], 422);
        }

        // Prevent deactivating the last admin
        if ($user->isAdmin() && $user->is_active && User::where('role', User::ROLE_ADMIN)->where('is_active', true)->count() <= 1) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot deactivate the last active administrator.'
            ], 422);
        }

        $oldValues = $user->toArray();
        $user->update(['is_active' => !$user->is_active]);

        // Log the change
        $this->logSettingChange('user_status_changed', $oldValues, $user->fresh()->toArray());

        return response()->json([
            'success' => true,
            'message' => 'User status updated successfully.',
            'user' => $user->fresh()
        ]);
    }

    /**
     * Log setting changes for audit trail.
     */
    private function logSettingChange(string $action, array $oldValues, array $newValues)
    {
        \Log::info('Settings Change', [
            'action' => $action,
            'user_id' => auth()->id(),
            'user_name' => auth()->user()->name,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'timestamp' => now(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}