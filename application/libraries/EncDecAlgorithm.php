<?php
/**
 * PHP Implementation of .NET AES Encryption/Decryption
 * Based on C:\data\UAT_2_1\UAT_2\RING_API\RING_API\Helper\EncDecAlgorithm.cs
 * 
 * Algorithm: AES-256 with PBKDF2 key derivation
 * Password: MAKV2SPBNI99212
 * Salt: {1, 2, 3, 4, 5, 6, 7, 8}
 * Iterations: 1000
 * Mode: CBC
 */

class EncDecAlgorithm
{
    private static $password = "MAKV2SPBNI99212";
    private static $salt = "\x01\x02\x03\x04\x05\x06\x07\x08";
    private static $iterations = 1000;
    private static $keySize = 32; // 256 bits
    private static $blockSize = 16; // 128 bits (AES block size)

    /**
     * Encrypt plain text to Base64 encrypted string
     * 
     * @param string $text Plain text to encrypt
     * @return string Base64 encoded encrypted string
     */
    public static function encrypt($text)
    {
        if (empty($text)) {
            return $text;
        }

        try {
            // Hash the password with SHA256 (same as .NET)
            $passwordBytes = hash('sha256', self::$password, true);

            // Derive key and IV using PBKDF2 (same as .NET Rfc2898DeriveBytes)
            $keyAndIV = self::deriveKeyAndIV($passwordBytes, self::$salt, self::$iterations);

            // Encrypt using AES-256-CBC
            $encrypted = openssl_encrypt(
                $text,
                'aes-256-cbc',
                $keyAndIV['key'],
                OPENSSL_RAW_DATA,
                $keyAndIV['iv']
            );

            if ($encrypted === false) {
                return $text; // Return original on failure
            }

            // Return Base64 encoded result
            return base64_encode($encrypted);
        } catch (Exception $e) {
            error_log("Encryption error: " . $e->getMessage());
            return $text;
        }
    }

    /**
     * Decrypt Base64 encrypted string to plain text
     * 
     * @param string $encryptedText Base64 encoded encrypted string
     * @return string Decrypted plain text
     */
    public static function decrypt($encryptedText)
    {
        if (empty($encryptedText)) {
            return $encryptedText;
        }

        try {
            // Decode from Base64
            $encrypted = base64_decode($encryptedText, true);
            if ($encrypted === false) {
                return $encryptedText; // Return original if not valid Base64
            }

            // Hash the password with SHA256 (same as .NET)
            $passwordBytes = hash('sha256', self::$password, true);

            // Derive key and IV using PBKDF2 (same as .NET Rfc2898DeriveBytes)
            $keyAndIV = self::deriveKeyAndIV($passwordBytes, self::$salt, self::$iterations);

            // Decrypt using AES-256-CBC
            $decrypted = openssl_decrypt(
                $encrypted,
                'aes-256-cbc',
                $keyAndIV['key'],
                OPENSSL_RAW_DATA,
                $keyAndIV['iv']
            );

            if ($decrypted === false) {
                return $encryptedText; // Return original on failure
            }

            return $decrypted;
        } catch (Exception $e) {
            error_log("Decryption error: " . $e->getMessage());
            return $encryptedText;
        }
    }

    /**
     * Derive Key and IV using PBKDF2 (matches .NET Rfc2898DeriveBytes)
     * 
     * @param string $passwordBytes SHA256 hashed password bytes
     * @param string $salt Salt bytes
     * @param int $iterations Number of iterations
     * @return array ['key' => string, 'iv' => string]
     */
    private static function deriveKeyAndIV($passwordBytes, $salt, $iterations)
    {
        // Use PBKDF2 (same as .NET Rfc2898DeriveBytes with HMACSHA1)
        // We need 32 bytes for key + 16 bytes for IV = 48 bytes total
        $derived = hash_pbkdf2('sha1', $passwordBytes, $salt, $iterations, 48, true);

        return [
            'key' => substr($derived, 0, self::$keySize),  // First 32 bytes for key
            'iv'  => substr($derived, self::$keySize, self::$blockSize)  // Next 16 bytes for IV
        ];
    }
}

// Test function to verify compatibility with .NET
function testEncryption()
{
    echo "=== Testing PHP Encryption/Decryption ===\n\n";

    // Test 1: Encrypt and Decrypt
    $original = "John Doe";
    echo "Original: $original\n";
    
    $encrypted = EncDecAlgorithm::encrypt($original);
    echo "Encrypted: $encrypted\n";
    
    $decrypted = EncDecAlgorithm::decrypt($encrypted);
    echo "Decrypted: $decrypted\n";
    echo "Match: " . ($original === $decrypted ? "✓ YES" : "✗ NO") . "\n\n";

    // Test 2: Decrypt a known encrypted value from .NET
    echo "--- Test with .NET encrypted value ---\n";
    // You can test with an actual encrypted value from the database
    $testEncrypted = "U2FsYWggQWhtYWQ="; // Example Base64
    echo "Encrypted value: $testEncrypted\n";
    $testDecrypted = EncDecAlgorithm::decrypt($testEncrypted);
    echo "Decrypted value: $testDecrypted\n\n";

    // Test 3: Empty string handling
    echo "--- Test with empty string ---\n";
    $empty = "";
    $encryptedEmpty = EncDecAlgorithm::encrypt($empty);
    echo "Empty encrypted: '$encryptedEmpty'\n";
    echo "Empty is empty: " . (empty($encryptedEmpty) ? "✓ YES" : "✗ NO") . "\n\n";

    // Test 4: Special characters
    echo "--- Test with special characters ---\n";
    $special = "Test@123!#$%";
    $encryptedSpecial = EncDecAlgorithm::encrypt($special);
    $decryptedSpecial = EncDecAlgorithm::decrypt($encryptedSpecial);
    echo "Original: $special\n";
    echo "Decrypted: $decryptedSpecial\n";
    echo "Match: " . ($special === $decryptedSpecial ? "✓ YES" : "✗ NO") . "\n\n";
}

// Run test if executed directly
if (php_sapi_name() === 'cli') {
    testEncryption();
}
?>
