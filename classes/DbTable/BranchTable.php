<?php

namespace App\DbTable;
require_once __DIR__ . '/../../public/vendor/autoload.php';

use App\connection\ConnectionProvider;

class BranchTable
{
    /**
     * @param string $city
     * @param int $workersCount
     * @param string $address
     * @return void
     * @throws \Exception
     */
    public static function BranchDataInsert(string $city, int $workersCount, string $address): void
    {
        $connectionProvider = new ConnectionProvider();
        $sql = "INSERT INTO company_branch 
            (city, workers_count, address)
            VALUES ('" . $connectionProvider->Quote($city) . "',
                    '" . $connectionProvider->Quote($workersCount) . "',
                    '" . $connectionProvider->Quote($address) . "')";
        $result = $connectionProvider->RealQuery($sql);

        if (!$result) {
            throw new \Exception("Failed to add new branch");
        }
    }

    /**
     * @param int $branch_id
     * @return void
     * @throws \Exception
     */
    public static function BranchDataDelete(int $branch_id): void
    {
        $connectionProvider = new ConnectionProvider();
        $sql = "DELETE FROM user WHERE branch_id = '" . $connectionProvider->Quote($branch_id) . "'";
        $deleteUser = $connectionProvider->RealQuery($sql);
        if (!$deleteUser) {
            throw new \Exception("Failed to delete users for branch");
        }
        $sql = "DELETE FROM company_branch WHERE id='" . $connectionProvider->Quote($branch_id) . "'";
        $deleteBranch = $connectionProvider->RealQuery($sql);

        if (!$deleteBranch) {
            throw new \Exception("Failed to add new branch");
        }
    }
}