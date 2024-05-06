<?php

namespace App\DbTable;
require_once __DIR__ . '/../../public/vendor/autoload.php';

use App\connection\ConnectionProvider;
use DateTime;
use Exception;

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