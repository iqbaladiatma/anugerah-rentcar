<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
                    Dashboard
                </h1>
                <p class="mt-1 text-sm text-gray-500">
                    Welcome back, {{ auth()->user()->name }}! Here's what's happening with your rental business today.
                </p>
            </div>
            <div class="flex items-center space-x-3">
                <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
                    {{ now()->format('l, F j, Y') }}
                </span>
            </div>
        </div>
    </x-slot>

    <livewire:admin.dashboard-stats />
</x-admin-layout>