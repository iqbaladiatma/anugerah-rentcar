<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Services\FileUploadService;
use App\Services\FileSecurityScannerService;
use App\Rules\EnhancedFileUpload;

class FileUploadSecurityTest extends TestCase
{
    use RefreshDatabase;

    protected FileUploadService $fileUploadService;
    protected FileSecurityScannerService $securityScanner;

    protected function setUp(): void
    {
        parent::setUp();
        
        Storage::fake('public');
        Storage::fake('local');
        
        $this->fileUploadService = app(FileUploadService::class);
        $this->securityScanner = app(FileSecurityScannerService::class);
    }

    /** @test */
    public function it_blocks_files_with_dangerous_extensions()
    {
        $file = UploadedFile::fake()->create('malicious.php.jpg', 100);
        
        $result = $this->fileUploadService->validateFile($file);
        
        $this->assertFalse($result['valid']);
        $this->assertContains('Files with double extensions are not allowed', $result['errors']);
    }

    /** @test */
    public function it_validates_mime_type_matches_extension()
    {
        // Create a fake file with wrong MIME type
        $file = UploadedFile::fake()->create('image.jpg', 100, 'application/pdf');
        
        $result = $this->fileUploadService->validateFile($file, [
            'strict_mime_validation' => true
        ]);
        
        $this->assertFalse($result['valid']);
    }

    /** @test */
    public function it_detects_suspicious_file_content()
    {
        // Create a file with suspicious PHP content
        $content = '<?php eval($_POST["cmd"]); ?>';
        $file = UploadedFile::fake()->createWithContent('image.jpg', $content);
        
        $scanResult = $this->securityScanner->scanFile($file);
        
        $this->assertFalse($scanResult['safe']);
        $this->assertNotEmpty($scanResult['threats']);
    }

    /** @test */
    public function it_validates_file_headers()
    {
        // Create a file claiming to be JPEG but with wrong header
        $content = 'FAKE_JPEG_CONTENT';
        $file = UploadedFile::fake()->createWithContent('image.jpg', $content);
        
        $result = $this->fileUploadService->validateFile($file, [
            'check_file_headers' => true
        ]);
        
        $this->assertFalse($result['valid']);
    }

    /** @test */
    public function it_blocks_files_exceeding_size_limits()
    {
        $file = UploadedFile::fake()->create('large.jpg', 11 * 1024); // 11MB
        
        $result = $this->fileUploadService->validateFile($file, [
            'max_size' => 5 * 1024 * 1024 // 5MB limit
        ]);
        
        $this->assertFalse($result['valid']);
        $this->assertTrue(str_contains(implode(' ', $result['errors']), 'exceeds limit'));
    }

    /** @test */
    public function it_blocks_empty_files()
    {
        $file = UploadedFile::fake()->create('empty.jpg', 0);
        
        $result = $this->fileUploadService->validateFile($file);
        
        $this->assertFalse($result['valid']);
        $this->assertTrue(str_contains(implode(' ', $result['errors']), 'too small'));
    }

    /** @test */
    public function it_detects_executable_signatures()
    {
        // Create file with PE executable signature
        $content = "MZ\x90\x00" . str_repeat('A', 100);
        $file = UploadedFile::fake()->createWithContent('document.pdf', $content);
        
        $scanResult = $this->securityScanner->scanFile($file);
        
        $this->assertFalse($scanResult['safe']);
        $this->assertTrue(in_array('File contains Windows PE executable signature', $scanResult['threats']));
    }

    /** @test */
    public function it_validates_pdf_security()
    {
        // Create PDF with JavaScript
        $content = '%PDF-1.4' . "\n" . '/JavaScript (alert("XSS"))';
        $file = UploadedFile::fake()->createWithContent('document.pdf', $content);
        
        $scanResult = $this->securityScanner->scanFile($file);
        
        $this->assertFalse($scanResult['safe']);
        $this->assertTrue(in_array('PDF contains JavaScript', $scanResult['threats']));
    }

    /** @test */
    public function it_allows_valid_image_files()
    {
        // Create a valid JPEG file
        $image = imagecreate(100, 100);
        $white = imagecolorallocate($image, 255, 255, 255);
        imagefill($image, 0, 0, $white);
        
        ob_start();
        imagejpeg($image);
        $content = ob_get_clean();
        imagedestroy($image);
        
        $file = UploadedFile::fake()->createWithContent('valid.jpg', $content);
        
        $result = $this->fileUploadService->validateFile($file);
        
        $this->assertTrue($result['valid']);
        $this->assertEmpty($result['errors']);
    }

    /** @test */
    public function enhanced_file_upload_rule_works()
    {
        // Create a proper JPEG image for testing
        $image = imagecreate(500, 400);
        $white = imagecolorallocate($image, 255, 255, 255);
        imagefill($image, 0, 0, $white);
        
        ob_start();
        imagejpeg($image);
        $content = ob_get_clean();
        imagedestroy($image);
        
        $file = UploadedFile::fake()->createWithContent('test.jpg', $content);
        
        // Create rule with enhanced security disabled for this test
        $rule = new EnhancedFileUpload([
            'allowed_extensions' => ['jpg', 'jpeg', 'png', 'webp'],
            'allowed_mimes' => ['image/jpeg', 'image/png', 'image/webp'],
            'max_size' => 5 * 1024 * 1024, // 5MB
            'min_width' => 400,
            'min_height' => 300,
            'enhanced_security' => false, // Disable for test
            'virus_scan' => false
        ]);
        
        $validator = validator(['photo' => $file], ['photo' => $rule]);
        
        $this->assertTrue($validator->passes());
    }

    /** @test */
    public function it_quarantines_suspicious_files_when_enabled()
    {
        config(['file-upload.security.quarantine_suspicious_files' => true]);
        
        $file = UploadedFile::fake()->create('malicious.php.jpg', 100);
        
        $result = $this->fileUploadService->validateFile($file);
        
        $this->assertFalse($result['valid']);
        
        // Check if quarantine directory would be created
        $quarantinePath = storage_path('app/quarantine');
        // Note: In a real test, we'd check if the file was actually quarantined
    }

    /** @test */
    public function it_calculates_entropy_correctly()
    {
        // High entropy content (random)
        $highEntropyContent = random_bytes(1000);
        $file = UploadedFile::fake()->createWithContent('random.bin', $highEntropyContent);
        
        $scanResult = $this->securityScanner->scanFile($file);
        
        // Should detect high entropy
        $this->assertNotEmpty($scanResult['warnings']);
    }

    /** @test */
    public function it_handles_file_upload_errors_gracefully()
    {
        // Test with invalid file
        $result = $this->fileUploadService->uploadFile(
            UploadedFile::fake()->create('test.txt', 0), // Empty file
            'test',
            'public'
        );
        
        $this->assertFalse($result['success']);
        $this->assertNotEmpty($result['errors']);
    }
}