<?php

namespace classes\dbTable;

use classes\util\DbQueryUtil;

require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/util/dbQueryUtil.class.php';

class BranchInsertTable
{
    /**
     * @param string $city
     * @param int $workersCount
     * @param string $address
     * @return bool
     */
    public static function BranchDataInsert(string $city, int $workersCount, string $address): bool
    {
        $sql = "INSERT INTO company_branch 
            (city, workers_count, address)
            VALUES ('" . DbQueryUtil::Quote($city) . "',
                    '" . DbQueryUtil::Quote($workersCount) . "',
                    '" . DbQueryUtil::Quote($address) . "')";
        try
        {
            $result = DbQueryUtil::RealQuery($sql);
            if(!$result)
            {
                throw new \Exception("Failed to add new branch");
            }
        } catch (\Exception $e)
        {
            throw $e;
        }

        return DbQueryUtil::RealQuery($sql);
    }
}

?>
