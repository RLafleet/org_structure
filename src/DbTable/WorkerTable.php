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
     * @param string $roleName
     * @return void
     * @throws \Exception
     */
    public static function insertWorker(int $branchId, string $name, string $lastName, string $middleName, string $roleName): void
    {
        if (empty($name) || empty($lastName) || empty($middleName) || empty($roleName)) {
            throw new \InvalidArgumentException("Invalid input data");
        }

        $connectionProvider = new ConnectionProvider();

        $email = strtolower($name . '.' . $lastName . '@mail');

        $password = "default";

        $teamId = "1";

        $phoneNumber = "Please, add phone number";

        $sex = "male";
        $birthDate = "21.01";
        $hiringDate = "21.01";
        $comment = "21.01";

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO user (
                    team_id, first_name, last_name, middle_name, phone_number,
                    email, sex, birth_date, hiring_date, comment, password
                ) VALUES (
                    " . ($teamId !== null ? "'" . $connectionProvider->Quote($teamId) . "'" : "NULL") . ",
                    '" . $connectionProvider->Quote($name) . "',
                    '" . $connectionProvider->Quote($lastName) . "',
                    " . ($middleName !== null ? "'" . $connectionProvider->Quote($middleName) . "'" : "NULL") . ",
                    " . ($phoneNumber !== null ? "'" . $connectionProvider->Quote($phoneNumber) . "'" : "NULL") . ",
                    '" . $connectionProvider->Quote($email) . "',
                    " . ($sex !== null ? "'" . $connectionProvider->Quote($sex) . "'" : "NULL") . ",
                    " . ($birthDate !== null ? "'" . $connectionProvider->Quote($birthDate) . "'" : "NULL") . ",
                    " . ($hiringDate !== null ? "'" . $connectionProvider->Quote($hiringDate) . "'" : "NULL") . ",
                    " . ($comment !== null ? "'" . $connectionProvider->Quote($comment) . "'" : "NULL") . ",
                    '" . $connectionProvider->Quote($hashedPassword) . "'
                )";

        // Получаем ID только что добавленного пользователя
        $workerId = $connectionProvider->GetLastInsertId();

        // Вставляем роль нового работника в таблицу employee_role
        $roleSql = "INSERT INTO employee_role 
            (employee_id, role_name)
            VALUES ('" . $connectionProvider->Quote($workerId) . "', '" . $connectionProvider->Quote($roleName) . "')";
        $roleResult = $connectionProvider->RealQuery($roleSql);

        if (!$roleResult) {
            throw new \Exception("Failed to assign role to user");
        }

        // Обновляем количество работников в филиале
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
