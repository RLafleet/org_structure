<?php

namespace classes\util;

use classes\connection\OrgStructureConnection;
use mysqli;
use mysqli_result;

require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/connection/OrgStructureConnection.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/config/DbConfig.class.php';

class DbQueryUtil
{
    /**
     * @param string $sql
     * @return bool
     */
    public static function RealQuery(string $sql): bool
    {
        $connection = OrgStructureConnection::GetDbConnection();
        return mysqli_real_query($connection, $sql);
    }

    /**
     * @param string $sql
     * @return array
     */
    public static function Fetch(string $sql): array
    {
        $array = [];
        $result = self::Query($sql);
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $array[] = $row;
            }
            mysqli_free_result($result);
        }

        return $array;
    }

    /**
     * @param string $str
     * @return string
     */
    public static function Quote(string $str): string
    {
        $connection = OrgStructureConnection::GetDbConnection();
        return mysqli_real_escape_string($connection, $str);
    }

    /**
     * @param string $sql
     * @return bool|mysqli_result
     */
    private static function Query(string $sql)
    {
        $connection = OrgStructureConnection::GetDbConnection();
        return mysqli_query($connection, $sql);
    }
}
?>
