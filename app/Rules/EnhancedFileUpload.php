<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\UploadedFile;
use App\Services\FileUploadService;
use App\Services\FileSecurityScannerService;

class EnhancedFileUpload implements ValidationRule
{
    protected array $options;
    protected FileUploadService $fileUploadService;
    protected FileSecurityScannerService $securityScanner;

    public function __construct(array $options = [])
    {
        $this->options = $options;
        $this->fileUploadService = app(FileUploadService::class);
        $this->securityScanner = app(FileSecurityScannerService::class);
    }

    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$value instanceof UploadedFile) {
            $fail('The file must be a valid upload.');
            return;
        }

        // Basic file validation
        $validation = $this->fileUploadService->validateFile($value, $this->options);
        
        if (!$validation['valid']) {
            foreach ($validation['errors'] as $error) {
                $fail($error);
            }
            return;
        }

        // Enhanced security scanning if enabled
        if ($this->options['enhanced_security'] ?? true) {
            $securityScan = $this->securityScanner->scanFile($value);
            
            if (!$securityScan['safe']) {
                foreach ($securityScan['threats'] as $threat) {
                    $fail("Security threat detected: {$threat}");
                }
            }
        }
    }

    /**
     * Create rule for vehicle photos
     */
    public static function vehiclePhoto(): self
    {
        return new self([
            'allowed_extensions' => ['jpg', 'jpeg', 'png', 'webp'],
            'allowed_mimes' => ['image/jpeg', 'image/png', 'image/webp'],
            'max_size' => 5 * 1024 * 1024, // 5MB
            'min_width' => 400,
            'min_height' => 300,
            'max_width' => 2048,
            'max_height' => 1536,
            'enhanced_security' => true,
            'virus_scan' => true
        ]);
    }

    /**
     * Create rule for customer documents
     */
    public static function customerDocument(): self
    {
        return new self([
            'allowed_extensions' => ['jpg', 'jpeg', 'png', 'pdf'],
            'allowed_mimes' => [
                'image/jpeg',
                'image/png',
                'application/pdf'
            ],
            'max_size' => 10 * 1024 * 1024, // 10MB
            'min_width' => 300,
            'min_height' => 200,
            'enhanced_security' => true,
            'virus_scan' => true,
            'security_scan' => true
        ]);
    }

    /**
     * Create rule for inspection photos
     */
    public static function inspectionPhoto(): self
    {
        return new self([
            'allowed_extensions' => ['jpg', 'jpeg', 'png'],
            'allowed_mimes' => ['image/jpeg', 'image/png'],
            'max_size' => 5 * 1024 * 1024, // 5MB
            'min_width' => 400,
            'min_height' => 300,
            'enhanced_security' => true,
            'virus_scan' => true
        ]);
    }

    /**
     * Create rule for receipts and documents
     */
    public static function receipt(): self
    {
        return new self([
            'allowed_extensions' => ['jpg', 'jpeg', 'png', 'pdf'],
            'allowed_mimes' => [
                'image/jpeg',
                'image/png',
                'application/pdf'
            ],
            'max_size' => 5 * 1024 * 1024, // 5MB
            'enhanced_security' => true,
            'virus_scan' => true,
            'security_scan' => true
        ]);
    }

    /**
     * Create rule with strict security for sensitive documents
     */
    public static function strictSecurity(): self
    {
        return new self([
            'allowed_extensions' => ['pdf'],
            'allowed_mimes' => ['application/pdf'],
            'max_size' => 2 * 1024 * 1024, // 2MB
            'enhanced_security' => true,
            'virus_scan' => true,
            'security_scan' => true,
            'strict_mime_validation' => true
        ]);
    }
}