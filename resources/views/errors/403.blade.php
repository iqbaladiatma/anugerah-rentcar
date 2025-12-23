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
                    href="{{ route('login') }}" 
                    class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors text-center"
                >
                    Login
                </a>
            </div>

            <a 
                href="{{ route('dashboard') }}" 
                class="block w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors"
            >
                Return to Dashboard
            </a>
        </div>

        <div class="mt-6 pt-6 border-t border-gray-200">
            <p class="text-xs text-gray-500">
                Request ID: {{ request()->header('X-Request-ID', 'N/A') }}<br>
                User: {{ auth()->user()?->email ?? 'Guest' }}<br>
                Time: {{ now()->format('Y-m-d H:i:s') }}
            </p>
        </div>
    </div>
</body>
</html>