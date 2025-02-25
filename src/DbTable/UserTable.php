<?php

namespace App\DbTable;

require_once __DIR__ . '/../../public/vendor/autoload.php';

use App\connection\ConnectionProvider;

class UserTable
{
    /**
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     * @param string $password
     * @param string|null $phoneNumber
     * @param string|null $middleName
     * @param string|null $sex
     * @param string|null $birthDate
     * @param string|null $hiringDate
     * @param string|null $comment
     * @param int|null $teamId
     * @return void
     * @throws \Exception
     */
    public static function registerUser(
        string $firstName,
        string $lastName,
        string $email,
        string $password,
        ?string $phoneNumber = null,
        ?string $middleName = null,
        ?string $sex = null,
        ?string $birthDate = null,
        ?string $hiringDate = null,
        ?string $comment = null,
        ?int $teamId = null
    ): void {
        if (empty($firstName) || empty($lastName) || empty($email) || empty($password)) {
            throw new \InvalidArgumentException("First name, last name, email, and password are required");
        }

        $connectionProvider = new ConnectionProvider();

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $sql = "INSERT INTO user (
                    team_id, first_name, last_name, middle_name, phone_number,
                    email, sex, birth_date, hiring_date, comment, password
                ) VALUES (
                    " . ($teamId !== null ? "'" . $connectionProvider->Quote($teamId) . "'" : "NULL") . ",
                    '" . $connectionProvider->Quote($firstName) . "',
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

        $result = $connectionProvider->RealQuery($sql);

        if (!$result) {
            throw new \Exception("Failed to register user");
        }
    }

    /**
     * @param string $email
     * @return bool
     * @throws \Exception
     */
    public static function isEmailExists(string $email): bool
    {
        $connectionProvider = new ConnectionProvider();

        $sql = "SELECT COUNT(*) as count FROM user WHERE email = '" . $connectionProvider->Quote($email) . "'";
        $result = $connectionProvider->Fetch($sql);

        return !empty($result) && $result[0]['count'] > 0;
    }

    /**
     * @return array
     */
    public static function listUsers(): array
    {
        $connectionProvider = new ConnectionProvider();
        $sql = "SELECT * FROM user";
        return $connectionProvider->Fetch($sql);
    }

    /**
     * @param int $id
     * @return array|null
     */
    public static function findUser(int $id): ?array
    {
        $connectionProvider = new ConnectionProvider();
        $sql = "SELECT * FROM user WHERE id = " . $connectionProvider->Quote($id);
        $result = $connectionProvider->Fetch($sql);

        if (empty($result)) {
            return null;
        }

        return $result[0];
    }

    /**
     * @param int $id
     * @return void
     * @throws \Exception
     */
    public static function deleteUser(int $id): void
    {
        $connectionProvider = new ConnectionProvider();
        $sql = "DELETE FROM user WHERE id = " . $connectionProvider->Quote($id);
        $result = $connectionProvider->RealQuery($sql);

        if (!$result) {
            throw new \Exception("Failed to delete user");
        }
    }

    public static function updateUser(int $id, array $data): void
    {
        if (empty($data)) {
            throw new \InvalidArgumentException("No data provided for update");
        }

        $connectionProvider = new ConnectionProvider();
        $updates = [];

        foreach ($data as $key => $value) {
            // Обновляем только те поля, которые переданы и не пусты
            if ($value !== null && $value !== '') {
                $updates[] = $key . " = '" . $connectionProvider->Quote($value) . "'";
            }
        }

        // Если нет полей для обновления, выходим
        if (empty($updates)) {
            return;
        }

        $sql = "UPDATE user SET " . implode(", ", $updates) . " WHERE id = " . $connectionProvider->Quote($id);
        $result = $connectionProvider->RealQuery($sql);

        if (!$result) {
            throw new \Exception("Failed to update user");
        }
    }

    /**
     * @param int $id
     * @return array|null
     */
    public static function getUserDetails(int $id): ?array
    {
        $connectionProvider = new ConnectionProvider();
        $sql = "SELECT * FROM user WHERE id = " . $connectionProvider->Quote($id);
        $result = $connectionProvider->Fetch($sql);

        if (empty($result)) {
            return null;
        }
        return $result[0];
    }
}