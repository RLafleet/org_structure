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
        $sql = "
            SELECT 
                * 
            FROM 
                user
            WHERE branch_id = " . ConnectionProvider::Quote($worker_id) . "
        ";

        return ConnectionProvider::Fetch($sql);
    }
}