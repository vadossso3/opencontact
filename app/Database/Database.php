<?php

namespace App\Database;

use Exception;
use PDO;

class Database
{
    private static PDO $instance;

    private function __construct() {}

    private function __clone() {}

    public static function getInstance(): PDO
    {
        if (!isset(self::$instance)) {
            try {
                self::$instance = new PDO("{$_ENV['MYSQL_HOST']}:host={$_ENV['MYSQL_HOST']};port={$_ENV['MYSQL_PORT']};dbname={$_ENV['MYSQL_DATABASE']}", $_ENV['MYSQL_USER'], $_ENV['MYSQL_PASSWORD']);

                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (Exception $exception) {
                throw new Exception($exception->getMessage());
            }
        }

        return self::$instance;
    }
}
