<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Access Denied - Anugerah Rentcar</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full bg-white rounded-lg shadow-lg p-8 text-center">
        <div class="mb-6">
            <div class="mx-auto w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728"></path>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-900 mb-2">Access Denied</h1>
            <p class="text-gray-600 mb-6">
                You don't have permission to access this resource.
            </p>
        </div>

        <div class="space-y-4">
            <div class="bg-red-50 rounded-lg p-4 text-left">
                <h3 class="font-semibold text-red-900 mb-2">Possible reasons:</h3>
                <ul class="text-sm text-red-700 space-y-1">
                    <li>• Insufficient user privileges</li>
                    <li>• Session has expired</li>
                    <li>• Account restrictions</li>
                    <li>• Resource requires different access level</li>
                </ul>
            </div>

            <div class="flex space-x-3">
                <button 
                    onclick="window.history.back()" 
                    class="flex-1 bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors"
                >
                    Go Back
                </button>
                <a 
                    href="<?php echo e(route('login')); ?>" 
                    class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors text-center"
                >
                    Login
                </a>
            </div>

            <a 
                href="<?php echo e(route('dashboard')); ?>" 
                class="block w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors"
            >
                Return to Dashboard
            </a>
        </div>

        <div class="mt-6 pt-6 border-t border-gray-200">
            <p class="text-xs text-gray-500">
                Request ID: <?php echo e(request()->header('X-Request-ID', 'N/A')); ?><br>
                User: <?php echo e(auth()->user()?->email ?? 'Guest'); ?><br>
                Time: <?php echo e(now()->format('Y-m-d H:i:s')); ?>

            </p>
        </div>
    </div>
</body>
</html><?php /**PATH C:\laragon\www\anugerah-rentcar\resources\views\errors\403.blade.php ENDPATH**/ ?>