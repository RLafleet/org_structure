<?php

namespace App\DbTable;
require_once __DIR__ . '/../../public/vendor/autoload.php';

use App\connection\ConnectionProvider;

class WorkerTable
{
    /**
     * @param int $branchId
     * @param string $name
     * @param string $lastName
     * @param string $middleName
     * @param string $position
     * @return void
     * @throws \Exception
     */
    public static function WorkerDataInsert(int $branchId, string $name, string $lastName, string $middleName, string $position): void
    {
        $connectionProvider =  new ConnectionProvider();
        $sql = "INSERT INTO user 
            (branch_id, first_name, last_name, middle_name, phone_number, email, sex, birth_date, hiring_date, position, comment)
            VALUES ('" . $connectionProvider->Quote($branchId) . "',
                    '" . $connectionProvider->Quote($name) . "',
                    '" . $connectionProvider->Quote($lastName) . "',
                    '" . $connectionProvider->Quote($middleName) . "',
                    '" . $connectionProvider->Quote("Please, add phone number") . "',
                    '" . $connectionProvider->Quote("Please, add email") . "',
                    '" . $connectionProvider->Quote("male") . "',
                    '" . $connectionProvider->Quote("1985-09-20") . "',
                    '" . $connectionProvider->Quote("1985-09-20") . "',
                    '" . $connectionProvider->Quote($position) . "',
                    '" . $connectionProvider->Quote("Please, add comment") . "')";
        $result = $connectionProvider->RealQuery($sql);

        if (!$result) {
            throw new \Exception("Failed to add user for branch");
        }
    }

    /**
     * @param int $worker_id
     * @return void
     * @throws \Exception
     */
    public static function WorkerDataDelete(int $worker_id): void
    {
        $connectionProvider = new ConnectionProvider();
        $sql = "DELETE FROM user WHERE id='" . $connectionProvider->Quote($worker_id) . "'";
        $deleteUser = $connectionProvider->RealQuery($sql);
        if (!$deleteUser) {
            throw new \Exception("Failed to delete users for branch");
        }
    }
}

?>
