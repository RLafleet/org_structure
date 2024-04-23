<?php

namespace classes\dbTable;

use classes\util\DbQueryUtils;

require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/util/dbQueryUtil.class.php';

class BranchInsertTable
{
    /**
     * @param $city
     * @param $workersCount
     * @param $address
     * @return bool
     */
    public static function BranchDataInsert($city, $workersCount, $address)
    {
        $sql = "INSERT INTO company_branch 
            (city, workers_count, address)
            VALUES ('" . DbQueryUtils::Quote($city) . "',
                    '" . DbQueryUtils::Quote($workersCount) . "',
                    '" . DbQueryUtils::Quote($address) . "')";

        return DbQueryUtils::RealQuery($sql);
    }
}

?>
