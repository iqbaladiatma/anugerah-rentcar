<?php

namespace App\Providers;

use App\Services\FileUploadService;
use App\Services\FileSecurityScannerService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\UploadedFile;

class FileUploadServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(FileSecurityScannerService::class, function ($app) {
            return new FileSecurityScannerService();
        });
        
        $this->app->singleton(FileUploadService::class, function ($app) {
            return new FileUploadService($app->make(FileSecurityScannerService::class));
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Register custom validation rules
        Validator::extend('secure_file', function ($attribute, $value, $parameters, $validator) {
            if (!$value instanceof UploadedFile) {
                return false;
            }

            $fileUploadService = app(FileUploadService::class);
            $options = [];
            
            // Parse parameters if provided
            if (!empty($parameters)) {
                $options = $this->parseValidationParameters($parameters);
            }

            $validation = $fileUploadService->validateFile($value, $options);
            
            if (!$validation['valid']) {
                // Set custom error messages
                $validator->setCustomMessages([
                    'secure_file' => implode(' ', $validation['errors'])
                ]);
            }

            return $validation['valid'];
        });

        // Register file size validation
        Validator::extend('file_max_size', function ($attribute, $value, $parameters, $validator) {
            if (!$value instanceof UploadedFile || empty($parameters[0])) {
                return false;
            }

            $maxSize = (int) $parameters[0];
            return $value->getSize() <= $maxSize;
        });

        // Register image dimension validation
        Validator::extend('image_dimensions_secure', function ($attribute, $value, $parameters, $validator) {
            if (!$value instanceof UploadedFile) {
                return false;
            }

            try {
                $imageInfo = getimagesize($value->getPathname());
                if ($imageInfo === false) {
                    return false;
                }

                [$width, $height] = $imageInfo;
                
                // Parse parameters: min_width,min_height,max_width,max_height
                if (count($parameters) >= 4) {
                    $minWidth = (int) $parameters[0];
                    $minHeight = (int) $parameters[1];
                    $maxWidth = (int) $parameters[2];
                    $maxHeight = (int) $parameters[3];
                    
                    return $width >= $minWidth && $height >= $minHeight && 
                           $width <= $maxWidth && $height <= $maxHeight;
                }

                return true;
            } catch (\Exception $e) {
                return false;
            }
        });

        // Schedule file cleanup
        if ($this->app->runningInConsole()) {
            $this->commands([
                \App\Console\Commands\CleanupTempFiles::class,
            ]);
        }
    }

    /**
     * Parse validation parameters
     */
    protected function parseValidationParameters(array $parameters): array
    {
        $options = [];
        
        foreach ($parameters as $param) {
            if (strpos($param, '=') !== false) {
                [$key, $value] = explode('=', $param, 2);
                
                // Handle array values
                if (strpos($value, ',') !== false) {
                    $options[$key] = explode(',', $value);
                } else {
                    // Handle boolean and numeric values
                    if ($value === 'true') {
                        $options[$key] = true;
                    } elseif ($value === 'false') {
                        $options[$key] = false;
                    } elseif (is_numeric($value)) {
                        $options[$key] = is_float($value) ? (float) $value : (int) $value;
                    } else {
                        $options[$key] = $value;
                    }
                }
            }
        }
        
        return $options;
    }
}