<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\UploadedFile;
use App\Services\FileUploadService;

class SecureFileUpload implements ValidationRule
{
    protected array $options;
    protected FileUploadService $fileUploadService;

    public function __construct(array $options = [])
    {
        $this->options = $options;
        $this->fileUploadService = app(FileUploadService::class);
    }

    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$value instanceof UploadedFile) {
            $fail('The :attribute must be a valid file.');
            return;
        }

        $validation = $this->fileUploadService->validateFile($value, $this->options);
        
        if (!$validation['valid']) {
            foreach ($validation['errors'] as $error) {
                $fail($error);
            }
        }
    }

    /**
     * Create rule for image uploads with enhanced security
     */
    public static function image(array $options = []): self
    {
        $defaultOptions = [
            'allowed_extensions' => FileUploadService::ALLOWED_IMAGE_TYPES,
            'allowed_mimes' => [
                'image/jpeg',
                'image/png',
                'image/webp'
            ],
            'max_size' => FileUploadService::MAX_IMAGE_SIZE,
            'min_width' => 100,
            'min_height' => 100,
            'virus_scan' => config('file-upload.security.virus_scan', false)
        ];

        return new self(array_merge($defaultOptions, $options));
    }

    /**
     * Create rule for document uploads with enhanced security
     */
    public static function document(array $options = []): self
    {
        $defaultOptions = [
            'allowed_extensions' => FileUploadService::ALLOWED_DOCUMENT_TYPES,
            'allowed_mimes' => [
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
            ],
            'max_size' => FileUploadService::MAX_DOCUMENT_SIZE,
            'virus_scan' => config('file-upload.security.virus_scan', false)
        ];

        return new self(array_merge($defaultOptions, $options));
    }

    /**
     * Create rule for vehicle photos with enhanced security
     */
    public static function vehiclePhoto(): self
    {
        return self::image([
            'min_width' => 400,
            'min_height' => 300,
            'max_width' => 2048,
            'max_height' => 1536,
            'virus_scan' => true
        ]);
    }

    /**
     * Create rule for customer documents (KTP/SIM) with enhanced security
     */
    public static function customerDocument(): self
    {
        return self::image([
            'min_width' => 300,
            'min_height' => 200,
            'max_width' => 1920,
            'max_height' => 1080,
            'virus_scan' => true
        ]);
    }

    /**
     * Create rule for maintenance receipts with enhanced security
     */
    public static function receipt(): self
    {
        return new self([
            'allowed_extensions' => array_merge(
                FileUploadService::ALLOWED_IMAGE_TYPES,
                ['pdf']
            ),
            'allowed_mimes' => [
                'image/jpeg',
                'image/png',
                'image/webp',
                'application/pdf'
            ],
            'max_size' => 5 * 1024 * 1024, // 5MB
            'virus_scan' => true
        ]);
    }

    /**
     * Create rule for inspection photos with enhanced security
     */
    public static function inspectionPhoto(): self
    {
        return self::image([
            'min_width' => 400,
            'min_height' => 300,
            'max_width' => 1920,
            'max_height' => 1080,
            'virus_scan' => true
        ]);
    }

    /**
     * Create rule for profile photos with enhanced security
     */
    public static function profilePhoto(): self
    {
        return self::image([
            'min_width' => 150,
            'min_height' => 150,
            'max_width' => 1024,
            'max_height' => 1024,
            'max_size' => 2 * 1024 * 1024, // 2MB
            'virus_scan' => true
        ]);
    }
}