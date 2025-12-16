<?php

namespace App\Traits;

use App\Services\FileUploadService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

trait HandlesSecureFileUploads
{
    protected FileUploadService $fileUploadService;

    public function bootHandlesSecureFileUploads()
    {
        $this->fileUploadService = app(FileUploadService::class);
    }

    /**
     * Upload file securely with validation and processing
     */
    protected function uploadFileSecurely(
        $file, 
        string $directory, 
        string $disk = 'public',
        array $options = []
    ): array {
        // Handle Livewire temporary files
        if ($file instanceof TemporaryUploadedFile) {
            $uploadedFile = new UploadedFile(
                $file->getRealPath(),
                $file->getClientOriginalName(),
                $file->getMimeType(),
                null,
                true
            );
        } elseif ($file instanceof UploadedFile) {
            $uploadedFile = $file;
        } else {
            return [
                'success' => false,
                'errors' => ['Invalid file type provided']
            ];
        }

        return $this->fileUploadService->uploadFile($uploadedFile, $directory, $disk, $options);
    }

    /**
     * Upload vehicle photo with specific settings
     */
    protected function uploadVehiclePhoto($file, string $licensePlate, string $position): array
    {
        $options = [
            'prefix' => $this->sanitizeLicensePlate($licensePlate) . '_' . $position . '_',
            'max_width' => 1920,
            'max_height' => 1080,
            'quality' => 85,
            'generate_thumbnail' => true,
            'thumbnail_width' => 400,
            'thumbnail_height' => 300
        ];

        return $this->uploadFileSecurely($file, 'vehicles', 'public', $options);
    }

    /**
     * Upload customer document (KTP/SIM)
     */
    protected function uploadCustomerDocument($file, string $nik, string $documentType): array
    {
        $options = [
            'prefix' => $nik . '_' . $documentType . '_',
            'max_width' => 1920,
            'max_height' => 1080,
            'quality' => 90,
            'allowed_extensions' => ['jpg', 'jpeg', 'png'],
            'allowed_mimes' => ['image/jpeg', 'image/png'],
            'min_width' => 300,
            'min_height' => 200
        ];

        return $this->uploadFileSecurely($file, 'customers', 'private', $options);
    }

    /**
     * Upload inspection photo
     */
    protected function uploadInspectionPhoto($file, string $bookingNumber, string $type, int $index): array
    {
        $options = [
            'prefix' => $bookingNumber . '_' . $type . '_' . $index . '_',
            'max_width' => 1920,
            'max_height' => 1080,
            'quality' => 85,
            'generate_thumbnail' => true
        ];

        return $this->uploadFileSecurely($file, 'inspections', 'public', $options);
    }

    /**
     * Upload maintenance receipt
     */
    protected function uploadMaintenanceReceipt($file, int $maintenanceId): array
    {
        $options = [
            'prefix' => 'maintenance_' . $maintenanceId . '_',
            'allowed_extensions' => ['jpg', 'jpeg', 'png', 'pdf'],
            'allowed_mimes' => [
                'image/jpeg',
                'image/png', 
                'application/pdf'
            ],
            'max_size' => 5 * 1024 * 1024 // 5MB
        ];

        return $this->uploadFileSecurely($file, 'maintenance/receipts', 'public', $options);
    }

    /**
     * Upload expense receipt
     */
    protected function uploadExpenseReceipt($file, int $expenseId): array
    {
        $options = [
            'prefix' => 'expense_' . $expenseId . '_',
            'allowed_extensions' => ['jpg', 'jpeg', 'png', 'pdf'],
            'allowed_mimes' => [
                'image/jpeg',
                'image/png',
                'application/pdf'
            ],
            'max_size' => 5 * 1024 * 1024 // 5MB
        ];

        return $this->uploadFileSecurely($file, 'expenses/receipts', 'public', $options);
    }

    /**
     * Delete file securely
     */
    protected function deleteFileSecurely(string $path, string $disk = 'public'): bool
    {
        return $this->fileUploadService->deleteFile($path, $disk);
    }

    /**
     * Get secure file URL
     */
    protected function getSecureFileUrl(string $path, string $disk = 'public'): ?string
    {
        return $this->fileUploadService->getFileUrl($path, $disk);
    }

    /**
     * Sanitize license plate for filename
     */
    protected function sanitizeLicensePlate(string $licensePlate): string
    {
        return preg_replace('/[^A-Za-z0-9\-]/', '_', $licensePlate);
    }

    /**
     * Validate file upload in Livewire component
     */
    protected function validateFileUpload($file, array $options = []): array
    {
        if (!$file) {
            return ['valid' => true, 'errors' => []];
        }

        // Handle Livewire temporary files
        if ($file instanceof TemporaryUploadedFile) {
            $uploadedFile = new UploadedFile(
                $file->getRealPath(),
                $file->getClientOriginalName(),
                $file->getMimeType(),
                null,
                true
            );
        } elseif ($file instanceof UploadedFile) {
            $uploadedFile = $file;
        } else {
            return [
                'valid' => false,
                'errors' => ['Invalid file type']
            ];
        }

        return $this->fileUploadService->validateFile($uploadedFile, $options);
    }

    /**
     * Add file validation errors to component
     */
    protected function addFileValidationErrors(string $field, $file, array $options = []): void
    {
        $validation = $this->validateFileUpload($file, $options);
        
        if (!$validation['valid']) {
            foreach ($validation['errors'] as $error) {
                $this->addError($field, $error);
            }
        }
    }

    /**
     * Handle file upload with error handling for Livewire
     */
    protected function handleFileUpload(
        $file, 
        string $directory, 
        string $field,
        string $disk = 'public',
        array $options = []
    ): ?string {
        if (!$file) {
            return null;
        }

        // Validate first
        $this->addFileValidationErrors($field, $file, $options);
        
        if ($this->getErrorBag()->has($field)) {
            return null;
        }

        // Upload file
        $result = $this->uploadFileSecurely($file, $directory, $disk, $options);
        
        if (!$result['success']) {
            foreach ($result['errors'] as $error) {
                $this->addError($field, $error);
            }
            return null;
        }

        return $result['path'];
    }
}