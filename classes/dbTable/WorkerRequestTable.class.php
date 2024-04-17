<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/util/dbQueryUtil.class.php';

class WorkerRequestTable
{
    /**
     * @param $id
     * @return array
     */
    public static function GetInfoAboutWorker($id): array
    {
        $sql = "
            SELECT 
                * 
            FROM 
                user
            WHERE id = " . DbQueryUtils::Quote($id) . "
        ";

        return DbQueryUtils::Fetch($sql);
    }
}