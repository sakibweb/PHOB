<?php

/**
 * PHOB Class
 *
 * A utility class to interact with the PHOB PHP extension, ensuring it is loaded
 * and providing a clean interface to its core functions. If the extension or its
 * functions are unavailable, it provides clear installation instructions.
 *
 * @package PHOB
 * @version 3.2.1
 * @link https://github.com/sakibweb/PHOB
 */
class PHOB {
    /**
     * Flag indicating if the PHOB extension is loaded and functional
     *
     * @var bool
     */
    private static $isInitialized = false;

    /**
     * Error message if initialization fails
     *
     * @var string
     */
    private static $errorMessage = '';

    /**
     * Initialize and validate the PHOB extension
     */
    private static function initialize()
    {
        // Check if the PHOB extension is loaded
        if (!extension_loaded('phob')) {
            self::$errorMessage = "The PHOB extension is not loaded. Please install it following the instructions below:\n" .
                                  self::getInstallationInstructions();
            return;
        }

        // Check if required functions exist
        $requiredFunctions = ['phob_deviceID', 'phob_build', 'phob_use'];
        foreach ($requiredFunctions as $function) {
            if (!function_exists($function)) {
                self::$errorMessage = "The PHOB extension is loaded, but the function '$function' is missing. " .
                                      "Ensure you are using the correct version (v3.2.1) from the official repository:\n" .
                                      self::getInstallationInstructions();
                return;
            }
        }

        // Verify phob_deviceID functionality
        $deviceId = @phob_deviceID();
        if ($deviceId === false) {
            self::$errorMessage = "The PHOB extension is loaded, but 'phob_deviceID' failed to return a valid device ID. " .
                                  "Check your system configuration or contact support via the repository:\n" .
                                  self::getInstallationInstructions();
            return;
        }

        // All checks passed
        self::$isInitialized = true;
    }

    /**
     * Get installation instructions for the PHOB extension
     *
     * @return string
     */
    private static function getInstallationInstructions()
    {
        return <<<EOT
To install the PHOB extension (v3.2.1), follow these steps:

1. Download the extension:
   ```bash
   wget https://github.com/sakibweb/PHOB/releases/download/latest/phob.so
   ```

2. Move the extension to your PHP extensions directory (replace with your path):
   ```bash
   sudo mv phob.so /usr/lib/php/20190902/
   ```
   Find your extensions directory:
   ```bash
   php -i | grep extension_dir
   ```

3. Locate your active php.ini file:
   ```bash
   php -i | grep 'Loaded Configuration File'
   ```

4. Enable the extension in php.ini:
   ```ini
   extension=phob.so
   ```

5. Restart your web server (e.g., Apache or PHP-FPM):
   ```bash
   sudo systemctl restart apache2
   ```
   or
   ```bash
   sudo systemctl restart php7.4-fpm
   ```

6. Verify installation:
   ```bash
   php -i | grep phob
   ```

For detailed instructions, visit: https://github.com/sakibweb/PHOB
EOT;
    }

    /**
     * Check if PHOB is ready to use
     *
     * @throws RuntimeException If the extension is not loaded or functions are missing
     */
    private static function checkInitialized()
    {
        if (!self::$isInitialized) {
            throw new RuntimeException(self::$errorMessage);
        }
    }

    /**
     * Get the unique device ID for the current machine
     *
     * @return string|bool Device ID string or false on failure
     * @throws RuntimeException If PHOB is not initialized
     */
    public static function deviceID()
    {
        if (!self::$isInitialized) {
            self::initialize();
        }
        self::checkInitialized();
        return phob_deviceID();
    }

    /**
     * Protect a PHP file by generating a secure, obfuscated output file
     *
     * @param string $inputPath Path to the input PHP file
     * @param string $outputPath Path for the protected output file
     * @param array $config Configuration array (key, pass, license, device, expiry)
     * @param array|null $skipList Optional array of files to skip
     * @return bool True on success, false on failure
     * @throws RuntimeException If PHOB is not initialized
     */
    public static function build($inputPath, $outputPath, $skipList = [], array $config)
    {
        if (!self::$isInitialized) {
            self::initialize();
        }
        self::checkInitialized();
        return phob_build($inputPath, $outputPath, $skipList, $config);
    }

    /**
     * Execute a PHOB-protected file after verifying security constraints
     *
     * @param string $inputPath Path to the protected file
     * @return bool True on successful execution, false on failure
     * @throws RuntimeException If PHOB is not initialized
     */
    public static function use($inputPath)
    {
        if (!self::$isInitialized) {
            self::initialize();
        }
        self::checkInitialized();
        return phob_use($inputPath);
    }
}
?>
