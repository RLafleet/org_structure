<?php

namespace classes\dbTable;

use classes\util\DbQueryUtil;

require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/util/dbQueryUtil.class.php';

class WorkerTable
{
    /**
     * @param int $branchId
     * @param string $name
     * @param string $lastName
     * @param string $middleName
     * @param string $position
     * @return void
     */
    public static function WorkerDataInsert(int $branchId, string $name, string $lastName, string $middleName, string $position): void
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
        $result = DbQueryUtil::RealQuery($sql);

        if (!$result) {
            throw new \Exception("Failed to add user for branch");
        }
    }

    /**
     * @param int $worker_id
     * @return void
     */
    public static function WorkerDataDelete(int $worker_id): void
    {
        $sql = "DELETE FROM user WHERE id='" . DbQueryUtil::Quote($worker_id) . "'";
        $deleteUser = DbQueryUtil::RealQuery($sql);
        if (!$deleteUser) {
            throw new \Exception("Failed to delete users for branch");
        }
    }
}

?>
