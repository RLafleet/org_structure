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
    public static function InsertBranch(string $city, int $workersCount, string $address): void
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
    public static function DeleteBranch(int $branch_id): void
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

    /**
     * @param int $id
     * @param string $city
     * @param int $workersCount
     * @param string $address
     * @return void
     * @throws \Exception
     */
    public static function UpdateBranch(int $id, string $city, int $workersCount, string $address): void
    {
        //todo конкантенацию на интерполяцию
        $connectionProvider = new ConnectionProvider();
        $sql = "UPDATE company_branch SET 
                workers_count = '" . $connectionProvider->Quote($workersCount) . "',
                city = '" . $connectionProvider->Quote($city) . "',
                address = '" . $connectionProvider->Quote($address) . "'
                WHERE id = '" . $connectionProvider->Quote($id) . "'";
        $result = $connectionProvider->RealQuery($sql);

        if (!$result) {
            throw new \Exception("Failed to add new branch");
        }
    }

    /**
     * @return array
     */
    public static function ListBranches(): array
    {
        $connectionProvider = new ConnectionProvider();
        $sql = "SELECT * FROM company_branch";
        return $connectionProvider->Fetch($sql);
    }

    //todo бросать исключение если нет результата
    /**
     * @param int $id
     * @return array
     */
    public static function GetBranch(int $id): array
    {
        $connectionProvider = new ConnectionProvider();
        $sql = "SELECT * FROM company_branch WHERE id = '" . $connectionProvider->Quote($id) . "' ";
        return $connectionProvider->Fetch($sql);
    }
}