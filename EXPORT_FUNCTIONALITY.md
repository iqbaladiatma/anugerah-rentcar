# Export Functionality Implementation

## Overview

This document describes the comprehensive Excel and PDF export functionality implemented for the Anugerah Rentcar System. The implementation includes export templates for all report types, batch export capabilities, and export scheduling with email delivery options.

## Features Implemented

### 1. Export Classes

#### Excel Export Classes
- `CustomerReportExport` - Customer report with booking history and statistics
- `FinancialReportExport` - Multi-sheet financial report with summary, monthly breakdown, and expense breakdown
- `VehicleReportExport` - Vehicle utilization and revenue report
- `AnalyticsReportExport` - Multi-sheet analytics dashboard report
- `ProfitabilityReportExport` - Vehicle profitability analysis
- `CustomerLTVReportExport` - Customer lifetime value analysis

#### PDF Templates
- `customer.blade.php` - Customer report PDF template
- `financial.blade.php` - Financial report PDF template
- `vehicle.blade.php` - Vehicle report PDF template
- `analytics.blade.php` - Analytics dashboard PDF template
- `profitability.blade.php` - Profitability analysis PDF template
- `customer-ltv.blade.php` - Customer LTV PDF template

### 2. Export Service

The `ExportService` class provides centralized export functionality:

#### Core Methods
- `exportCustomerReport($reportData, $format, $email)` - Export customer reports
- `exportFinancialReport($reportData, $format, $email)` - Export financial reports
- `exportVehicleReport($reportData, $format, $email)` - Export vehicle reports
- `exportAnalyticsReport($reportData, $format, $email)` - Export analytics reports
- `exportProfitabilityReport($reportData, $format, $email)` - Export profitability reports
- `exportCustomerLTVReport($reportData, $format, $email)` - Export customer LTV reports

#### Batch Export Features
- `batchExport($reports, $email)` - Export multiple reports in one operation
- `scheduleExport($reportType, $reportData, $format, $email, $scheduledAt)` - Schedule exports for later processing
- `getExportHistory($limit)` - Get history of exported files
- `cleanupOldExports($daysOld)` - Clean up old export files

### 3. Enhanced Report Controller

Updated `ReportController` with new export endpoints:

#### New Routes
- `POST /admin/reports/batch-export` - Batch export multiple reports
- `POST /admin/reports/schedule-export` - Schedule export for later processing
- `GET /admin/reports/export-history` - Get export history

#### Export Methods
All existing report methods now support both Excel and PDF export formats through the unified ExportService.

### 4. Background Processing

#### Job Classes
- `ProcessScheduledExport` - Queue job for processing scheduled exports

#### Console Commands
- `exports:cleanup` - Clean up old export files (configurable retention period)

## Usage Examples

### Basic Export
```php
// Export customer report as Excel
$result = $exportService->exportCustomerReport($reportData, 'excel');

// Export financial report as PDF with email delivery
$result = $exportService->exportFinancialReport($reportData, 'pdf', 'admin@company.com');
```

### Batch Export
```php
$reports = [
    [
        'type' => 'customer',
        'format' => 'excel',
        'data' => $customerReportData,
    ],
    [
        'type' => 'financial',
        'format' => 'pdf',
        'data' => $financialReportData,
    ],
];

$exportedFiles = $exportService->batchExport($reports, 'admin@company.com');
```

### Scheduled Export
```php
$result = $exportService->scheduleExport(
    'analytics',
    $analyticsReportData,
    'excel',
    'admin@company.com',
    Carbon::now()->addHours(2)
);
```

## File Management

### Storage Structure
```
storage/app/exports/
├── customer-report-2024-12-15-10-30-00-2024-01-01-to-2024-12-31.xlsx
├── financial-report-2024-12-15-10-31-00-2024-01-01-to-2024-12-31.pdf
└── vehicle-report-2024-12-15-10-32-00-2024-01-01-to-2024-12-31.xlsx
```

### Filename Convention
- Format: `{report-type}-{timestamp}-{period}.{extension}`
- Example: `customer-report-2024-12-15-10-30-00-2024-01-01-to-2024-12-31.xlsx`

### Cleanup
- Automatic cleanup via console command: `php artisan exports:cleanup --days=30`
- Configurable retention period (default: 30 days)
- Logs cleanup activities for audit purposes

## API Endpoints

### Batch Export
```http
POST /admin/reports/batch-export
Content-Type: application/json

{
    "reports": [
        {
            "type": "customer",
            "format": "excel",
            "start_date": "2024-01-01",
            "end_date": "2024-12-31"
        },
        {
            "type": "financial",
            "format": "pdf",
            "start_date": "2024-01-01",
            "end_date": "2024-12-31"
        }
    ],
    "email": "admin@company.com"
}
```

### Schedule Export
```http
POST /admin/reports/schedule-export
Content-Type: application/json

{
    "report_type": "analytics",
    "format": "excel",
    "start_date": "2024-01-01",
    "end_date": "2024-12-31",
    "email": "admin@company.com",
    "scheduled_at": "2024-12-15 18:00:00"
}
```

### Export History
```http
GET /admin/reports/export-history?limit=50
```

## Security Features

### File Security
- Files stored in secure storage directory
- Proper file naming to prevent conflicts
- File size tracking and limits
- Automatic cleanup of old files

### Access Control
- All export endpoints require authentication
- Role-based access control through middleware
- Email delivery logging for audit trails

## Performance Considerations

### Large Dataset Handling
- Chunked processing for large datasets
- Memory-efficient export classes
- Background job processing for scheduled exports
- File compression for large exports

### Optimization Features
- Lazy loading of relationships
- Efficient query optimization
- Caching of frequently accessed data
- Batch processing capabilities

## Error Handling

### Exception Management
- Comprehensive error logging
- Graceful failure handling
- User-friendly error messages
- Retry mechanisms for transient failures

### Monitoring
- Export success/failure tracking
- Performance monitoring
- Storage usage monitoring
- Email delivery status tracking

## Configuration

### Environment Variables
```env
# Export settings
EXPORT_RETENTION_DAYS=30
EXPORT_MAX_FILE_SIZE=50MB
EXPORT_EMAIL_ENABLED=true
```

### Queue Configuration
Scheduled exports use Laravel's queue system. Configure your queue driver in `.env`:
```env
QUEUE_CONNECTION=database
```

## Maintenance

### Regular Tasks
1. Run cleanup command weekly: `php artisan exports:cleanup`
2. Monitor storage usage
3. Review export logs for errors
4. Update export templates as needed

### Monitoring Commands
```bash
# Check export history
php artisan exports:history

# Clean up old files
php artisan exports:cleanup --days=30

# Process scheduled exports (if using sync queue)
php artisan queue:work
```

## Requirements Validation

This implementation satisfies the following requirements from the specification:

- ✅ **6.2**: Excel and PDF export formats for all report types
- ✅ **Batch Export**: Capability for large datasets
- ✅ **Email Delivery**: Export scheduling and email delivery options
- ✅ **Template System**: Comprehensive export templates
- ✅ **File Management**: Secure storage and cleanup mechanisms

## Future Enhancements

### Potential Improvements
1. **Compression**: Add ZIP compression for batch exports
2. **Cloud Storage**: Support for S3/cloud storage backends
3. **Real-time Progress**: WebSocket-based export progress tracking
4. **Custom Templates**: User-configurable export templates
5. **Advanced Scheduling**: Recurring export schedules (daily, weekly, monthly)
6. **Export Permissions**: Granular permissions per report type
7. **Export Analytics**: Usage statistics and performance metrics