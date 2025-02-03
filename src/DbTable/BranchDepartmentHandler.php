<?php
namespace App\DbTable;
require_once __DIR__ . '/../../public/vendor/autoload.php';

use App\Connection\ConnectionProvider;

class BranchDepartmentHandler
{
    /**
     * @param int $branch_id
     * @return array
     */
    public static function getBranchDepartments(int $branch_id): array
    {
        $connectionProvider = new ConnectionProvider();

        $sql = "
            SELECT 
                d.department_id, d.department_name
            FROM 
                department d
            WHERE 
                d.branch_id = " . $connectionProvider->Quote($branch_id) . "
        ";

        return $connectionProvider->Fetch($sql);
    }
}