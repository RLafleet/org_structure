<?php

namespace App\DbTable;
require_once __DIR__ . '/../../public/vendor/autoload.php';

use App\Connection\ConnectionProvider;

class WorkerRequestTable
{
    /**
     * @param number $id
     * @return array
     */
    public static function GetInfoAboutWorker($id): array
    {
        $connectionProvider = new ConnectionProvider();
        $sql = "
            SELECT 
                * 
            FROM 
                user
            WHERE id = " . $connectionProvider->Quote($id) . "
        ";

        return $connectionProvider->Fetch($sql);
    }
}