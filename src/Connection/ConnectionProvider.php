<?php
declare(strict_types=1);

namespace App\Connection;

use App\config\DbConfig;
use mysqli;
use mysqli_result;

class ConnectionProvider
{
    private static ?mysqli $connection = null;

    private static function getEnv(): string
    {
        return getenv('APP_ENV') ?: 'production';
    }


    public function __construct()
    {
        $config = DbConfig::getConfig(self::getEnv());
        self::$connection = new mysqli($config['DB_HOST'], $config['DB_USER'], $config['DB_PASS'], $config['DB_NAME']);
    }

    /**
     * @param string $sql
     * @return bool
     */
    public function RealQuery(string $sql): bool
    {
        return mysqli_real_query(self::$connection, $sql);
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
        return mysqli_real_escape_string(self::$connection, $str);
    }

    /**
     * @param string $sql
     * @return bool|mysqli_result
     */
    private function Query(string $sql): mysqli_result|bool
    {
        return mysqli_query(self::$connection, $sql);
    }

    /**
     * @throws \Exception
     */
    public static function getConnection(): mysqli
    {
        if (self::$connection === null) {
            $config = DbConfig::getConfig(self::getEnv());
            self::$connection = new mysqli($config['DB_HOST'], $config['DB_USER'], $config['DB_PASS'], $config['DB_NAME']);

            if (self::$connection->connect_error) {
                throw new \Exception('Connection failed: ' . self::$connection->connect_error);
            }
        }

        return self::$connection;
    }

    public static function closeConnection(): void
    {
        if (self::$connection !== null) {
            self::$connection->close();
            self::$connection = null;
        }
    }
}
