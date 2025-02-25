<?php

namespace App\Auth;

require_once __DIR__ . '/../../public/vendor/autoload.php';

use App\DbTable\EmployeeRoleTable;
use App\DbTable\UserTable;
use App\connection\ConnectionProvider;

class Auth
{
    /**
     * @param string $email
     * @param string $password
     * @return bool
     * @throws \Exception
     */
    public static function login(string $email, string $password): bool
    {
        $connectionProvider = new ConnectionProvider();

        $sql = "SELECT id, password FROM user WHERE email = '" . $connectionProvider->Quote($email) . "'";
        $user = $connectionProvider->Fetch($sql);

        if (empty($user)) {
            throw new \Exception("Invalid email or password");
        }

        $hashedPassword = $user[0]['password'];

        if (!password_verify($password, $hashedPassword)) {
            throw new \Exception("Invalid email or password");
        }

        $_SESSION['user_id'] = $user[0]['id'];
        $role = EmployeeRoleTable::getUserRole($user[0]['id']);
        setcookie('user_id', $user[0]['id'], time() + 3600, '/');
        setcookie('user_role', $role, time() + 3600, '/');

        return true;
    }

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
    public static function register(
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
        if (UserTable::isEmailExists($email)) {
            throw new \Exception("Email already exists");
        }

        UserTable::registerUser(
            $firstName,
            $lastName,
            $email,
            $password,
            $phoneNumber,
            $middleName,
            $sex,
            $birthDate,
            $hiringDate,
            $comment,
            $teamId
        );
    }

    /**
     * @return void
     */
    public static function logout(): void
    {
        setcookie('is_authenticated', '', time() - 3600, '/');

        setcookie('user_role', '', time() - 3600, '/');

        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }
    }
}
