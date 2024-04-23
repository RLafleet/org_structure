<?php

namespace classes\util;

use classes\connection\OrgStructureConnection;

require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/connection/OrgStructureConnection.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/config/DbConfig.class.php';

class DbQueryUtils
{
    /**
     * @param $sql
     * @return bool
     */
    public static function RealQuery($sql)
    {
        $connection = OrgStructureConnection::GetDbConnection();
        return mysqli_real_query($connection, $sql);
    }

    /**
     * @param $sql
     * @return array
     */
    public static function Fetch($sql): array
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
     * @param $str
     * @return string
     */
    public static function Quote($str)
    {
        $connection = OrgStructureConnection::GetDbConnection();
        return mysqli_real_escape_string($connection, $str);
    }

    /**
     * @param $sql
     * @return bool|mysqli_result
     */
    private static function Query($sql)
    {
        $connection = OrgStructureConnection::GetDbConnection();
        return mysqli_query($connection, $sql);
    }
}