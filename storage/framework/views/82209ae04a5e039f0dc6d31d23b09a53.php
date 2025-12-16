<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['class' => 'h-5 w-5']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['class' => 'h-5 w-5']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<svg class="<?php echo e($class); ?>" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 15.75V18m-7.5-6.75h.008v.008H8.25v-.008Zm0 2.25h.008v.008H8.25V13.5Zm0 2.25h.008v.008H8.25v-.008Zm0 2.25h.008V18H8.25v-.008ZM12 13.5h.008v.008H12V13.5Zm0 2.25h.008v.008H12V15.75Zm0 2.25h.008V18H12v-.008ZM15.75 13.5h.008v.008h-.008V13.5Zm0 2.25h.008v.008h-.008V15.75ZM6 7.5h12l-.75 9a2.25 2.25 0 0 1-2.25 2.25h-6A2.25 2.25 0 0 1 6.75 16.5L6 7.5ZM6 4.125C6 3.504 6.504 3 7.125 3h9.75C17.496 3 18 3.504 18 4.125v2.25C18 7.496 17.496 8 16.875 8h-9.75A1.125 1.125 0 0 1 6 6.375v-2.25Z" />
</svg><?php /**PATH C:\laragon\www\anugerah-rentcar\resources\views\components\icons\calculator.blade.php ENDPATH**/ ?>