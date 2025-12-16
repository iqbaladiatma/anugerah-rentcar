<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Services\FileUploadService;

class FileUploadSecurityCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'file-upload:security 
                            {action : Action to perform (check-config, test-virus-scan, clean-quarantine)}
                            {--days=30 : Days to keep quarantined files}';

    /**
     * The console command description.
     */
    protected $description = 'Manage file upload security settings and maintenance';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $action = $this->argument('action');

        switch ($action) {
            case 'check-config':
                return $this->checkConfiguration();
            case 'test-virus-scan':
                return $this->testVirusScanning();
            case 'clean-quarantine':
                return $this->cleanQuarantine();
            default:
                $this->error("Unknown action: {$action}");
                return 1;
        }
    }

    /**
     * Check file upload security configuration
     */
    protected function checkConfiguration(): int
    {
        $this->info('Checking file upload security configuration...');

        // Check virus scanning
        $virusEnabled = config('file-upload.security.virus_scan', false);
        $this->line("Virus scanning: " . ($virusEnabled ? '✓ Enabled' : '✗ Disabled'));

        if ($virusEnabled) {
            // Check if ClamAV is available
            $output = [];
            $returnCode = 0;
            exec('clamscan --version 2>&1', $output, $returnCode);
            
            if ($returnCode === 0) {
                $this->line("ClamAV: ✓ Available (" . trim($output[0]) . ")");
            } else {
                $this->warn("ClamAV: ✗ Not available - using basic security scan");
            }
        }

        // Check other security settings
        $strictMime = config('file-upload.security.strict_mime_validation', true);
        $this->line("Strict MIME validation: " . ($strictMime ? '✓ Enabled' : '✗ Disabled'));

        $quarantine = config('file-upload.security.quarantine_suspicious_files', false);
        $this->line("File quarantine: " . ($quarantine ? '✓ Enabled' : '✗ Disabled'));

        $headerCheck = config('file-upload.validation.check_file_headers', true);
        $this->line("File header validation: " . ($headerCheck ? '✓ Enabled' : '✗ Disabled'));

        // Check storage permissions
        $this->info("\nChecking storage permissions...");
        
        $quarantineDir = storage_path('app/quarantine');
        if (!is_dir($quarantineDir)) {
            $this->warn("Quarantine directory does not exist: {$quarantineDir}");
        } else {
            $this->line("Quarantine directory: ✓ Exists");
            if (!is_writable($quarantineDir)) {
                $this->error("Quarantine directory is not writable");
                return 1;
            }
        }

        // Check upload limits
        $this->info("\nUpload limits:");
        $this->line("Max image size: " . $this->formatBytes(config('file-upload.allowed_types.images.max_size', 5242880)));
        $this->line("Max document size: " . $this->formatBytes(config('file-upload.allowed_types.documents.max_size', 10485760)));

        $this->info("\n✓ Configuration check complete");
        return 0;
    }

    /**
     * Test virus scanning functionality
     */
    protected function testVirusScanning(): int
    {
        $this->info('Testing virus scanning functionality...');

        if (!config('file-upload.security.virus_scan', false)) {
            $this->warn('Virus scanning is disabled in configuration');
            return 1;
        }

        // Create a test file with EICAR test string (harmless virus test signature)
        $eicarString = 'X5O!P%@AP[4\PZX54(P^)7CC)7}$EICAR-STANDARD-ANTIVIRUS-TEST-FILE!$H+H*';
        $testFile = storage_path('app/test_virus.txt');
        
        file_put_contents($testFile, $eicarString);

        // Test with ClamAV if available
        $output = [];
        $returnCode = 0;
        exec('clamscan --version 2>&1', $output, $returnCode);
        
        if ($returnCode === 0) {
            $this->line('Testing with ClamAV...');
            
            $scanOutput = [];
            $scanReturn = 0;
            exec("clamscan --no-summary --infected --stdout " . escapeshellarg($testFile) . " 2>&1", $scanOutput, $scanReturn);
            
            if ($scanReturn === 1) {
                $this->info('✓ ClamAV correctly detected test virus signature');
            } else {
                $this->warn('✗ ClamAV did not detect test virus signature');
            }
        } else {
            $this->warn('ClamAV not available, testing basic security scan...');
            
            // Test basic security scan
            $fileUploadService = app(FileUploadService::class);
            $reflection = new \ReflectionClass($fileUploadService);
            $method = $reflection->getMethod('performBasicSecurityScan');
            $method->setAccessible(true);
            
            // Create a mock UploadedFile for testing
            $mockFile = new \Illuminate\Http\UploadedFile($testFile, 'test.txt', 'text/plain', null, true);
            $result = $method->invoke($fileUploadService, $mockFile);
            
            if (!$result['clean']) {
                $this->info('✓ Basic security scan detected suspicious content');
            } else {
                $this->warn('✗ Basic security scan did not detect suspicious content');
            }
        }

        // Clean up test file
        unlink($testFile);

        $this->info('✓ Virus scanning test complete');
        return 0;
    }

    /**
     * Clean old quarantined files
     */
    protected function cleanQuarantine(): int
    {
        $days = (int) $this->option('days');
        $this->info("Cleaning quarantined files older than {$days} days...");

        $quarantineDir = storage_path('app/quarantine');
        
        if (!is_dir($quarantineDir)) {
            $this->warn('Quarantine directory does not exist');
            return 0;
        }

        $files = glob($quarantineDir . '/*');
        $deletedCount = 0;
        $cutoffTime = time() - ($days * 24 * 60 * 60);

        foreach ($files as $file) {
            if (is_file($file) && filemtime($file) < $cutoffTime) {
                if (unlink($file)) {
                    $deletedCount++;
                    $this->line("Deleted: " . basename($file));
                }
            }
        }

        $this->info("✓ Cleaned {$deletedCount} quarantined files");
        return 0;
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
}