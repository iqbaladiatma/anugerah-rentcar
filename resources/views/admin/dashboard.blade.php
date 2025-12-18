<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="animate-fade-in">
                <h1 class="heading-lg text-secondary-900">
                    Dashboard
                </h1>
                <p class="text-body mt-2">
                    Selamat datang kembali, {{ auth()->user()->name }}! Berikut adalah aktivitas bisnis rental Anda hari ini.
                </p>
            </div>
            <div class="flex items-center space-x-3">
                <span class="inline-flex items-center rounded-xl bg-accent-50 px-4 py-2 text-sm font-medium text-accent-700 border border-accent-200">
                    {{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
                </span>
            </div>
        </div>
    </x-slot>

    <livewire:admin.dashboard-stats />
</x-admin-layout>