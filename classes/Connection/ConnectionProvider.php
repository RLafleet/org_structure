<?php
declare(strict_types=1);

namespace App\Connection;

use App\config\DbConfig;
use mysqli;
use mysqli_result;

class ConnectionProvider
{
    private mysqli $connection;

    public function __construct()
    {
        $this->connection = new mysqli(DbConfig::DB_HOST, DbConfig::DB_USER, DbConfig::DB_PASS, DbConfig::DB_NAME);
    }

    /**
     * @param string $sql
     * @return bool
     */
    public function RealQuery(string $sql): bool
    {
        return mysqli_real_query($this->connection, $sql);
    }

    /**
     * @param string $sql
     * @return array
     */
    public function Fetch(string $sql): array
    {
        $array = [];
        $result = $this->Query($sql);
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
    public function Quote(string $str): string
    {
        return mysqli_real_escape_string($this->connection, $str);
    }

    /**
     * @param string $sql
     * @return bool|mysqli_result
     */
    private function Query(string $sql): mysqli_result|bool
    {
        return mysqli_query($this->connection, $sql);
    }
}