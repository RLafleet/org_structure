<?php

namespace App\Util;
require_once __DIR__ . '/../../public/vendor/autoload.php';

use App\Connection\ConnectionProvider;
use mysqli;
use mysqli_result;

class DbQueryUtil
{
    /**
     * @param string $sql
     * @return bool
     */
    public static function RealQuery(string $sql): bool
    {
        $connection = ConnectionProvider::getConnection();
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
        $connection = ConnectionProvider::getConnection();
        return mysqli_real_escape_string($connection, $str);
    }
    //настоящий класс connection с query с Quote

    /**
     * @param string $sql
     * @return bool|mysqli_result
     */
    private static function Query(string $sql): mysqli_result|bool
    {
        $connection = ConnectionProvider::getConnection();
        return mysqli_query($connection, $sql);
    }
}
