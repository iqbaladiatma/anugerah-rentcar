<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Server Error - Anugerah Rentcar</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full bg-white rounded-lg shadow-lg p-8 text-center">
        <div class="mb-6">
            <div class="mx-auto w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-900 mb-2">Server Error</h1>
            <p class="text-gray-600 mb-6">
                We're experiencing some technical difficulties. Our team has been notified and is working to resolve the issue.
            </p>
        </div>

        <div class="space-y-4">
            <div class="bg-gray-50 rounded-lg p-4 text-left">
                <h3 class="font-semibold text-gray-900 mb-2">What you can do:</h3>
                <ul class="text-sm text-gray-600 space-y-1">
                    <li>• Try refreshing the page</li>
                    <li>• Go back to the previous page</li>
                    <li>• Contact our support team if the problem persists</li>
                </ul>
            </div>

            <div class="flex space-x-3">
                <button 
                    onclick="window.history.back()" 
                    class="flex-1 bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors"
                >
                    Go Back
                </button>
                <button 
                    onclick="window.location.reload()" 
                    class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors"
                >
                    Refresh Page
                </button>
            </div>

            <a 
                href="<?php echo e(route('admin.dashboard')); ?>" 
                class="block w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors"
            >
                Return to Dashboard
            </a>
        </div>

        <div class="mt-6 pt-6 border-t border-gray-200">
            <p class="text-xs text-gray-500">
                Error ID: <?php echo e(request()->header('X-Request-ID', 'N/A')); ?><br>
                Time: <?php echo e(now()->format('Y-m-d H:i:s')); ?>

            </p>
        </div>
    </div>

    <script>
        // Auto-refresh after 30 seconds if user doesn't interact
        let refreshTimer = setTimeout(() => {
            if (confirm('Would you like to refresh the page to try again?')) {
                window.location.reload();
            }
        }, 30000);

        // Clear timer if user interacts with the page
        document.addEventListener('click', () => {
            clearTimeout(refreshTimer);
        });
    </script>
</body>
</html><?php /**PATH C:\laragon\www\anugerah-rentcar\resources\views\errors\500.blade.php ENDPATH**/ ?>