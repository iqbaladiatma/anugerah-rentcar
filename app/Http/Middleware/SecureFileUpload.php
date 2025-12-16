<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\Response;
use App\Services\FileUploadService;

class SecureFileUpload
{
    protected FileUploadService $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if request has file uploads
        if ($request->hasFile()) {
            $files = $this->getAllUploadedFiles($request);
            
            foreach ($files as $fieldName => $file) {
                if ($file instanceof UploadedFile) {
                    // Perform comprehensive security validation
                    $validation = $this->fileUploadService->validateFile($file, [
                        'virus_scan' => config('file-upload.security.virus_scan', false),
                        'strict_mime_validation' => config('file-upload.security.strict_mime_validation', true)
                    ]);
                    
                    if (!$validation['valid']) {
                        // Log security violation
                        \Log::warning('File upload security violation', [
                            'field' => $fieldName,
                            'file' => $file->getClientOriginalName(),
                            'size' => $file->getSize(),
                            'mime' => $file->getMimeType(),
                            'errors' => $validation['errors'],
                            'ip' => $request->ip(),
                            'user_agent' => $request->userAgent()
                        ]);

                        // Return appropriate response based on request type
                        if ($request->expectsJson() || $request->ajax()) {
                            return response()->json([
                                'error' => 'File upload security validation failed',
                                'field' => $fieldName,
                                'errors' => $validation['errors']
                            ], 422);
                        } else {
                            return redirect()->back()
                                ->withErrors([$fieldName => $validation['errors']])
                                ->withInput();
                        }
                    }
                }
            }
        }

        return $next($request);
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