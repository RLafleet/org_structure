<?php

namespace App\DbTable;
require_once __DIR__ . '/../../public/vendor/autoload.php';

use App\Util\DbQueryUtil;

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