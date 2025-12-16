#!/usr/bin/env php
<?php

/**
 * Test Script untuk Unified Login System
 * 
 * Script ini akan memvalidasi bahwa:
 * 1. Hanya ada 1 route 'login'
 * 2. Tidak ada route 'customer.login'
 * 3. Route 'login' mengarah ke UnifiedLoginController
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "🔍 Testing Unified Login System...\n\n";

// Test 1: Check login route exists
echo "Test 1: Checking login route...\n";
$loginRoute = Route::getRoutes()->getByName('login');
if ($loginRoute) {
    echo "✅ Route 'login' exists\n";
    echo "   URI: " . $loginRoute->uri() . "\n";
    echo "   Methods: " . implode(', ', $loginRoute->methods()) . "\n";
    echo "   Action: " . $loginRoute->getActionName() . "\n";
    
    // Check if it uses UnifiedLoginController
    if (strpos($loginRoute->getActionName(), 'UnifiedLoginController') !== false) {
        echo "✅ Using UnifiedLoginController\n";
    } else {
        echo "❌ NOT using UnifiedLoginController\n";
    }
} else {
    echo "❌ Route 'login' NOT found\n";
}

echo "\n";

// Test 2: Check customer.login route does NOT exist
echo "Test 2: Checking customer.login route should NOT exist...\n";
$customerLoginRoute = Route::getRoutes()->getByName('customer.login');
if (!$customerLoginRoute) {
    echo "✅ Route 'customer.login' does NOT exist (as expected)\n";
} else {
    echo "❌ Route 'customer.login' still exists (should be removed)\n";
    echo "   URI: " . $customerLoginRoute->uri() . "\n";
}

echo "\n";

// Test 3: Check logout route
echo "Test 3: Checking logout route...\n";
$logoutRoute = Route::getRoutes()->getByName('logout');
if ($logoutRoute) {
    echo "✅ Route 'logout' exists\n";
    echo "   URI: " . $logoutRoute->uri() . "\n";
    echo "   Methods: " . implode(', ', $logoutRoute->methods()) . "\n";
    
    // Check if it uses UnifiedLoginController
    if (strpos($logoutRoute->getActionName(), 'UnifiedLoginController') !== false) {
        echo "✅ Using UnifiedLoginController\n";
    } else {
        echo "⚠️  Using different controller: " . $logoutRoute->getActionName() . "\n";
    }
} else {
    echo "❌ Route 'logout' NOT found\n";
}

echo "\n";

// Test 4: Check auth guards
echo "Test 4: Checking auth guards configuration...\n";
$guards = config('auth.guards');
if (isset($guards['web'])) {
    echo "✅ Guard 'web' configured\n";
    echo "   Provider: " . $guards['web']['provider'] . "\n";
}
if (isset($guards['customer'])) {
    echo "✅ Guard 'customer' configured\n";
    echo "   Provider: " . $guards['customer']['provider'] . "\n";
}

echo "\n";

// Test 5: Check providers
echo "Test 5: Checking auth providers configuration...\n";
$providers = config('auth.providers');
if (isset($providers['users'])) {
    echo "✅ Provider 'users' configured\n";
    echo "   Model: " . $providers['users']['model'] . "\n";
}
if (isset($providers['customers'])) {
    echo "✅ Provider 'customers' configured\n";
    echo "   Model: " . $providers['customers']['model'] . "\n";
}

echo "\n";

// Summary
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "📊 SUMMARY\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";

$totalTests = 5;
$passedTests = 0;

if ($loginRoute && strpos($loginRoute->getActionName(), 'UnifiedLoginController') !== false) {
    $passedTests++;
}

if (!$customerLoginRoute) {
    $passedTests++;
}

if ($logoutRoute) {
    $passedTests++;
}

if (isset($guards['web']) && isset($guards['customer'])) {
    $passedTests++;
}

if (isset($providers['users']) && isset($providers['customers'])) {
    $passedTests++;
}

echo "Tests Passed: $passedTests / $totalTests\n";

if ($passedTests === $totalTests) {
    echo "✅ All tests PASSED! Unified login system is ready!\n";
    exit(0);
} else {
    echo "❌ Some tests FAILED. Please review the configuration.\n";
    exit(1);
}
