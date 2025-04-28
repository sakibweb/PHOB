# PHOB - PHP Obfuscator
or
# PHOB - The Ultimate PHP Code Protection Extension

Welcome to **PHOB**, the most secure and robust PHP code protection extension ever created. Engineered to safeguard your PHP applications with unparalleled strength, PHOB ensures your code remains untouchable, making it virtually unbreakable in your lifetime. Designed for developers who demand the highest level of security without compromising ease of use, PHOB sets a new standard in PHP code protection that you’ve never seen before. Protect your intellectual property with confidence using the hardest, most resilient security solution available for PHP.

PHOB is a lightweight, cross-platform PHP extension that seamlessly integrates with your PHP environment, offering advanced code protection, device authentication, and optional configuration for enhanced control. Whether you're building enterprise-grade applications or protecting sensitive scripts, PHOB delivers unmatched security with a simple, developer-friendly interface.

---

## Features

- **Unbreakable Security**: PHOB provides the toughest code protection in PHP, ensuring your scripts are safe from unauthorized access, tampering, or reverse-engineering.
- **Device Authentication**: Lock your protected code to specific devices for enhanced security (optional).
- **Expiry Control**: Set optional expiration dates to restrict code usage after a specified period.
- **Cross-Platform Compatibility**: Works flawlessly on Linux, macOS, and Windows with PHP 7.x and 8.x.
- **Lightweight & Fast**: Minimal performance overhead, designed for production environments.
- **Easy Integration**: Simple installation and intuitive PHP functions for protecting and executing code.
- **Flexible Configuration**: Optional INI settings for tailored security policies.
- **Developer-Friendly**: Clear error messages and debugging support for seamless development.

With PHOB, your PHP code is shielded by the most advanced protection mechanisms, making it a fortress that stands strong against any threat.

---

## Download & Installation

PHOB is available as a pre-built extension (`phob.so`) for easy installation. Follow these steps to get started:

### Step 1: Download the Extension
Download the latest PHOB release (v3.2.1) from GitHub:

```bash
wget https://github.com/sakibweb/PHOB/releases/download/latest/phob.so
```

Alternatively, download `phob.so` directly from the [GitHub Releases page](https://github.com/sakibweb/PHOB/releases/download/latest/phob.so).

### Step 2: Move the Extension
Move the downloaded `phob.so` file to your PHP extensions directory. You may need `sudo` for write permissions:

```bash
sudo mv phob.so /usr/lib/php/20190902/
```

**Note**: Replace `/usr/lib/php/20190902/` with your PHP extensions directory. To find it, run:

```bash
php -i | grep extension_dir
```

### Step 3: Locate the Active `php.ini` File
Find the active `php.ini` file used by your PHP installation:

```bash
php -i | grep 'Loaded Configuration File'
```

Example output:
```
Loaded Configuration File => /etc/php/7.4/cli/php.ini
```

### Step 4: Enable the Extension
Edit the `php.ini` file to enable PHOB. Add the following line at the end of the file:

```ini
extension=phob.so
```

Save the file and exit.

### Step 5: Restart Your Web Server
Restart your web server to apply the changes. For example:

- **Apache**:
  ```bash
  sudo systemctl restart apache2
  ```

- **Nginx with PHP-FPM**:
  ```bash
  sudo systemctl restart php7.4-fpm
  ```

Replace `php7.4-fpm` with your PHP-FPM version (e.g., `php8.1-fpm`).

### Step 6: Verify Installation
Check if PHOB is loaded by running:

```bash
php -i | grep phob
```

Or create a PHP script (`info.php`) with:

```php
<?php phpinfo(); ?>
```

Access it via your web server and search for the "phob" section. You should see:

```
phob support => enabled
Version => 3.2.1
License Key Check => Supported
Device ID Check => Supported
Expiry Date Check => Supported
```

If the section appears, PHOB is installed correctly!

---

## Available Functions

PHOB provides three simple yet powerful PHP functions to protect and execute your code:

1. **`phob_build(string $input_path, string $output_path, array $config, array $skip_list = null): bool`**
   - Protects a PHP file by generating a secure, obfuscated output file.
   - Parameters:
     - `$input_path`: Path to the input PHP file.
     - `$output_path`: Path for the protected output file.
     - `$config`: Array with optional settings (`key`, `pass`, `license`, `device`, `expiry`).
     - `$skip_list`: Optional array of files to skip during processing.
   - Returns: `true` on success, `false` on failure.

2. **`phob_use(string $input_path): bool`**
   - Executes a PHOB-protected file after verifying security constraints.
   - Parameters:
     - `$input_path`: Path to the protected file.
   - Returns: `true` on successful execution, `false` on failure.

3. **`phob_deviceID(): string|bool`**
   - Retrieves the unique device ID for the current machine.
   - Returns: A 14-character device ID string or `false` if unavailable.

---

## Configuration

PHOB configuration is **optional** and can be set via the `php.ini` file or the `$config` array in `phob_build`. The following INI directives are supported:

| Directive       | Description                           | Default |
|-----------------|---------------------------------------|---------|
| `phob.key`      | Custom key for protection (optional). | Empty   |
| `phob.license`  | License key (optional).               | Empty   |
| `phob.device`   | Device ID for locking (optional).     | Empty   |
| `phob.expiry`   | Expiry date (DD/MM/YYYY, optional).   | Empty   |

To configure in `php.ini`, add:

```ini
phob.key = "your-secret-key"
phob.license = "your-license-key"
phob.device = "DEVICEID12345678"
phob.expiry = "31/12/2025"
```

Alternatively, pass these settings in the `$config` array when calling `phob_build`:

```php
$config = [
    'key' => 'your-secret-key',
    'pass' => 'your-secret-password',
    'license' => 'your-license-key',
    'device' => 'DEVICEID12345678',
    'expiry' => '31/12/2025'
];
```

**Note**: The `key` and `pass` fields are required in the `$config` array for `phob_build`, but `license`, `device`, and `expiry` are optional. INI settings are not mandatory and can be left unset for basic usage.

---

## Usage Examples

### Example 1: Protecting a PHP File
Create a PHP script (`script.php`) to protect:

```php
<?php
echo "Hello, this is a protected script!";
?>
```

Protect it using `phob_build`:

```php
<?php
$config = [
    'key' => 'my-secret-key',
    'pass' => 'my-secret-password',
    'license' => 'LICENSE123',
    'device' => 'DEVICEID12345678', // Optional
    'expiry' => '31/12/2025'        // Optional
];
$skip_list = ['other_script.php']; // Optional
if (phob_build('script.php', 'protected_script.phob', $skip_list, $config)) {
    echo "File protected successfully!\n";
} else {
    echo "Failed to protect file.\n";
}
?>
```

**Output File (`protected_script.phob`)**:
```
██████╗░██╗░░██╗░█████╗░██████╗░
██╔══██╗██║░░██║██╔══██╗██╔══██╗
██████╔╝███████║██║░░██║██████╦╝
██╔═══╝░██╔══██║██║░░██║██╔══██╗
██║░░░░░██║░░██║╚█████╔╝██████╦╝
╚═╝░░░░░╚═╝░░╚═╝░╚════╝░╚═════╝░
################################
#  PHOB - PHP obfuscator Tool  #
#  ---- PHOB By @sakibweb ---- #
################################

> Build On:28/04/2025 10:15 AM <

[protected data]
```

### Example 2: Executing a Protected File
Execute the protected file using `phob_use`:

```php
<?php
if (phob_use('protected_script.phob')) {
    echo "Protected script executed successfully!\n";
} else {
    echo "Failed to execute protected script.\n";
}
?>
```

**Output**:
```
Hello, this is a protected script!
Protected script executed successfully!
```

### Example 3: Getting the Device ID
Retrieve the device ID for use in configuration:

```php
<?php
$device_id = phob_deviceID();
if ($device_id) {
    echo "Device ID: $device_id\n";
} else {
    echo "Could not retrieve device ID.\n";
}
?>
```

**Output**:
```
Device ID: DEVICEID12345678
```

---

## Debugging & Error Handling

PHOB provides clear error messages to help diagnose issues during development. Errors are logged via PHP’s error reporting system and can be enabled or viewed as follows:

### Enabling Error Display
To show errors, ensure error reporting is enabled in `php.ini`:

```ini
display_errors = On
error_reporting = E_ALL
```

Restart your web server after making changes.

### Viewing Errors
Run your script via the command line or a web browser. Example errors include:

- **"Key is required"**: Missing `key` in the `$config` array for `phob_build`.
- **"Service is expired"**: The `expiry` date has passed.
- **"Service not authenticated for this device"**: The device ID doesn’t match.
- **"Cannot open protected file"**: Invalid or missing input file for `phob_use`.

Check the PHP error log (location specified in `php.ini` under `error_log`) for detailed messages.

### Debugging Tips
- **Verify Installation**: Use `phpinfo()` to confirm PHOB is loaded.
- **Check File Paths**: Ensure input/output paths in `phob_build` and `phob_use` are correct.
- **Test Device ID**: Run `phob_deviceID()` to verify the device ID for your machine.
- **Validate Config**: Ensure `$config` has valid `key` and `pass` values, and optional fields (`license`, `device`, `expiry`) are correctly formatted.
- **Enable Verbose Logging**: If needed, contact the developer for advanced debugging options (not included in the public release).

Errors are designed to be developer-friendly without exposing sensitive details, ensuring security even during debugging.

---

## Why Choose PHOB?

PHOB is not just another PHP extension—it’s a revolution in code security. Here’s why PHOB stands out:

- **Unmatched Protection**: PHOB’s security is so robust that it’s virtually impossible to breach, protecting your code like never before.
- **Seamless Integration**: Install and use PHOB in minutes with minimal setup.
- **Flexible & Powerful**: Optional device locking and expiry controls give you full control over your code’s usage.
- **Trusted by Developers**: Built by [@sakibweb](https://github.com/sakibweb), PHOB is backed by a commitment to quality and security.

With PHOB, you’re not just protecting your code—you’re securing your future. Join the thousands of developers who trust PHOB to keep their PHP applications safe.

---

## License

PHOB is released under a proprietary license. See the [GitHub repository](https://github.com/sakibweb/PHOB) for details.

---

## Support

For issues, feature requests, or questions, open an issue on the [GitHub repository](https://github.com/sakibweb/PHOB/issues). For enterprise support, contact the developer directly.

---

**PHOB: Protect Your Code. Secure Your Future.**
