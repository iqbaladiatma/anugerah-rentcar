<div
    x-data="{
        show: false,
        message: '',
        type: 'success',
        init() {
            <?php if(session()->has('success')): ?>
                this.show = true;
                this.message = '<?php echo e(session('success')); ?>';
                this.type = 'success';
                setTimeout(() => { this.show = false }, 3000);
            <?php endif; ?>

            <?php if(session()->has('error')): ?>
                this.show = true;
                this.message = '<?php echo e(session('error')); ?>';
                this.type = 'error';
                setTimeout(() => { this.show = false }, 3000);
            <?php endif; ?>

            window.addEventListener('notify', event => {
                this.show = true;
                this.message = event.detail.message;
                this.type = event.detail.type || 'success';
                setTimeout(() => { this.show = false }, 3000);
            });
        }
    }"
    x-show="show"
    x-transition:enter="transform ease-out duration-300 transition"
    x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
    x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
    x-transition:leave="transition ease-in duration-100"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed bottom-0 right-0 z-50 m-6 w-full max-w-sm overflow-hidden rounded-lg shadow-lg"
    :class="{
        'bg-green-500': type === 'success',
        'bg-red-500': type === 'error',
        'bg-blue-500': type === 'info'
    }"
    style="display: none;"
>
    <div class="p-4">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <template x-if="type === 'success'">
                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </template>
                <template x-if="type === 'error'">
                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </template>
            </div>
            <div class="ml-3 w-0 flex-1 pt-0.5">
                <p x-text="message" class="text-sm font-medium text-white"></p>
            </div>
            <div class="ml-4 flex flex-shrink-0">
                <button @click="show = false" class="inline-flex rounded-md text-white hover:text-gray-200 focus:outline-none focus:ring-2 focus:ring-white">
                    <span class="sr-only">Close</span>
                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\laragon\www\anugerah-rentcar\resources\views/components/notification.blade.php ENDPATH**/ ?>