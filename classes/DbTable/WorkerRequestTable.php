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
        $sql = "
            SELECT 
                * 
            FROM 
                user
            WHERE id = " . ConnectionProvider::Quote($id) . "
        ";

        return ConnectionProvider::Fetch($sql);
    }
}