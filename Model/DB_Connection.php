<?php

require_once __DIR__ . '/EnvLoader.php';

/**
 * DB_Connection.php
 *
 * Creates a reusable MySQLi database connection.
 * 
 */

class DB_Connection
{
    private static $connection = null;

    public static function getConnection()
    {
        if (self::$connection !== null) {
            return self::$connection;
        }

        EnvLoader::load(__DIR__ . '/.env');

        $host = getenv('DB_HOST');
        $username = getenv('DB_USERNAME');
        $password = getenv('DB_PASSWORD');
        $databaseName = getenv('DB_NAME');

        self::$connection = mysqli_connect($host, $username, $password, $databaseName);

        if (!self::$connection) {
            error_log("Database connection failed: " . mysqli_connect_error());
            return null;
        }

        mysqli_set_charset(self::$connection, 'utf8mb4');

        return self::$connection;
    }
}