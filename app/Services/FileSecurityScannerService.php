<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Exception;

class FileSecurityScannerService
{
    /**
     * Perform comprehensive security scan on uploaded file
     */
    public function scanFile(UploadedFile $file): array
    {
        $results = [
            'safe' => true,
            'threats' => [],
            'warnings' => [],
            'scan_results' => []
        ];

        // Perform multiple security checks
        $checks = [
            'malware_patterns' => $this->scanMalwarePatterns($file),
            'executable_content' => $this->scanExecutableContent($file),
            'suspicious_metadata' => $this->scanMetadata($file),
            'file_structure' => $this->validateFileStructure($file),
            'content_analysis' => $this->analyzeContent($file)
        ];

        foreach ($checks as $checkName => $result) {
            $results['scan_results'][$checkName] = $result;
            
            if (!$result['safe']) {
                $results['safe'] = false;
                $results['threats'] = array_merge($results['threats'], $result['threats'] ?? []);
            }
            
            if (!empty($result['warnings'])) {
                $results['warnings'] = array_merge($results['warnings'], $result['warnings']);
            }
        }

        // Log scan results
        if (!$results['safe']) {
            Log::warning('File security scan detected threats', [
                'file' => $file->getClientOriginalName(),
                'threats' => $results['threats'],
                'size' => $file->getSize(),
                'mime' => $file->getMimeType()
            ]);
        }

        return $results;
    }

    /**
     * Scan for known malware patterns
     */
    protected function scanMalwarePatterns(UploadedFile $file): array
    {
        $threats = [];
        $warnings = [];
        
        try {
            $content = file_get_contents($file->getRealPath());
            
            // Common malware patterns
            $malwarePatterns = [
                // PHP backdoors
                '/eval\s*\(\s*base64_decode/i' => 'PHP backdoor pattern detected',
                '/system\s*\(\s*\$_[GET|POST]/i' => 'PHP system call with user input',
                '/exec\s*\(\s*\$_[GET|POST]/i' => 'PHP exec call with user input',
                '/shell_exec\s*\(\s*\$_[GET|POST]/i' => 'PHP shell execution with user input',
                
                // JavaScript malware
                '/document\.write\s*\(\s*unescape/i' => 'JavaScript obfuscation pattern',
                '/eval\s*\(\s*unescape/i' => 'JavaScript eval with unescape',
                '/String\.fromCharCode/i' => 'JavaScript character code obfuscation',
                
                // Generic suspicious patterns
                '/\x00/' => 'Null byte detected',
                '/\.\.\//' => 'Directory traversal pattern',
                '/<script[^>]*src=["\']https?:\/\/[^"\']*["\'][^>]*>/i' => 'External script inclusion',
            ];
            
            foreach ($malwarePatterns as $pattern => $description) {
                if (preg_match($pattern, $content)) {
                    $threats[] = $description;
                }
            }
            
            // Check for suspicious file signatures within content
            $suspiciousSignatures = [
                'MZ' => 'PE executable signature found in content',
                'PK' => 'ZIP/JAR signature found (potential archive bomb)',
                '\x7fELF' => 'ELF executable signature found',
            ];
            
            foreach ($suspiciousSignatures as $signature => $description) {
                if (strpos($content, $signature) !== false) {
                    $warnings[] = $description;
                }
            }
            
        } catch (Exception $e) {
            $warnings[] = 'Could not scan file content: ' . $e->getMessage();
        }
        
        return [
            'safe' => empty($threats),
            'threats' => $threats,
            'warnings' => $warnings
        ];
    }

    /**
     * Scan for executable content
     */
    protected function scanExecutableContent(UploadedFile $file): array
    {
        $threats = [];
        $warnings = [];
        
        try {
            $content = file_get_contents($file->getRealPath());
            
            // Check for executable file headers
            $executableHeaders = [
                "\x4D\x5A" => 'Windows PE executable',
                "\x7F\x45\x4C\x46" => 'Linux ELF executable',
                "\xCA\xFE\xBA\xBE" => 'Java class file',
                "\xFE\xED\xFA\xCE" => 'Mach-O executable',
                "\xFE\xED\xFA\xCF" => 'Mach-O 64-bit executable',
            ];
            
            foreach ($executableHeaders as $header => $type) {
                if (strpos($content, $header) === 0) {
                    $threats[] = "File contains {$type} signature";
                }
            }
            
            // Check for script interpreters
            $scriptPatterns = [
                '/^#!.*\/bin\/(sh|bash|zsh|csh|tcsh)/' => 'Shell script detected',
                '/^#!.*\/usr\/bin\/(python|perl|ruby|php)/' => 'Script interpreter detected',
                '/^#!.*node/' => 'Node.js script detected',
            ];
            
            foreach ($scriptPatterns as $pattern => $description) {
                if (preg_match($pattern, $content)) {
                    $threats[] = $description;
                }
            }
            
        } catch (Exception $e) {
            $warnings[] = 'Could not analyze executable content: ' . $e->getMessage();
        }
        
        return [
            'safe' => empty($threats),
            'threats' => $threats,
            'warnings' => $warnings
        ];
    }

    /**
     * Scan file metadata for suspicious information
     */
    protected function scanMetadata(UploadedFile $file): array
    {
        $threats = [];
        $warnings = [];
        
        try {
            // Check filename for suspicious patterns
            $filename = $file->getClientOriginalName();
            
            // Multiple extensions
            if (substr_count($filename, '.') > 1) {
                $parts = explode('.', $filename);
                $dangerousExts = ['exe', 'bat', 'cmd', 'com', 'scr', 'pif', 'php', 'asp', 'jsp'];
                
                for ($i = 1; $i < count($parts) - 1; $i++) {
                    if (in_array(strtolower($parts[$i]), $dangerousExts)) {
                        $threats[] = "Dangerous double extension detected: .{$parts[$i]}";
                    }
                }
            }
            
            // Suspicious filename patterns
            $suspiciousPatterns = [
                '/\.(php|asp|jsp|cgi)\./i' => 'Server-side script extension in filename',
                '/\.(exe|bat|cmd|com|scr|pif)$/i' => 'Executable file extension',
                '/[<>:"|?*]/' => 'Invalid filename characters',
                '/^\s|\s$/' => 'Filename with leading/trailing spaces',
            ];
            
            foreach ($suspiciousPatterns as $pattern => $description) {
                if (preg_match($pattern, $filename)) {
                    $threats[] = $description;
                }
            }
            
            // Check file size anomalies
            $fileSize = $file->getSize();
            if ($fileSize === 0) {
                $threats[] = 'Empty file detected';
            } elseif ($fileSize > 100 * 1024 * 1024) { // 100MB
                $warnings[] = 'Unusually large file size';
            }
            
        } catch (Exception $e) {
            $warnings[] = 'Could not analyze metadata: ' . $e->getMessage();
        }
        
        return [
            'safe' => empty($threats),
            'threats' => $threats,
            'warnings' => $warnings
        ];
    }

    /**
     * Validate file structure integrity
     */
    protected function validateFileStructure(UploadedFile $file): array
    {
        $threats = [];
        $warnings = [];
        $extension = strtolower($file->getClientOriginalExtension());
        
        try {
            switch ($extension) {
                case 'pdf':
                    $result = $this->validatePdfStructure($file);
                    break;
                case 'jpg':
                case 'jpeg':
                    $result = $this->validateJpegStructure($file);
                    break;
                case 'png':
                    $result = $this->validatePngStructure($file);
                    break;
                default:
                    $result = ['safe' => true, 'threats' => [], 'warnings' => []];
            }
            
            $threats = array_merge($threats, $result['threats']);
            $warnings = array_merge($warnings, $result['warnings']);
            
        } catch (Exception $e) {
            $warnings[] = 'Could not validate file structure: ' . $e->getMessage();
        }
        
        return [
            'safe' => empty($threats),
            'threats' => $threats,
            'warnings' => $warnings
        ];
    }

    /**
     * Validate PDF file structure
     */
    protected function validatePdfStructure(UploadedFile $file): array
    {
        $threats = [];
        $warnings = [];
        
        $content = file_get_contents($file->getRealPath());
        
        // Check PDF header
        if (!str_starts_with($content, '%PDF-')) {
            $threats[] = 'Invalid PDF header';
        }
        
        // Check for suspicious PDF features
        $suspiciousFeatures = [
            '/\/JavaScript/' => 'PDF contains JavaScript',
            '/\/JS/' => 'PDF contains JavaScript (short form)',
            '/\/OpenAction/' => 'PDF has automatic actions',
            '/\/Launch/' => 'PDF can launch external applications',
            '/\/EmbeddedFile/' => 'PDF contains embedded files',
            '/\/RichMedia/' => 'PDF contains rich media content',
        ];
        
        foreach ($suspiciousFeatures as $pattern => $description) {
            if (preg_match($pattern, $content)) {
                $threats[] = $description;
            }
        }
        
        return [
            'safe' => empty($threats),
            'threats' => $threats,
            'warnings' => $warnings
        ];
    }

    /**
     * Validate JPEG file structure
     */
    protected function validateJpegStructure(UploadedFile $file): array
    {
        $threats = [];
        $warnings = [];
        
        $handle = fopen($file->getRealPath(), 'rb');
        if (!$handle) {
            return ['safe' => false, 'threats' => ['Cannot read JPEG file'], 'warnings' => []];
        }
        
        // Check JPEG header
        $header = fread($handle, 4);
        if (!str_starts_with($header, "\xFF\xD8\xFF")) {
            $threats[] = 'Invalid JPEG header';
        }
        
        fclose($handle);
        
        return [
            'safe' => empty($threats),
            'threats' => $threats,
            'warnings' => $warnings
        ];
    }

    /**
     * Validate PNG file structure
     */
    protected function validatePngStructure(UploadedFile $file): array
    {
        $threats = [];
        $warnings = [];
        
        $handle = fopen($file->getRealPath(), 'rb');
        if (!$handle) {
            return ['safe' => false, 'threats' => ['Cannot read PNG file'], 'warnings' => []];
        }
        
        // Check PNG signature
        $signature = fread($handle, 8);
        if ($signature !== "\x89\x50\x4E\x47\x0D\x0A\x1A\x0A") {
            $threats[] = 'Invalid PNG signature';
        }
        
        fclose($handle);
        
        return [
            'safe' => empty($threats),
            'threats' => $threats,
            'warnings' => $warnings
        ];
    }

    /**
     * Analyze file content for suspicious patterns
     */
    protected function analyzeContent(UploadedFile $file): array
    {
        $threats = [];
        $warnings = [];
        
        try {
            $content = file_get_contents($file->getRealPath());
            
            // Check for high entropy (possible encryption/obfuscation)
            $entropy = $this->calculateEntropy($content);
            if ($entropy > 7.5) {
                $warnings[] = 'High entropy content detected (possible obfuscation)';
            }
            
            // Check for repeated patterns (possible compression bomb)
            if ($this->hasRepeatedPatterns($content)) {
                $warnings[] = 'Repeated patterns detected (possible compression bomb)';
            }
            
            // Check for embedded URLs
            if (preg_match_all('/https?:\/\/[^\s<>"\']+/i', $content, $matches)) {
                if (count($matches[0]) > 10) {
                    $warnings[] = 'Multiple URLs detected in file content';
                }
            }
            
        } catch (Exception $e) {
            $warnings[] = 'Could not analyze content: ' . $e->getMessage();
        }
        
        return [
            'safe' => empty($threats),
            'threats' => $threats,
            'warnings' => $warnings
        ];
    }

    /**
     * Calculate Shannon entropy of content
     */
    protected function calculateEntropy(string $content): float
    {
        $length = strlen($content);
        if ($length === 0) {
            return 0;
        }
        
        $frequencies = array_count_values(str_split($content));
        $entropy = 0;
        
        foreach ($frequencies as $count) {
            $probability = $count / $length;
            $entropy -= $probability * log($probability, 2);
        }
        
        return $entropy;
    }

    /**
     * Check for repeated patterns that might indicate compression bombs
     */
    protected function hasRepeatedPatterns(string $content): bool
    {
        $length = strlen($content);
        if ($length < 1000) {
            return false;
        }
        
        // Sample first 1KB and check for repetition
        $sample = substr($content, 0, 1024);
        $compressed = gzcompress($sample);
        
        // If compression ratio is very high, might be repeated patterns
        return (strlen($compressed) / strlen($sample)) < 0.1;
    }
}