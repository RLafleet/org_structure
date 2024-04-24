<?php

namespace classes\dbTable;

use classes\util\DbQueryUtil;

require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/util/dbQueryUtil.class.php';

class WorkerInsertTable
{
    /**
     * @param int $branchId
     * @param string $name
     * @param string $lastName
     * @param string $middleName
     * @param string $position
     * @return bool
     */
    public static function WorkerDataInsert(int $branchId, string $name, string $lastName, string $middleName, string $position): bool
    {
        $sql = "INSERT INTO user 
            (branch_id, first_name, last_name, middle_name, phone_number, email, sex, birth_date, hiring_date, position, comment)
            VALUES ('" . DbQueryUtil::Quote($branchId) . "',
                    '" . DbQueryUtil::Quote($name) . "',
                    '" . DbQueryUtil::Quote($lastName) . "',
                    '" . DbQueryUtil::Quote($middleName) . "',
                    '" . DbQueryUtil::Quote("") . "',
                    '" . DbQueryUtil::Quote("") . "',
                    '" . DbQueryUtil::Quote("male") . "',
                    '" . DbQueryUtil::Quote("1985-09-20") . "',
                    '" . DbQueryUtil::Quote("1985-09-20") . "',
                    '" . DbQueryUtil::Quote($position) . "',
                    '" . DbQueryUtil::Quote("") . "')";

        return DbQueryUtil::RealQuery($sql);
    }
}

?>
