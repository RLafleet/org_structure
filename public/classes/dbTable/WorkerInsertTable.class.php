<?php

namespace classes\dbTable;

use classes\util\DbQueryUtils;

require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/util/dbQueryUtil.class.php';

class WorkerInsertTable
{
    /**
     * @param $branchId
     * @param $city
     * @param $name
     * @param $workersCount
     * @param $address
     * @return bool
     */
    public static function WorkerDataInsert($branchId, $name, $lastName, $middleName, $position)
    {
        $sql = "INSERT INTO user 
            (branch_id, first_name, last_name, middle_name, phone_number, email, sex, birth_date, hiring_date, position, comment)
            VALUES ('" . DbQueryUtils::Quote($branchId) . "',
                    '" . DbQueryUtils::Quote($name) . "',
                    '" . DbQueryUtils::Quote($lastName) . "',
                    '" . DbQueryUtils::Quote($middleName) . "',
                    '" . DbQueryUtils::Quote("") . "',
                    '" . DbQueryUtils::Quote("") . "',
                    '" . DbQueryUtils::Quote("male") . "',
                    '" . DbQueryUtils::Quote("1985-09-20") . "',
                    '" . DbQueryUtils::Quote("1985-09-20") . "',
                    '" . DbQueryUtils::Quote($position) . "',
                    '" . DbQueryUtils::Quote("") . "')";

        return DbQueryUtils::RealQuery($sql);
    }
}

?>
