<?php

namespace App\DbTable;
require_once __DIR__ . '/../../public/vendor/autoload.php';

use App\Util\dbQueryUtil;

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
            WHERE branch_id = " . DbQueryUtil::Quote($worker_id) . "
        ";

        return DbQueryUtil::Fetch($sql);
    }
}