<?php

namespace App\DbTable;
require_once __DIR__ . '/../../public/vendor/autoload.php';

use App\connection\ConnectionProvider;
use DateTime;
use Exception;

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

    /**
     * @param number $id
     * @return array
     */
    public static function GetInfoAboutWorker($id): array
    {
        $connectionProvider = new ConnectionProvider();
        $sql = "
            SELECT 
                * 
            FROM 
                user
            WHERE id = " . $connectionProvider->Quote($id) . "
        ";

        return $connectionProvider->Fetch($sql);
    }

    /**
     * @param int $workerId
     * @param int $branchId
     * @param string $name
     * @param string $lastName
     * @param string $middleName
     * @param string $email
     * @param string $sex
     * @param string $birthDate
     * @param string $hiringDate
     * @param string $position
     * @param string $comment
     * @param string $phoneNumber
     * @return void
     * @throws Exception
     */
    public static function WorkerUpdateInfo(int $workerId,
                                            int    $branchId,
                                            string $name,
                                            string $lastName,
                                            string $middleName,
                                            string $email,
                                            string $sex,
                                            string $birthDate,
                                            string $hiringDate,
                                            string $position,
                                            string $comment,
                                            string $phoneNumber): void
    {
        $birthDateTime = new DateTime($birthDate);
        $hiringDateTime = new DateTime($hiringDate);

        $birthDateCassandra = $birthDateTime->format('Y-m-d');
        $hiringDateCassandra = $hiringDateTime->format('Y-m-d');

        $connectionProvider =  new ConnectionProvider();
        $sql = "UPDATE user SET
                branch_id = '" . $connectionProvider->Quote($branchId) . "',
                first_name = '" . $connectionProvider->Quote($name) . "',
                last_name = '" . $connectionProvider->Quote($lastName) . "',
                middle_name = '" . $connectionProvider->Quote($middleName) . "',
                phone_number = '" . $connectionProvider->Quote($phoneNumber) . "',
                email = '" . $connectionProvider->Quote($email) . "',
                sex = '" . $connectionProvider->Quote($sex) . "',
                birth_date = '" . $connectionProvider->Quote($birthDateCassandra) . "',
                hiring_date = '" . $connectionProvider->Quote($hiringDateCassandra) . "',
                position = '" . $connectionProvider->Quote($position) . "',
                comment = '" . $connectionProvider->Quote($comment) . "'
                WHERE id = '" . $connectionProvider->Quote($workerId) . "'";

        $result = $connectionProvider->RealQuery($sql);

        if (!$result) {
            throw new Exception("Failed to update user data");
        }
    }
}