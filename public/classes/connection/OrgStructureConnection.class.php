<?php
declare(strict_types=1);

namespace classes\connection;

use classes\config\DbConfig;
use mysqli;

class OrgStructureConnection
{
    private static $orgStructureConnection;

    public function __construct()
    {
        self::$orgStructureConnection = new mysqli(DbConfig::DB_HOST, DbConfig::DB_USER, DbConfig::DB_PASS, DbConfig::DB_NAME);
    }

    public static function GetDbConnection()
    {
        if (!isset(self::$orgStructureConnection)) {
            new OrgStructureConnection();
        }
        return self::$orgStructureConnection;
    }
}