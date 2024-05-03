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
        $sql = "INSERT INTO user 
            (branch_id, first_name, last_name, middle_name, phone_number, email, sex, birth_date, hiring_date, position, comment)
            VALUES ('" . ConnectionProvider::Quote($branchId) . "',
                    '" . ConnectionProvider::Quote($name) . "',
                    '" . ConnectionProvider::Quote($lastName) . "',
                    '" . ConnectionProvider::Quote($middleName) . "',
                    '" . ConnectionProvider::Quote("Please, add phone number") . "',
                    '" . ConnectionProvider::Quote("Please, add email") . "',
                    '" . ConnectionProvider::Quote("male") . "',
                    '" . ConnectionProvider::Quote("1985-09-20") . "',
                    '" . ConnectionProvider::Quote("1985-09-20") . "',
                    '" . ConnectionProvider::Quote($position) . "',
                    '" . ConnectionProvider::Quote("Please, add comment") . "')";
        $result = ConnectionProvider::RealQuery($sql);

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
        $sql = "DELETE FROM user WHERE id='" . ConnectionProvider::Quote($worker_id) . "'";
        $deleteUser = ConnectionProvider::RealQuery($sql);
        if (!$deleteUser) {
            throw new \Exception("Failed to delete users for branch");
        }
    }
}

?>
