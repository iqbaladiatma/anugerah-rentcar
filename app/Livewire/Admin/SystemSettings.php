<?php

namespace App\Livewire\Admin;

use App\Models\Setting;
use Livewire\Component;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;

class SystemSettings extends Component
{
    public $maintenance_mode = false;
    public $cache_enabled = true;
    public $debug_mode = false;
    public $log_level = 'info';
    public $session_lifetime = 120;
    public $max_upload_size = 2048;

    protected $rules = [
        'session_lifetime' => 'required|integer|min:5|max:1440',
        'max_upload_size' => 'required|integer|min:1|max:10240',
        'log_level' => 'required|in:emergency,alert,critical,error,warning,notice,info,debug',
    ];

    protected $messages = [
        'session_lifetime.required' => 'Session lifetime is required.',
        'session_lifetime.integer' => 'Session lifetime must be a number.',
        'session_lifetime.min' => 'Session lifetime must be at least 5 minutes.',
        'session_lifetime.max' => 'Session lifetime cannot exceed 1440 minutes (24 hours).',
        'max_upload_size.required' => 'Maximum upload size is required.',
        'max_upload_size.integer' => 'Maximum upload size must be a number.',
        'max_upload_size.min' => 'Maximum upload size must be at least 1 KB.',
        'max_upload_size.max' => 'Maximum upload size cannot exceed 10 MB.',
        'log_level.required' => 'Log level is required.',
        'log_level.in' => 'Please select a valid log level.',
    ];

    public function mount()
    {
        // Load current system settings
        $this->maintenance_mode = app()->isDownForMaintenance();
        $this->cache_enabled = config('cache.default') !== 'array';
        $this->debug_mode = config('app.debug', false);
        $this->log_level = config('logging.channels.single.level', 'info');
        $this->session_lifetime = config('session.lifetime', 120);
        $this->max_upload_size = (int) (ini_get('upload_max_filesize') ?: 2048);
    }

    public function toggleMaintenanceMode()
    {
        try {
            $oldValue = $this->maintenance_mode;
            
            if ($this->maintenance_mode) {
                Artisan::call('up');
                $this->maintenance_mode = false;
                $message = 'Maintenance mode disabled.';
            } else {
                Artisan::call('down', ['--render' => 'errors::503']);
                $this->maintenance_mode = true;
                $message = 'Maintenance mode enabled.';
            }

            // Log the change
            $this->logSettingChange('maintenance_mode_toggled', 
                ['maintenance_mode' => $oldValue], 
                ['maintenance_mode' => $this->maintenance_mode]
            );

            session()->flash('success', $message);
            
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to toggle maintenance mode: ' . $e->getMessage());
        }
    }

    public function clearCache()
    {
        try {
            Artisan::call('cache:clear');
            Artisan::call('config:clear');
            Artisan::call('route:clear');
            Artisan::call('view:clear');

            // Log the change
            $this->logSettingChange('cache_cleared', [], []);

            session()->flash('success', 'All caches cleared successfully.');
            
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to clear cache: ' . $e->getMessage());
        }
    }

    public function optimizeSystem()
    {
        try {
            Artisan::call('config:cache');
            Artisan::call('route:cache');
            Artisan::call('view:cache');

            // Log the change
            $this->logSettingChange('system_optimized', [], []);

            session()->flash('success', 'System optimized successfully.');
            
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to optimize system: ' . $e->getMessage());
        }
    }

    public function runMigrations()
    {
        try {
            Artisan::call('migrate', ['--force' => true]);

            // Log the change
            $this->logSettingChange('migrations_run', [], []);

            session()->flash('success', 'Database migrations completed successfully.');
            
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to run migrations: ' . $e->getMessage());
        }
    }

    public function getSystemInfo()
    {
        return [
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown',
            'database_connection' => config('database.default'),
            'cache_driver' => config('cache.default'),
            'session_driver' => config('session.driver'),
            'queue_driver' => config('queue.default'),
            'mail_driver' => config('mail.default'),
            'timezone' => config('app.timezone'),
            'locale' => config('app.locale'),
            'environment' => config('app.env'),
            'debug_mode' => config('app.debug') ? 'Enabled' : 'Disabled',
            'maintenance_mode' => app()->isDownForMaintenance() ? 'Enabled' : 'Disabled',
        ];
    }

    public function getCacheInfo()
    {
        try {
            $cacheSize = 0;
            $cacheKeys = 0;
            
            // This is a simplified cache info - in production you might want more detailed stats
            if (Cache::getStore() instanceof \Illuminate\Cache\RedisStore) {
                // Redis cache info would go here
                $cacheSize = 'Redis Cache';
            } else {
                $cacheSize = 'File Cache';
            }

            return [
                'cache_driver' => config('cache.default'),
                'cache_size' => $cacheSize,
                'cache_keys' => $cacheKeys,
            ];
        } catch (\Exception $e) {
            return [
                'cache_driver' => config('cache.default'),
                'cache_size' => 'Unknown',
                'cache_keys' => 'Unknown',
            ];
        }
    }

    private function logSettingChange(string $action, array $oldValues, array $newValues)
    {
        \Log::info('Settings Change', [
            'action' => $action,
            'user_id' => auth()->id(),
            'user_name' => auth()->user()->name,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'timestamp' => now(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    public function render()
    {
        return view('livewire.admin.system-settings', [
            'systemInfo' => $this->getSystemInfo(),
            'cacheInfo' => $this->getCacheInfo(),
        ]);
    }
}