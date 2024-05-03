<?php

namespace App\DbTable;
require_once __DIR__ . '/../../public/vendor/autoload.php';

use App\connection\ConnectionProvider;
use DateTime;

class WorkerUpdate
{
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
     * @throws \Exception
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

        $sql = "UPDATE user SET
                branch_id = '" . ConnectionProvider::Quote($branchId) . "',
                first_name = '" . ConnectionProvider::Quote($name) . "',
                last_name = '" . ConnectionProvider::Quote($lastName) . "',
                middle_name = '" . ConnectionProvider::Quote($middleName) . "',
                phone_number = '" . ConnectionProvider::Quote($phoneNumber) . "',
                email = '" . ConnectionProvider::Quote($email) . "',
                sex = '" . ConnectionProvider::Quote($sex) . "',
                birth_date = '" . ConnectionProvider::Quote($birthDateCassandra) . "',
                hiring_date = '" . ConnectionProvider::Quote($hiringDateCassandra) . "',
                position = '" . ConnectionProvider::Quote($position) . "',
                comment = '" . ConnectionProvider::Quote($comment) . "'
                WHERE id = '" . ConnectionProvider::Quote($workerId) . "'";

        $result = ConnectionProvider::RealQuery($sql);

        if (!$result) {
            throw new \Exception("Failed to update user data");
        }
    }
}