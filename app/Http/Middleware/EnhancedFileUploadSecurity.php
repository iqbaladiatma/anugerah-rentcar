<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\Response;
use App\Services\FileUploadService;
use App\Services\FileSecurityScannerService;
use Illuminate\Support\Facades\Log;

class EnhancedFileUploadSecurity
{
    protected FileUploadService $fileUploadService;
    protected FileSecurityScannerService $securityScanner;

    public function __construct(
        FileUploadService $fileUploadService,
        FileSecurityScannerService $securityScanner
    ) {
        $this->fileUploadService = $fileUploadService;
        $this->securityScanner = $securityScanner;
    }

    /**
     * Handle an incoming request with enhanced file upload security
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if request has file uploads
        if ($request->hasFile()) {
            $files = $this->getAllUploadedFiles($request);
            
            foreach ($files as $fieldName => $file) {
                if ($file instanceof UploadedFile) {
                    // Perform comprehensive security validation
                    $securityResult = $this->performSecurityChecks($file, $fieldName);
                    
                    if (!$securityResult['safe']) {
                        return $this->createSecurityResponse($securityResult, $fieldName);
                    }
                }
            }
        }

        return $next($request);
    }

    /**
     * Perform comprehensive security checks on uploaded file
     */
    protected function performSecurityChecks(UploadedFile $file, string $fieldName): array
    {
        $results = [
            'safe' => true,
            'errors' => [],
            'warnings' => [],
            'blocked_reason' => null
        ];

        // Basic file validation
        $basicValidation = $this->fileUploadService->validateFile($file, [
            'virus_scan' => config('file-upload.security.virus_scan', false),
            'security_scan' => true
        ]);

        if (!$basicValidation['valid']) {
            $results['safe'] = false;
            $results['errors'] = $basicValidation['errors'];
            $results['blocked_reason'] = 'Basic validation failed';
            return $results;
        }

        // Enhanced security scanning
        if (config('file-upload.security.enhanced_scanning', true)) {
            $securityScan = $this->securityScanner->scanFile($file);
            
            if (!$securityScan['safe']) {
                $results['safe'] = false;
                $results['errors'] = array_merge($results['errors'], $securityScan['threats']);
                $results['blocked_reason'] = 'Security threats detected';
                
                // Log security incident
                Log::warning('File upload blocked by enhanced security middleware', [
                    'field' => $fieldName,
                    'file' => $file->getClientOriginalName(),
                    'size' => $file->getSize(),
                    'mime' => $file->getMimeType(),
                    'threats' => $securityScan['threats'],
                    'ip' => request()->ip(),
                    'user_agent' => request()->userAgent()
                ]);
            }
            
            $results['warnings'] = $securityScan['warnings'] ?? [];
        }

        // Rate limiting check
        if (!$this->checkUploadRateLimit($file)) {
            $results['safe'] = false;
            $results['errors'][] = 'Upload rate limit exceeded';
            $results['blocked_reason'] = 'Rate limit exceeded';
        }

        // File size bomb check
        if ($this->isFileSizeBomb($file)) {
            $results['safe'] = false;
            $results['errors'][] = 'File appears to be a compression bomb';
            $results['blocked_reason'] = 'Compression bomb detected';
        }

        return $results;
    }

    /**
     * Check upload rate limiting
     */
    protected function checkUploadRateLimit(UploadedFile $file): bool
    {
        $cacheKey = 'upload_rate_limit:' . request()->ip();
        $maxUploads = config('file-upload.rate_limiting.max_uploads_per_minute', 10);
        $maxSize = config('file-upload.rate_limiting.max_size_per_minute', 50 * 1024 * 1024); // 50MB
        
        $currentUploads = cache()->get($cacheKey . ':count', 0);
        $currentSize = cache()->get($cacheKey . ':size', 0);
        
        if ($currentUploads >= $maxUploads) {
            return false;
        }
        
        if (($currentSize + $file->getSize()) > $maxSize) {
            return false;
        }
        
        // Update counters
        cache()->put($cacheKey . ':count', $currentUploads + 1, 60);
        cache()->put($cacheKey . ':size', $currentSize + $file->getSize(), 60);
        
        return true;
    }

    /**
     * Check if file might be a compression bomb
     */
    protected function isFileSizeBomb(UploadedFile $file): bool
    {
        $extension = strtolower($file->getClientOriginalExtension());
        $compressibleTypes = ['zip', 'rar', '7z', 'tar', 'gz', 'bz2'];
        
        if (!in_array($extension, $compressibleTypes)) {
            return false;
        }
        
        // Check if file is suspiciously small for its claimed type
        $fileSize = $file->getSize();
        $maxCompressedSize = config('file-upload.security.max_compressed_size', 10 * 1024 * 1024); // 10MB
        
        if ($fileSize > $maxCompressedSize) {
            return true;
        }
        
        // Additional checks could be added here for specific archive types
        return false;
    }

    /**
     * Create security response for blocked uploads
     */
    protected function createSecurityResponse(array $securityResult, string $fieldName): Response
    {
        $response = [
            'error' => 'File upload blocked for security reasons',
            'field' => $fieldName,
            'reason' => $securityResult['blocked_reason'],
            'details' => $securityResult['errors']
        ];

        // Don't expose detailed security information in production
        if (app()->environment('production')) {
            $response = [
                'error' => 'File upload failed security validation',
                'field' => $fieldName
            ];
        }

        return response()->json($response, 422);
    }

    /**
     * Get all uploaded files from request
     */
    protected function getAllUploadedFiles(Request $request): array
    {
        $files = [];
        
        foreach ($request->allFiles() as $key => $file) {
            if (is_array($file)) {
                foreach ($file as $index => $subFile) {
                    $files["{$key}.{$index}"] = $subFile;
                }
            } else {
                $files[$key] = $file;
            }
        }
        
        return $files;
    }
}