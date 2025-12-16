<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $roleFilter = '';
    public $statusFilter = '';
    public $showCreateModal = false;
    public $showEditModal = false;
    public $showDeleteModal = false;

    // Form fields
    public $selectedUser;
    public $name;
    public $email;
    public $phone;
    public $role;
    public $password;
    public $password_confirmation;
    public $is_active = true;

    protected $queryString = ['search', 'roleFilter', 'statusFilter'];

    protected $listeners = ['userDeleted' => '$refresh'];

    public function rules()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'role' => ['required', Rule::in([User::ROLE_ADMIN, User::ROLE_STAFF, User::ROLE_DRIVER])],
            'is_active' => 'boolean',
        ];

        if ($this->showCreateModal) {
            $rules['email'] = 'required|string|email|max:255|unique:users';
            $rules['password'] = 'required|string|min:8|confirmed';
        } else {
            $rules['email'] = ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($this->selectedUser?->id)];
            $rules['password'] = 'nullable|string|min:8|confirmed';
        }

        return $rules;
    }

    protected $messages = [
        'name.required' => 'Name is required.',
        'email.required' => 'Email is required.',
        'email.email' => 'Please enter a valid email address.',
        'email.unique' => 'This email is already registered.',
        'phone.required' => 'Phone number is required.',
        'role.required' => 'Role is required.',
        'role.in' => 'Please select a valid role.',
        'password.required' => 'Password is required.',
        'password.min' => 'Password must be at least 8 characters.',
        'password.confirmed' => 'Password confirmation does not match.',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingRoleFilter()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->showCreateModal = true;
    }

    public function openEditModal(User $user)
    {
        $this->selectedUser = $user;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->role = $user->role;
        $this->is_active = $user->is_active;
        $this->password = '';
        $this->password_confirmation = '';
        $this->showEditModal = true;
    }

    public function openDeleteModal(User $user)
    {
        $this->selectedUser = $user;
        $this->showDeleteModal = true;
    }

    public function closeModals()
    {
        $this->showCreateModal = false;
        $this->showEditModal = false;
        $this->showDeleteModal = false;
        $this->resetForm();
    }

    public function createUser()
    {
        $this->validate();

        try {
            $data = [
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'role' => $this->role,
                'password' => Hash::make($this->password),
                'is_active' => $this->is_active,
            ];

            $user = User::create($data);

            // Log the change
            $this->logSettingChange('user_created', [], $user->toArray());

            $this->closeModals();
            session()->flash('success', 'User created successfully.');
            
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to create user: ' . $e->getMessage());
        }
    }

    public function updateUser()
    {
        $this->validate();

        try {
            $oldValues = $this->selectedUser->toArray();

            $data = [
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'role' => $this->role,
                'is_active' => $this->is_active,
            ];

            if (!empty($this->password)) {
                $data['password'] = Hash::make($this->password);
            }

            $this->selectedUser->update($data);

            // Log the change
            $this->logSettingChange('user_updated', $oldValues, $this->selectedUser->fresh()->toArray());

            $this->closeModals();
            session()->flash('success', 'User updated successfully.');
            
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to update user: ' . $e->getMessage());
        }
    }

    public function deleteUser()
    {
        try {
            // Prevent deleting the current user
            if ($this->selectedUser->id === auth()->id()) {
                session()->flash('error', 'You cannot delete your own account.');
                $this->closeModals();
                return;
            }

            // Prevent deleting the last admin
            if ($this->selectedUser->isAdmin() && User::where('role', User::ROLE_ADMIN)->where('is_active', true)->count() <= 1) {
                session()->flash('error', 'Cannot delete the last active administrator.');
                $this->closeModals();
                return;
            }

            $oldValues = $this->selectedUser->toArray();
            $this->selectedUser->delete();

            // Log the change
            $this->logSettingChange('user_deleted', $oldValues, []);

            $this->closeModals();
            session()->flash('success', 'User deleted successfully.');
            
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to delete user: ' . $e->getMessage());
        }
    }

    public function toggleUserStatus(User $user)
    {
        try {
            // Prevent deactivating the current user
            if ($user->id === auth()->id()) {
                session()->flash('error', 'You cannot deactivate your own account.');
                return;
            }

            // Prevent deactivating the last admin
            if ($user->isAdmin() && $user->is_active && User::where('role', User::ROLE_ADMIN)->where('is_active', true)->count() <= 1) {
                session()->flash('error', 'Cannot deactivate the last active administrator.');
                return;
            }

            $oldValues = $user->toArray();
            $user->update(['is_active' => !$user->is_active]);

            // Log the change
            $this->logSettingChange('user_status_changed', $oldValues, $user->fresh()->toArray());

            $status = $user->is_active ? 'activated' : 'deactivated';
            session()->flash('success', "User {$status} successfully.");
            
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to update user status: ' . $e->getMessage());
        }
    }

    private function resetForm()
    {
        $this->selectedUser = null;
        $this->name = '';
        $this->email = '';
        $this->phone = '';
        $this->role = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->is_active = true;
        $this->resetErrorBag();
    }

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

    public function render()
    {
        $query = User::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', "%{$this->search}%")
                  ->orWhere('email', 'like', "%{$this->search}%")
                  ->orWhere('phone', 'like', "%{$this->search}%");
            });
        }

        if ($this->roleFilter) {
            $query->where('role', $this->roleFilter);
        }

        if ($this->statusFilter) {
            $isActive = $this->statusFilter === 'active';
            $query->where('is_active', $isActive);
        }

        $users = $query->orderBy('name')->paginate(15);

        return view('livewire.admin.user-management', [
            'users' => $users,
            'roles' => User::getRoles(),
        ]);
    }
}