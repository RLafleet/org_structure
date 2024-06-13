<?php

namespace App\DbTable;
require_once __DIR__ . '/../../public/vendor/autoload.php';

use App\Connection\ConnectionProvider;

class BranchWorkersHandler
{
    /**
     * @param int $branch_id
     * @return array
     */
    public static function getBranchWorkers(int $branch_id): array
    {
        $connectionProvider = new ConnectionProvider();
        $sql = "
            SELECT 
                * 
            FROM 
                user
            WHERE branch_id = " . $connectionProvider->Quote($branch_id) . "
        ";

        return $connectionProvider->Fetch($sql);
    }
}