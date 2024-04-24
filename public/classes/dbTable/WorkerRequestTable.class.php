<?php

namespace classes\dbTable;

use classes\util\DbQueryUtil;

require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/util/dbQueryUtil.class.php';

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
            WHERE id = " . DbQueryUtil::Quote($id) . "
        ";

        return DbQueryUtil::Fetch($sql);
    }
}