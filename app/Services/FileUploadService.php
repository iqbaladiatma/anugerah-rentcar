<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Traits\HandlesErrors;
use App\Exceptions\ExternalServiceException;
use Exception;

class FileUploadService
{
    use HandlesErrors;
    // File type configurations
    const ALLOWED_IMAGE_TYPES = ['jpg', 'jpeg', 'png', 'webp'];
    const ALLOWED_DOCUMENT_TYPES = ['pdf', 'doc', 'docx'];
    const ALLOWED_MIME_TYPES = [
        'image/jpeg',
        'image/png', 
        'image/webp',
        'application/pdf',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
    ];

    // Size limits (in bytes)
    const MAX_IMAGE_SIZE = 5 * 1024 * 1024; // 5MB
    const MAX_DOCUMENT_SIZE = 10 * 1024 * 1024; // 10MB
    
    // Image optimization settings
    const IMAGE_QUALITY = 85;
    const MAX_IMAGE_WIDTH = 1920;
    const MAX_IMAGE_HEIGHT = 1080;
    const THUMBNAIL_WIDTH = 300;
    const THUMBNAIL_HEIGHT = 200;

    protected ImageManager $imageManager;
    protected FileSecurityScannerService $securityScanner;

    public function __construct(FileSecurityScannerService $securityScanner = null)
    {
        $this->imageManager = new ImageManager(new Driver());
        $this->securityScanner = $securityScanner ?? app(FileSecurityScannerService::class);
    }

    /**
     * Upload and process a file with comprehensive security validation
     */
    public function uploadFile(
        UploadedFile $file, 
        string $directory, 
        string $disk = 'public',
        array $options = []
    ): array {
        try {
            // Perform security validation
            $validation = $this->validateFile($file, $options);
            if (!$validation['valid']) {
                return [
                    'success' => false,
                    'errors' => $validation['errors']
                ];
            }

            // Generate secure filename
            $filename = $this->generateSecureFilename($file, $options);
            $fullPath = $directory . '/' . $filename;

            // Process the file based on type
            if ($this->isImage($file)) {
                $result = $this->processImage($file, $fullPath, $disk, $options);
            } else {
                $result = $this->processDocument($file, $fullPath, $disk, $options);
            }

            if ($result['success']) {
                // Log successful upload
                Log::info('File uploaded successfully', [
                    'original_name' => $file->getClientOriginalName(),
                    'stored_path' => $result['path'],
                    'file_size' => $file->getSize(),
                    'mime_type' => $file->getMimeType()
                ]);
            }

            return $result;

        } catch (Exception $e) {
            Log::error('File upload failed', [
                'error' => $e->getMessage(),
                'file' => $file->getClientOriginalName()
            ]);

            return [
                'success' => false,
                'errors' => ['File upload failed: ' . $e->getMessage()]
            ];
        }
    }

    /**
     * Validate file security and constraints
     */
    public function validateFile(UploadedFile $file, array $options = []): array
    {
        $errors = [];

        // Check if file is valid
        if (!$file->isValid()) {
            $errors[] = 'Invalid file upload';
            return ['valid' => false, 'errors' => $errors];
        }

        // Validate file extension
        $extension = strtolower($file->getClientOriginalExtension());
        $allowedExtensions = $options['allowed_extensions'] ?? 
            array_merge(self::ALLOWED_IMAGE_TYPES, self::ALLOWED_DOCUMENT_TYPES);
        
        if (!in_array($extension, $allowedExtensions)) {
            $errors[] = 'File type not allowed. Allowed types: ' . implode(', ', $allowedExtensions);
        }

        // Validate MIME type with strict checking
        if (config('file-upload.security.strict_mime_validation', true)) {
            $mimeValidation = $this->validateMimeType($file, $options);
            if (!$mimeValidation['valid']) {
                $errors = array_merge($errors, $mimeValidation['errors']);
            }
        }

        // Validate file size
        $maxSize = $this->getMaxFileSize($file, $options);
        if ($file->getSize() > $maxSize) {
            $errors[] = 'File size exceeds limit of ' . $this->formatBytes($maxSize);
        }

        // Validate minimum file size (prevent empty files)
        $minSize = $options['min_size'] ?? 100; // 100 bytes minimum
        if ($file->getSize() < $minSize) {
            $errors[] = 'File is too small (minimum ' . $this->formatBytes($minSize) . ')';
        }

        // Validate filename for security
        $originalName = $file->getClientOriginalName();
        if ($this->hasUnsafeFilename($originalName)) {
            $errors[] = 'Filename contains unsafe characters';
        }

        // Check for double extensions
        if ($this->hasDoubleExtension($originalName)) {
            $errors[] = 'Files with double extensions are not allowed';
        }

        // Validate file headers match extension
        if (config('file-upload.validation.check_file_headers', true)) {
            $headerValidation = $this->validateFileHeaders($file);
            if (!$headerValidation['valid']) {
                $errors = array_merge($errors, $headerValidation['errors']);
            }
        }

        // Additional image validation
        if ($this->isImage($file)) {
            $imageValidation = $this->validateImage($file, $options);
            $errors = array_merge($errors, $imageValidation);
        }

        // Document-specific validation
        if ($this->isDocument($file)) {
            $documentValidation = $this->validateDocument($file, $options);
            $errors = array_merge($errors, $documentValidation);
        }

        // Comprehensive security scanning
        if ($options['security_scan'] ?? config('file-upload.security.virus_scan', false)) {
            $securityScan = $this->securityScanner->scanFile($file);
            if (!$securityScan['safe']) {
                $errors = array_merge($errors, $securityScan['threats']);
                
                // Log security event
                Log::warning('File upload blocked by comprehensive security scan', [
                    'file' => $file->getClientOriginalName(),
                    'size' => $file->getSize(),
                    'mime' => $file->getMimeType(),
                    'threats' => $securityScan['threats'],
                    'warnings' => $securityScan['warnings']
                ]);
            }
            
            // Log warnings even if file is considered safe
            if (!empty($securityScan['warnings'])) {
                Log::info('File upload security warnings', [
                    'file' => $file->getClientOriginalName(),
                    'warnings' => $securityScan['warnings']
                ]);
            }
        }

        // Legacy virus scanning (fallback)
        if ($options['virus_scan'] ?? false) {
            $virusCheck = $this->scanForVirus($file);
            if (!$virusCheck['clean']) {
                $errors[] = 'File failed virus scan: ' . ($virusCheck['reason'] ?? 'Unknown threat detected');
            }
        }

        // Quarantine suspicious files if enabled
        if (!empty($errors) && config('file-upload.security.quarantine_suspicious_files', false)) {
            $this->quarantineFile($file, $errors);
        }

        return [
            'valid' => empty($errors),
            'errors' => $errors
        ];
    }

    /**
     * Process and optimize image files
     */
    protected function processImage(UploadedFile $file, string $path, string $disk, array $options): array
    {
        try {
            // Load and process image
            $image = $this->imageManager->read($file->getPathname());
            
            // Get original dimensions
            $originalWidth = $image->width();
            $originalHeight = $image->height();

            // Resize if needed
            $maxWidth = $options['max_width'] ?? self::MAX_IMAGE_WIDTH;
            $maxHeight = $options['max_height'] ?? self::MAX_IMAGE_HEIGHT;
            
            if ($originalWidth > $maxWidth || $originalHeight > $maxHeight) {
                $image->scale(width: $maxWidth, height: $maxHeight);
            }

            // Set quality
            $quality = $options['quality'] ?? self::IMAGE_QUALITY;
            
            // Convert to JPEG for optimization (unless WebP is preferred)
            $format = $options['format'] ?? 'jpg';
            $processedPath = $this->changeFileExtension($path, $format);

            // Save optimized image
            $imageData = $image->toJpeg($quality);
            Storage::disk($disk)->put($processedPath, $imageData);

            $result = [
                'success' => true,
                'path' => $processedPath,
                'original_dimensions' => ['width' => $originalWidth, 'height' => $originalHeight],
                'final_dimensions' => ['width' => $image->width(), 'height' => $image->height()],
                'file_size' => Storage::disk($disk)->size($processedPath)
            ];

            // Generate thumbnail if requested
            if ($options['generate_thumbnail'] ?? false) {
                $thumbnailResult = $this->generateThumbnail($image, $processedPath, $disk, $options);
                $result['thumbnail'] = $thumbnailResult;
            }

            return $result;

        } catch (Exception $e) {
            Log::error('Image processing failed', [
                'error' => $e->getMessage(),
                'file' => $file->getClientOriginalName()
            ]);

            return [
                'success' => false,
                'errors' => ['Image processing failed: ' . $e->getMessage()]
            ];
        }
    }

    /**
     * Process document files
     */
    protected function processDocument(UploadedFile $file, string $path, string $disk, array $options): array
    {
        try {
            // Store document as-is with security checks
            $storedPath = $file->storeAs(dirname($path), basename($path), $disk);

            return [
                'success' => true,
                'path' => $storedPath,
                'file_size' => $file->getSize(),
                'mime_type' => $file->getMimeType()
            ];

        } catch (Exception $e) {
            return [
                'success' => false,
                'errors' => ['Document processing failed: ' . $e->getMessage()]
            ];
        }
    }

    /**
     * Generate thumbnail for images
     */
    protected function generateThumbnail($image, string $originalPath, string $disk, array $options): array
    {
        try {
            $thumbnailWidth = $options['thumbnail_width'] ?? self::THUMBNAIL_WIDTH;
            $thumbnailHeight = $options['thumbnail_height'] ?? self::THUMBNAIL_HEIGHT;
            
            // Create thumbnail
            $thumbnail = clone $image;
            $thumbnail->scale(width: $thumbnailWidth, height: $thumbnailHeight);
            
            // Generate thumbnail path
            $pathInfo = pathinfo($originalPath);
            $thumbnailPath = $pathInfo['dirname'] . '/thumb_' . $pathInfo['basename'];
            
            // Save thumbnail
            $thumbnailData = $thumbnail->toJpeg(self::IMAGE_QUALITY);
            Storage::disk($disk)->put($thumbnailPath, $thumbnailData);

            return [
                'success' => true,
                'path' => $thumbnailPath,
                'dimensions' => ['width' => $thumbnail->width(), 'height' => $thumbnail->height()]
            ];

        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => 'Thumbnail generation failed: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Generate secure filename
     */
    protected function generateSecureFilename(UploadedFile $file, array $options = []): string
    {
        $extension = strtolower($file->getClientOriginalExtension());
        $prefix = $options['prefix'] ?? '';
        $timestamp = now()->format('YmdHis');
        $random = Str::random(8);
        
        // Sanitize original name if preserving it
        if ($options['preserve_name'] ?? false) {
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $sanitizedName = $this->sanitizeFilename($originalName);
            return $prefix . $sanitizedName . '_' . $timestamp . '_' . $random . '.' . $extension;
        }
        
        return $prefix . $timestamp . '_' . $random . '.' . $extension;
    }

    /**
     * Sanitize filename for security
     */
    protected function sanitizeFilename(string $filename): string
    {
        // Remove or replace unsafe characters
        $filename = preg_replace('/[^a-zA-Z0-9\-_.]/', '_', $filename);
        $filename = preg_replace('/_{2,}/', '_', $filename); // Remove multiple underscores
        $filename = trim($filename, '_');
        
        return substr($filename, 0, 50); // Limit length
    }

    /**
     * Check if filename contains unsafe characters
     */
    protected function hasUnsafeFilename(string $filename): bool
    {
        // Check for path traversal attempts
        if (strpos($filename, '..') !== false) {
            return true;
        }
        
        // Check for null bytes
        if (strpos($filename, "\0") !== false) {
            return true;
        }
        
        // Check for executable extensions
        $dangerousExtensions = ['php', 'exe', 'bat', 'cmd', 'com', 'pif', 'scr', 'vbs', 'js'];
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        return in_array($extension, $dangerousExtensions);
    }

    /**
     * Check for double file extensions
     */
    protected function hasDoubleExtension(string $filename): bool
    {
        $parts = explode('.', $filename);
        
        // If more than 2 parts (name.ext1.ext2), check if any intermediate part is an extension
        if (count($parts) > 2) {
            $dangerousExtensions = config('file-upload.validation.blocked_extensions', [
                'php', 'php3', 'php4', 'php5', 'phtml',
                'exe', 'bat', 'cmd', 'com', 'pif', 'scr',
                'vbs', 'js', 'jar', 'sh', 'py', 'pl'
            ]);
            
            // Check all parts except the last one (which is the real extension)
            for ($i = 1; $i < count($parts) - 1; $i++) {
                if (in_array(strtolower($parts[$i]), $dangerousExtensions)) {
                    return true;
                }
            }
        }
        
        return false;
    }

    /**
     * Validate MIME type with strict checking
     */
    protected function validateMimeType(UploadedFile $file, array $options = []): array
    {
        $errors = [];
        $mimeType = $file->getMimeType();
        $extension = strtolower($file->getClientOriginalExtension());
        
        // Define expected MIME types for extensions
        $expectedMimes = [
            'jpg' => ['image/jpeg'],
            'jpeg' => ['image/jpeg'],
            'png' => ['image/png'],
            'webp' => ['image/webp'],
            'pdf' => ['application/pdf'],
            'doc' => ['application/msword'],
            'docx' => ['application/vnd.openxmlformats-officedocument.wordprocessingml.document']
        ];
        
        if (isset($expectedMimes[$extension])) {
            if (!in_array($mimeType, $expectedMimes[$extension])) {
                $errors[] = "File extension '{$extension}' does not match MIME type '{$mimeType}'";
            }
        }
        
        // Check allowed MIME types
        $allowedMimes = $options['allowed_mimes'] ?? self::ALLOWED_MIME_TYPES;
        if (!in_array($mimeType, $allowedMimes)) {
            $errors[] = 'Invalid file format detected';
        }
        
        return [
            'valid' => empty($errors),
            'errors' => $errors
        ];
    }

    /**
     * Validate file headers match the claimed file type
     */
    protected function validateFileHeaders(UploadedFile $file): array
    {
        $errors = [];
        $extension = strtolower($file->getClientOriginalExtension());
        
        // Read first few bytes to check file signature
        $handle = fopen($file->getRealPath(), 'rb');
        if (!$handle) {
            return ['valid' => false, 'errors' => ['Cannot read file headers']];
        }
        
        $header = fread($handle, 16);
        fclose($handle);
        
        // Define file signatures (magic numbers)
        $signatures = [
            'jpg' => ["\xFF\xD8\xFF"],
            'jpeg' => ["\xFF\xD8\xFF"],
            'png' => ["\x89\x50\x4E\x47\x0D\x0A\x1A\x0A"],
            'webp' => ["RIFF", "WEBP"],
            'pdf' => ["%PDF"],
            'doc' => ["\xD0\xCF\x11\xE0\xA1\xB1\x1A\xE1"],
            'docx' => ["PK\x03\x04"]
        ];
        
        if (isset($signatures[$extension])) {
            $validSignature = false;
            
            foreach ($signatures[$extension] as $signature) {
                if (strpos($header, $signature) === 0) {
                    $validSignature = true;
                    break;
                }
            }
            
            if (!$validSignature) {
                $errors[] = "File header does not match extension '{$extension}'";
            }
        }
        
        return [
            'valid' => empty($errors),
            'errors' => $errors
        ];
    }

    /**
     * Validate image-specific constraints
     */
    protected function validateImage(UploadedFile $file, array $options = []): array
    {
        $errors = [];
        
        try {
            $imageInfo = getimagesize($file->getPathname());
            
            if ($imageInfo === false) {
                $errors[] = 'Invalid image file';
                return $errors;
            }
            
            [$width, $height] = $imageInfo;
            
            // Check minimum dimensions
            $minWidth = $options['min_width'] ?? 100;
            $minHeight = $options['min_height'] ?? 100;
            
            if ($width < $minWidth || $height < $minHeight) {
                $errors[] = "Image must be at least {$minWidth}x{$minHeight} pixels";
            }
            
            // Check maximum dimensions
            $maxWidth = $options['max_width'] ?? 5000;
            $maxHeight = $options['max_height'] ?? 5000;
            
            if ($width > $maxWidth || $height > $maxHeight) {
                $errors[] = "Image must not exceed {$maxWidth}x{$maxHeight} pixels";
            }
            
        } catch (Exception $e) {
            $errors[] = 'Unable to validate image properties';
        }
        
        return $errors;
    }

    /**
     * Validate document-specific constraints
     */
    protected function validateDocument(UploadedFile $file, array $options = []): array
    {
        $errors = [];
        $extension = strtolower($file->getClientOriginalExtension());
        
        // PDF-specific validation
        if ($extension === 'pdf') {
            $pdfValidation = $this->validatePdf($file);
            $errors = array_merge($errors, $pdfValidation);
        }
        
        return $errors;
    }

    /**
     * Validate PDF files for security
     */
    protected function validatePdf(UploadedFile $file): array
    {
        $errors = [];
        
        try {
            $content = file_get_contents($file->getRealPath());
            
            // Check for suspicious JavaScript in PDF
            if (preg_match('/\/JavaScript|\/JS|\/OpenAction/i', $content)) {
                $errors[] = 'PDF contains potentially dangerous JavaScript';
            }
            
            // Check for embedded files
            if (preg_match('/\/EmbeddedFile/i', $content)) {
                $errors[] = 'PDF contains embedded files which are not allowed';
            }
            
            // Check for forms
            if (preg_match('/\/AcroForm|\/XFA/i', $content)) {
                Log::info('PDF contains forms', ['file' => $file->getClientOriginalName()]);
            }
            
        } catch (Exception $e) {
            Log::warning('PDF validation failed', [
                'file' => $file->getClientOriginalName(),
                'error' => $e->getMessage()
            ]);
        }
        
        return $errors;
    }

    /**
     * Scan file for viruses and malware
     */
    protected function scanForVirus(UploadedFile $file): array
    {
        try {
            // Check if ClamAV is available
            if (config('file-upload.security.virus_scan') && $this->isClamAvAvailable()) {
                return $this->scanWithClamAv($file);
            }
            
            // Fallback to basic security checks
            return $this->performBasicSecurityScan($file);
            
        } catch (Exception $e) {
            Log::error('Virus scan failed', [
                'file' => $file->getClientOriginalName(),
                'error' => $e->getMessage()
            ]);
            
            // Fail safe - treat as suspicious if scan fails
            return [
                'clean' => false,
                'reason' => 'Scan failed: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Check if ClamAV is available
     */
    protected function isClamAvAvailable(): bool
    {
        if (!function_exists('exec')) {
            return false;
        }
        
        $output = [];
        $returnCode = 0;
        exec('clamscan --version 2>&1', $output, $returnCode);
        
        return $returnCode === 0;
    }

    /**
     * Scan file with ClamAV
     */
    protected function scanWithClamAv(UploadedFile $file): array
    {
        $filePath = $file->getRealPath();
        $output = [];
        $returnCode = 0;
        
        // Run ClamAV scan
        exec("clamscan --no-summary --infected --stdout " . escapeshellarg($filePath) . " 2>&1", $output, $returnCode);
        
        $outputString = implode("\n", $output);
        
        // ClamAV return codes: 0 = clean, 1 = infected, 2 = error
        switch ($returnCode) {
            case 0:
                return ['clean' => true];
            case 1:
                Log::warning('Virus detected in uploaded file', [
                    'file' => $file->getClientOriginalName(),
                    'scan_result' => $outputString
                ]);
                return [
                    'clean' => false,
                    'reason' => 'Virus detected: ' . $outputString
                ];
            default:
                Log::error('ClamAV scan error', [
                    'file' => $file->getClientOriginalName(),
                    'output' => $outputString,
                    'return_code' => $returnCode
                ]);
                return [
                    'clean' => false,
                    'reason' => 'Scan error occurred'
                ];
        }
    }

    /**
     * Perform basic security scan without antivirus
     */
    protected function performBasicSecurityScan(UploadedFile $file): array
    {
        $suspiciousPatterns = [
            // PHP code patterns
            '/<\?php/',
            '/<\?=/',
            '/eval\s*\(/',
            '/exec\s*\(/',
            '/system\s*\(/',
            '/shell_exec\s*\(/',
            '/passthru\s*\(/',
            
            // JavaScript patterns
            '/<script[^>]*>/',
            '/javascript:/',
            '/vbscript:/',
            '/onload\s*=/',
            '/onerror\s*=/',
            
            // Executable signatures
            '/^MZ/', // PE executable
            '/^PK/', // ZIP/JAR (could contain executables)
            '/^\x7fELF/', // ELF executable
        ];
        
        // Read first 1KB of file for pattern matching
        $handle = fopen($file->getRealPath(), 'rb');
        if (!$handle) {
            return ['clean' => false, 'reason' => 'Cannot read file'];
        }
        
        $content = fread($handle, 1024);
        fclose($handle);
        
        foreach ($suspiciousPatterns as $pattern) {
            if (preg_match($pattern, $content)) {
                Log::warning('Suspicious pattern detected in uploaded file', [
                    'file' => $file->getClientOriginalName(),
                    'pattern' => $pattern
                ]);
                
                return [
                    'clean' => false,
                    'reason' => 'Suspicious content detected'
                ];
            }
        }
        
        return ['clean' => true];
    }

    /**
     * Quarantine suspicious files
     */
    protected function quarantineFile(UploadedFile $file, array $errors): void
    {
        try {
            $quarantinePath = storage_path('app/quarantine');
            
            if (!is_dir($quarantinePath)) {
                mkdir($quarantinePath, 0755, true);
            }
            
            $quarantineFilename = 'quarantine_' . time() . '_' . Str::random(8) . '.bin';
            $quarantineFullPath = $quarantinePath . '/' . $quarantineFilename;
            
            copy($file->getRealPath(), $quarantineFullPath);
            
            Log::warning('File quarantined due to security issues', [
                'original_name' => $file->getClientOriginalName(),
                'quarantine_path' => $quarantineFullPath,
                'errors' => $errors,
                'file_size' => $file->getSize(),
                'mime_type' => $file->getMimeType()
            ]);
            
        } catch (Exception $e) {
            Log::error('Failed to quarantine suspicious file', [
                'file' => $file->getClientOriginalName(),
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Check if file is an image
     */
    protected function isImage(UploadedFile $file): bool
    {
        $extension = strtolower($file->getClientOriginalExtension());
        return in_array($extension, self::ALLOWED_IMAGE_TYPES);
    }

    /**
     * Check if file is a document
     */
    protected function isDocument(UploadedFile $file): bool
    {
        $extension = strtolower($file->getClientOriginalExtension());
        return in_array($extension, self::ALLOWED_DOCUMENT_TYPES);
    }

    /**
     * Get maximum file size based on file type
     */
    protected function getMaxFileSize(UploadedFile $file, array $options = []): int
    {
        if (isset($options['max_size'])) {
            return $options['max_size'];
        }
        
        return $this->isImage($file) ? self::MAX_IMAGE_SIZE : self::MAX_DOCUMENT_SIZE;
    }

    /**
     * Change file extension
     */
    protected function changeFileExtension(string $path, string $newExtension): string
    {
        $pathInfo = pathinfo($path);
        return $pathInfo['dirname'] . '/' . $pathInfo['filename'] . '.' . $newExtension;
    }

    /**
     * Format bytes to human readable format
     */
    protected function formatBytes(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        
        $bytes /= (1 << (10 * $pow));
        
        return round($bytes, 2) . ' ' . $units[$pow];
    }

    /**
     * Delete file and its thumbnail if exists
     */
    public function deleteFile(string $path, string $disk = 'public'): bool
    {
        try {
            $deleted = Storage::disk($disk)->delete($path);
            
            // Try to delete thumbnail if exists
            $pathInfo = pathinfo($path);
            $thumbnailPath = $pathInfo['dirname'] . '/thumb_' . $pathInfo['basename'];
            
            if (Storage::disk($disk)->exists($thumbnailPath)) {
                Storage::disk($disk)->delete($thumbnailPath);
            }
            
            return $deleted;
            
        } catch (Exception $e) {
            Log::error('File deletion failed', [
                'path' => $path,
                'error' => $e->getMessage()
            ]);
            
            return false;
        }
    }

    /**
     * Get file URL
     */
    public function getFileUrl(string $path, string $disk = 'public'): ?string
    {
        try {
            return Storage::disk($disk)->url($path);
        } catch (Exception $e) {
            return null;
        }
    }
}