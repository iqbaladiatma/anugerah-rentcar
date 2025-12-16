

<?php $__env->startSection('title', 'Vehicle Check-In'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Vehicle Check-In</h1>
                <p class="text-gray-600 mt-1">Process vehicle return for booking <?php echo e($booking->booking_number); ?></p>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($booking->isOverdue()): ?>
                    <div class="mt-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                            <i class="fas fa-exclamation-triangle mr-1"></i>
                            OVERDUE RETURN
                        </span>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
            <div class="flex space-x-3">
                <a href="<?php echo e(route('admin.bookings.show', $booking)); ?>" 
                   class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Booking
                </a>
            </div>
        </div>
    </div>

    <!-- Checkin Form Component -->
    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('admin.vehicle-checkin-form', ['booking' => $booking]);

$key = null;

$key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-2691670140-0', null);

$__html = app('livewire')->mount($__name, $__params, $key);

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .signature-canvas {
        border: 2px dashed #d1d5db;
        border-radius: 0.5rem;
        background-color: #ffffff;
    }
    
    .signature-canvas:hover {
        border-color: #9ca3af;
    }
    
    .damage-report {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        border-left: 4px solid #f59e0b;
    }
    
    .penalty-warning {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        border-left: 4px solid #ef4444;
    }
    
    .inspection-item {
        transition: all 0.2s ease-in-out;
    }
    
    .inspection-item:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
    
    .comparison-highlight {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        border-left: 4px solid #3b82f6;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    // Additional JavaScript for checkin form enhancements
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-save form data to localStorage
        const form = document.querySelector('form');
        if (form) {
            const formData = new FormData(form);
            const savedData = localStorage.getItem('checkin_form_<?php echo e($booking->id); ?>');
            
            if (savedData) {
                try {
                    const data = JSON.parse(savedData);
                    // Restore form data if needed
                } catch (e) {
                    console.log('Could not restore form data');
                }
            }
            
            // Save form data on change
            form.addEventListener('change', function() {
                const formData = new FormData(form);
                const data = Object.fromEntries(formData);
                localStorage.setItem('checkin_form_<?php echo e($booking->id); ?>', JSON.stringify(data));
            });
        }
        
        // Real-time penalty calculation
        const returnDateInput = document.querySelector('input[wire\\:model\\.live="inspectionData.actual_return_date"]');
        if (returnDateInput) {
            returnDateInput.addEventListener('change', function() {
                // Penalty calculation is handled by Livewire
                console.log('Return date changed, penalty will be recalculated');
            });
        }
        
        // Clear saved data when form is submitted successfully
        window.addEventListener('beforeunload', function() {
            if (document.querySelector('.alert-success')) {
                localStorage.removeItem('checkin_form_<?php echo e($booking->id); ?>');
            }
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\anugerah-rentcar\resources\views\admin\bookings\checkin.blade.php ENDPATH**/ ?>