<?php

namespace App\DbTable;
require_once __DIR__ . '/../../public/vendor/autoload.php';

use App\connection\ConnectionProvider;

class BranchTable
{
    /**
     * @param string $city
     * @param string $address
     * @param string $branch_description
     * @return void
     * @throws \Exception
     */
    public static function insertBranch(string $city, string $address, string $branch_description): void
    {
        if (empty($city) || empty($address)) {
            throw new \InvalidArgumentException("Invalid input data");
        }

        $connectionProvider = new ConnectionProvider();
        $defaultWorkersCount = 0;
        $defaultCompanyId = null;
        $defaultDescr = "add new info about that branch";

        $sql = "INSERT INTO company_branch 
        (company_id, workers_count, city, address, branch_description)
        VALUES (
            " . ($defaultCompanyId !== null ? "NULL" : "NULL") . ",
            " . $defaultWorkersCount . ",
            '" . $connectionProvider->Quote($city) . "',
            '" . $connectionProvider->Quote($address) . "',
            '" . (!empty($branch_description) ? $branch_description : $defaultDescr) . "'
        )";

        $result = $connectionProvider->RealQuery($sql);

        if (!$result) {
            throw new \Exception("Failed to add new branch");
        }
    }

    /**
     * Удаляет ветку по её ID.
     *
     * @param int $branch_id ID ветки, которую нужно удалить.
     * @return void
     * @throws \Exception
     */
    public static function deleteBranch(int $branch_id): void
    {
        if ($branch_id <= 0) {
            throw new \InvalidArgumentException("Invalid branch ID");
        }

        $connectionProvider = new ConnectionProvider();
        $sql = "DELETE FROM company_branch WHERE id = " . $connectionProvider->Quote($branch_id);
        $result = $connectionProvider->RealQuery($sql);

        if (!$result) {
            throw new \Exception("Failed to delete branch");
        }
    }

    /**
     * @param int $id
     * @param string $city
     * @param string $address
     * @return void
     * @throws \Exception
     */
    public static function updateBranch(int $id, string $city, string $address): void
    {
        $connectionProvider = new ConnectionProvider();
        $sql = "UPDATE company_branch SET 
                city = '" . $connectionProvider->Quote($city) . "',
                address = '" . $connectionProvider->Quote($address) . "' 
                WHERE id = '" . $connectionProvider->Quote($id) . "'";
        $result = $connectionProvider->RealQuery($sql);

        if (!$result) {
            throw new \Exception("Failed to update branch");
        }
    }

    /**
     * @return array
     */
    public static function listBranches(): array
    {
        $connectionProvider = new ConnectionProvider();
        $sql = "SELECT * FROM company_branch";
        return $connectionProvider->Fetch($sql);
    }

    /**
     * @param int $id
     * @return array|null
     */
    public static function findBranch(int $id): ?array
    {
        $connectionProvider = new ConnectionProvider();
        $sql = "SELECT * FROM company_branch WHERE id = '" . $connectionProvider->Quote($id) . "'";
        $result = $connectionProvider->Fetch($sql);

        if (empty($result)) {
            return null;
        }

        return $result;
    }
}