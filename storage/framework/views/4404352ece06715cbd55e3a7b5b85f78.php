<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Not Found - Anugerah Rentcar</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full bg-white rounded-lg shadow-lg p-8 text-center">
        <div class="mb-6">
            <div class="mx-auto w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.34 0-4.29-1.009-5.824-2.562M15 9.75a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-900 mb-2">Page Not Found</h1>
            <p class="text-gray-600 mb-6">
                The page you're looking for doesn't exist or has been moved.
            </p>
        </div>

        <div class="space-y-4">
            <div class="bg-gray-50 rounded-lg p-4 text-left">
                <h3 class="font-semibold text-gray-900 mb-2">Suggestions:</h3>
                <ul class="text-sm text-gray-600 space-y-1">
                    <li>• Check the URL for typos</li>
                    <li>• Use the navigation menu</li>
                    <li>• Return to the homepage</li>
                    <li>• Contact support if you believe this is an error</li>
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
                    href="<?php echo e(route('dashboard')); ?>" 
                    class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors text-center"
                >
                    Dashboard
                </a>
            </div>

            <a 
                href="<?php echo e(url('/')); ?>" 
                class="block w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors"
            >
                Return to Homepage
            </a>
        </div>

        <div class="mt-6 pt-6 border-t border-gray-200">
            <p class="text-xs text-gray-500">
                Request ID: <?php echo e(request()->header('X-Request-ID', 'N/A')); ?><br>
                Time: <?php echo e(now()->format('Y-m-d H:i:s')); ?>

            </p>
        </div>
    </div>
</body>
</html><?php /**PATH C:\laragon\www\anugerah-rentcar\resources\views/errors/404.blade.php ENDPATH**/ ?>