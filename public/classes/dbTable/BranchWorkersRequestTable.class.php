<?php

namespace classes\dbTable;

use classes\util\DbQueryUtils;

require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/util/dbQueryUtil.class.php';

class BranchWorkersRequestTable
{
    /**
     * @param $worker_id
     * @return array
     */
    public static function GetInfoAboutBranchesWorkers($worker_id): array
    {
        $sql = "
            SELECT 
                * 
            FROM 
                user
            WHERE branch_id = " . DbQueryUtils::Quote($worker_id) . "
        ";

        return DbQueryUtils::Fetch($sql);
    }
}