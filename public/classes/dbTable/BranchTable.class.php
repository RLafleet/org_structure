<?php

namespace classes\dbTable;

use classes\util\DbQueryUtil;

require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/util/dbQueryUtil.class.php';

class BranchTable
{
    /**
     * @param string $city
     * @param int $workersCount
     * @param string $address
     * @return void
     */
    public static function BranchDataInsert(string $city, int $workersCount, string $address): void
    {
        $sql = "INSERT INTO company_branch 
            (city, workers_count, address)
            VALUES ('" . DbQueryUtil::Quote($city) . "',
                    '" . DbQueryUtil::Quote($workersCount) . "',
                    '" . DbQueryUtil::Quote($address) . "')";
        $result = DbQueryUtil::RealQuery($sql);

        if (!$result) {
            throw new \Exception("Failed to add new branch");
        }
    }

    /**
     * @param int $branch_id
     * @return void
     */
    public static function BranchDataDelete(int $branch_id): void
    {
        $sql = "DELETE FROM user WHERE branch_id = '" . DbQueryUtil::Quote($branch_id) . "'";
        $deleteUser = DbQueryUtil::RealQuery($sql);
        if (!$deleteUser) {
            throw new \Exception("Failed to delete users for branch");
        }
        $sql = "DELETE FROM company_branch WHERE id='" . DbQueryUtil::Quote($branch_id) . "'";
        $deleteBranch = DbQueryUtil::RealQuery($sql);

        if (!$deleteBranch) {
            throw new \Exception("Failed to add new branch");
        }
    }
}

?>
