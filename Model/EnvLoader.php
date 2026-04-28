<?php

/**
 * @class EnvLoader
 * Loads environment variables from a .env file.
 */
class EnvLoader
{
    /**
     * @param string $filePath
     * @returns {bool}
     */
    public static function load($filePath)
    {
        if (!file_exists($filePath)) {
            error_log(".env file not found: " . $filePath);
            return false;
        }

        $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            $line = trim($line);

            if ($line === '' || strpos($line, '=') === false || str_starts_with($line, '#')) {
                continue;
            }

            [$key, $value] = explode('=', $line, 2);

            putenv(trim($key) . '=' . trim($value));
        }

        return true;
    }
}