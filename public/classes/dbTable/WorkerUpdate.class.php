<?php

namespace classes\dbTable;

use Cassandra\Date;
use classes\util\DbQueryUtil;

require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/util/dbQueryUtil.class.php';

class WorkerUpdate
{
    /**
     * @param int $workerId
     * @param int $branchId
     * @param string $name
     * @param string $lastName
     * @param string $middleName
     * @param string $position
     * @param string $sex Accepts either 'male' or 'female',
     * @param string $email
     * @param Date $birthDate
     * @param Date $hiringDate
     * @param string $comment
     * @param string $phoneNumber
     * @return bool
     */
    public static function WorkerUpdateInfo(int $workerId,
                                            int    $branchId,
                                            string $name,
                                            string $lastName,
                                            string $middleName,
                                            string $position,
                                            string $sex,
                                            string $email,
                                            Date   $birthDate,
                                            Date   $hiringDate,
                                            string $comment,
                                            string $phoneNumber): bool
    {
        $sql = "UPDATE user SET
                branch_id = '" . DbQueryUtil::Quote($branchId) . "',
                first_name = '" . DbQueryUtil::Quote($name) . "',
                last_name = '" . DbQueryUtil::Quote($lastName) . "',
                middle_name = '" . DbQueryUtil::Quote($middleName) . "',
                phone_number = '" . DbQueryUtil::Quote($phoneNumber) . "',
                email = '" . DbQueryUtil::Quote($email) . "',
                sex = '" . DbQueryUtil::Quote($sex) . "',
                birth_date = '" . DbQueryUtil::Quote($birthDate) . "',
                hiring_date = '" . DbQueryUtil::Quote($hiringDate) . "',
                position = '" . DbQueryUtil::Quote($position) . "',
                comment = '" . DbQueryUtil::Quote($comment) . "'
                WHERE id = '" . DbQueryUtil::Quote($workerId) . "'";

        return DbQueryUtil::RealQuery($sql);
    }
}

?>
