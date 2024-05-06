<?php

namespace App\DbTable;
require_once __DIR__ . '/../../public/vendor/autoload.php';

use App\Connection\ConnectionProvider;

class BranchWorkersRequestTable
{
    /**
     * @param int $worker_id
     * @return array
     */
    public static function GetInfoAboutBranchesWorkers(int $worker_id): array
    {
        $connectionProvider = new ConnectionProvider();
        $sql = "
            SELECT 
                * 
            FROM 
                user
            WHERE branch_id = " . $connectionProvider->Quote($worker_id) . "
        ";

        return $connectionProvider->Fetch($sql);
    }
}