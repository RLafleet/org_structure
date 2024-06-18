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
    public static function insertWorker(int $branchId, string $name, string $lastName, string $middleName, string $position): void
    {
        if (empty($name) || empty($lastName) || empty($middleName) || empty($position)) {
            throw new \InvalidArgumentException("Invalid input data");
        }

        $connectionProvider = new ConnectionProvider();
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

        $branchSql = "UPDATE company_branch SET workers_count = workers_count + 1 WHERE id = '" . $connectionProvider->Quote($branchId) . "'";
        $branchResult = $connectionProvider->RealQuery($branchSql);

        if (!$branchResult) {
            throw new \Exception("Failed to update workers count for branch");
        }
    }

    //todo DeleteWorker

    /**
     * @param int $worker_id
     * @return void
     * @throws \Exception
     */
    public static function deleteWorker(int $worker_id): void
    {
        $connectionProvider = new ConnectionProvider();

        $sql = "SELECT branch_id FROM user WHERE id='" . $connectionProvider->Quote($worker_id) . "'";
        $result = $connectionProvider->Fetch($sql);

        if (empty($result)) {
            throw new \Exception("Worker not found");
        }

        $branchId = $result[0]['branch_id'];

        if ($branchId !== null) {
            $sql = "DELETE FROM user WHERE id='" . $connectionProvider->Quote($worker_id) . "'";
            $deleteWorker = $connectionProvider->RealQuery($sql);
            if (!$deleteWorker) {
                throw new \Exception("Failed to delete user");
            }

            $branchSql = "UPDATE company_branch SET workers_count = workers_count - 1 WHERE id = '" . $connectionProvider->Quote($branchId) . "'";
            $branchResult = $connectionProvider->RealQuery($branchSql);

            if (!$branchResult) {
                throw new \Exception("Failed to update workers count for branch");
            }
        } else {
            throw new \Exception("Branch ID is null");
        }
    }

    //todo null вместо исключения. FindWorker

    /**
     * @param number $id
     * @return array|null
     */
    public static function findWorker($id): ?array
    {
        $connectionProvider = new ConnectionProvider();
        $sql = "
        SELECT 
            * 
        FROM 
            user
        WHERE id = " . $connectionProvider->Quote($id) . "
    ";

        $result = $connectionProvider->Fetch($sql);
        if (empty($result)) {
            return null;
        }

        return $result;
    }

    // todo UpdateWorker

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
    public static function updateWorker(int    $workerId,
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
        if (empty($name) || empty($lastName) || empty($middleName) || empty($email) || empty($sex) || empty($birthDate) || empty($comment) || empty($phoneNumber) || empty($hiringDate) || empty($position)) {
            throw new \InvalidArgumentException("Invalid input data");
        }

        $birthDateTime = new DateTime($birthDate);
        $hiringDateTime = new DateTime($hiringDate);

        $birthDateCassandra = $birthDateTime->format('Y-m-d');
        $hiringDateCassandra = $hiringDateTime->format('Y-m-d');

        $connectionProvider = new ConnectionProvider();
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