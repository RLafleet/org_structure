<?php

namespace classes\dbTable;

use classes\util\DbQueryUtil;

require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/util/dbQueryUtil.class.php';

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