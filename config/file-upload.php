<?php

return [

    /*
    |--------------------------------------------------------------------------
    | File Upload Security Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains configuration options for secure file uploads
    | including allowed file types, size limits, and security settings.
    |
    */

    'security' => [
        'virus_scan' => env('FILE_UPLOAD_VIRUS_SCAN', false),
        'enhanced_scanning' => env('FILE_UPLOAD_ENHANCED_SCAN', true),
        'strict_mime_validation' => env('FILE_UPLOAD_STRICT_MIME', true),
        'quarantine_suspicious_files' => env('FILE_UPLOAD_QUARANTINE', false),
        'max_compressed_size' => env('FILE_UPLOAD_MAX_COMPRESSED_SIZE', 10 * 1024 * 1024), // 10MB
        'block_executable_content' => env('FILE_UPLOAD_BLOCK_EXECUTABLE', true),
        'scan_metadata' => env('FILE_UPLOAD_SCAN_METADATA', true),
        'validate_file_structure' => env('FILE_UPLOAD_VALIDATE_STRUCTURE', true),
    ],

    'allowed_types' => [
        'images' => [
            'extensions' => ['jpg', 'jpeg', 'png', 'webp'],
            'mime_types' => [
                'image/jpeg',
                'image/png',
                'image/webp'
            ],
            'max_size' => 5 * 1024 * 1024, // 5MB
        ],
        
        'documents' => [
            'extensions' => ['pdf', 'doc', 'docx'],
            'mime_types' => [
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
            ],
            'max_size' => 10 * 1024 * 1024, // 10MB
        ],
    ],

    'image_processing' => [
        'auto_optimize' => env('FILE_UPLOAD_AUTO_OPTIMIZE', true),
        'quality' => env('FILE_UPLOAD_IMAGE_QUALITY', 85),
        'max_width' => env('FILE_UPLOAD_MAX_WIDTH', 1920),
        'max_height' => env('FILE_UPLOAD_MAX_HEIGHT', 1080),
        'generate_thumbnails' => env('FILE_UPLOAD_GENERATE_THUMBNAILS', true),
        'thumbnail_width' => env('FILE_UPLOAD_THUMBNAIL_WIDTH', 300),
        'thumbnail_height' => env('FILE_UPLOAD_THUMBNAIL_HEIGHT', 200),
    ],

    'storage' => [
        'public_disk' => env('FILE_UPLOAD_PUBLIC_DISK', 'public'),
        'private_disk' => env('FILE_UPLOAD_PRIVATE_DISK', 'local'),
        'temp_disk' => env('FILE_UPLOAD_TEMP_DISK', 'local'),
        'cleanup_temp_files' => env('FILE_UPLOAD_CLEANUP_TEMP', true),
        'temp_file_lifetime' => env('FILE_UPLOAD_TEMP_LIFETIME', 24), // hours
    ],

    'validation' => [
        'filename_max_length' => 255,
        'check_file_headers' => true,
        'block_executable_extensions' => true,
        'blocked_extensions' => [
            'php', 'php3', 'php4', 'php5', 'phtml',
            'exe', 'bat', 'cmd', 'com', 'pif', 'scr',
            'vbs', 'js', 'jar', 'sh', 'py', 'pl'
        ],
    ],

    'specific_types' => [
        'vehicle_photos' => [
            'min_width' => 400,
            'min_height' => 300,
            'max_width' => 2048,
            'max_height' => 1536,
            'quality' => 85,
            'generate_thumbnail' => true,
        ],
        
        'customer_documents' => [
            'min_width' => 300,
            'min_height' => 200,
            'max_width' => 1920,
            'max_height' => 1080,
            'quality' => 90,
            'allowed_extensions' => ['jpg', 'jpeg', 'png'],
        ],
        
        'inspection_photos' => [
            'min_width' => 400,
            'min_height' => 300,
            'max_width' => 1920,
            'max_height' => 1080,
            'quality' => 85,
            'generate_thumbnail' => true,
        ],
        
        'receipts' => [
            'allowed_extensions' => ['jpg', 'jpeg', 'png', 'pdf'],
            'max_size' => 5 * 1024 * 1024, // 5MB
        ],
    ],

    'logging' => [
        'log_uploads' => env('FILE_UPLOAD_LOG_UPLOADS', true),
        'log_validation_failures' => env('FILE_UPLOAD_LOG_FAILURES', true),
        'log_security_events' => env('FILE_UPLOAD_LOG_SECURITY', true),
        'log_quarantine_events' => env('FILE_UPLOAD_LOG_QUARANTINE', true),
        'log_rate_limit_hits' => env('FILE_UPLOAD_LOG_RATE_LIMITS', true),
    ],

    'rate_limiting' => [
        'enabled' => env('FILE_UPLOAD_RATE_LIMITING', true),
        'max_uploads_per_minute' => env('FILE_UPLOAD_MAX_PER_MINUTE', 10),
        'max_size_per_minute' => env('FILE_UPLOAD_MAX_SIZE_PER_MINUTE', 50 * 1024 * 1024), // 50MB
        'max_uploads_per_hour' => env('FILE_UPLOAD_MAX_PER_HOUR', 100),
        'max_size_per_hour' => env('FILE_UPLOAD_MAX_SIZE_PER_HOUR', 500 * 1024 * 1024), // 500MB
    ],

    'cleanup' => [
        'auto_cleanup_quarantine' => env('FILE_UPLOAD_AUTO_CLEANUP_QUARANTINE', true),
        'quarantine_retention_days' => env('FILE_UPLOAD_QUARANTINE_RETENTION', 30),
        'temp_file_cleanup_hours' => env('FILE_UPLOAD_TEMP_CLEANUP_HOURS', 24),
    ],

];