<?php

namespace classes\dbTable;

use classes\util\DbQueryUtil;
use DateTime;

require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/util/dbQueryUtil.class.php';

class WorkerUpdate
{
    /**
     * @param int $workerId
     * @param int $branchId
     * @param string $name
     * @param string $lastName
     * @param string $middleName
     * @param string $email
     * @param string $sex Accepts either 'male' or 'female',
     * @param string $birthDate
     * @param string $hiringDate
     * @param string $position
     * @param string $comment
     * @param string $phoneNumber
     * @return void
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
                branch_id = '" . DbQueryUtil::Quote($branchId) . "',
                first_name = '" . DbQueryUtil::Quote($name) . "',
                last_name = '" . DbQueryUtil::Quote($lastName) . "',
                middle_name = '" . DbQueryUtil::Quote($middleName) . "',
                phone_number = '" . DbQueryUtil::Quote($phoneNumber) . "',
                email = '" . DbQueryUtil::Quote($email) . "',
                sex = '" . DbQueryUtil::Quote($sex) . "',
                birth_date = '" . DbQueryUtil::Quote($birthDateCassandra) . "',
                hiring_date = '" . DbQueryUtil::Quote($hiringDateCassandra) . "',
                position = '" . DbQueryUtil::Quote($position) . "',
                comment = '" . DbQueryUtil::Quote($comment) . "'
                WHERE id = '" . DbQueryUtil::Quote($workerId) . "'";

        $result = DbQueryUtil::RealQuery($sql);

        if (!$result) {
            throw new \Exception("Failed to update user data");
        }
    }
}