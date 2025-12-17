<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Pengeluaran') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.expenses.edit', $expense) }}" 
                   class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Edit Pengeluaran
                </a>
                <form method="POST" action="{{ route('admin.expenses.destroy', $expense) }}" 
                      onsubmit="return confirm('Are you sure you want to delete this expense?')" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        Delete
                    </button>
                </form>
                <a href="{{ route('admin.expenses.index') }}" 
                   class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Back to Pengeluaran
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Expense Information -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Detail Pengeluaran</h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Kategori</label>
                                    <div class="mt-1">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $expense->category_display_name }}
                                        </span>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Deskripsi</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $expense->description }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Jumlah</label>
                                    <p class="mt-1 text-2xl font-bold text-green-600">
                                        {{ number_format($expense->amount, 0, ',', '.') }} IDR
                                    </p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Tanggal Pengeluaran</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $expense->expense_date->format('d F Y') }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Dibuat Oleh</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $expense->creator->name ?? 'Unknown' }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Dibuat Pada</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $expense->created_at->format('d F Y H:i') }}</p>
                                </div>

                                @if($expense->updated_at != $expense->created_at)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Terakhir Diperbarui</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $expense->updated_at->format('d F Y H:i') }}</p>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Receipt Photo -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Foto Receipt</h3>
                            
                            @if($expense->receipt_photo)
                                <div class="border rounded-lg p-4">
                                    <img src="{{ $expense->receipt_photo_url }}" 
                                         alt="Receipt for {{ $expense->description }}" 
                                         class="w-full rounded-lg shadow-md cursor-pointer"
                                         onclick="openImageModal(this.src)">
                                    <p class="mt-2 text-sm text-gray-500 text-center">
                                        Click to view full size
                                    </p>
                                </div>
                            @else
                                <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center">
                                    <x-icons.receipt-tax class="mx-auto h-12 w-12 text-gray-400" />
                                    <p class="mt-2 text-sm text-gray-500">Tidak ada foto receipt</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Image Modal -->
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 hidden z-50 flex items-center justify-center p-4">
        <div class="relative max-w-4xl max-h-full">
            <button onclick="closeImageModal()" 
                    class="absolute top-4 right-4 text-white hover:text-gray-300 text-2xl font-bold z-10">
                ×
            </button>
            <img id="modalImage" src="" alt="Receipt" class="max-w-full max-h-full rounded-lg">
        </div>
    </div>

    @push('scripts')
    <script>
        function openImageModal(src) {
            document.getElementById('modalImage').src = src;
            document.getElementById('imageModal').classList.remove('hidden');
        }

        function closeImageModal() {
            document.getElementById('imageModal').classList.add('hidden');
        }

        // Close modal when clicking outside the image
        document.getElementById('imageModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeImageModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeImageModal();
            }
        });
    </script>
    @endpush
</x-admin-layout>