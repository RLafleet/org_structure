<?php
declare(strict_types=1);

namespace App\Connection;

use App\config\DbConfig;
use mysqli;

class ConnectionProvider
{
    private static mysqli $connection;

    public function __construct()
    {
        self::$connection = new mysqli(DbConfig::DB_HOST, DbConfig::DB_USER, DbConfig::DB_PASS, DbConfig::DB_NAME);
    }

    public static function getConnection(): mysqli
    {
        if (!isset(self::$connection)) {
            new ConnectionProvider();
        }
        return self::$connection;
    }
}