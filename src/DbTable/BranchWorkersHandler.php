<?php
namespace App\DbTable;
require_once __DIR__ . '/../../public/vendor/autoload.php';

use App\Connection\ConnectionProvider;

class BranchWorkersHandler
{
    /**
     * @param int $branch_id
     * @return array
     */
    public static function getBranchWorkers(int $branch_id): array
    {
        $connectionProvider = new ConnectionProvider();

        $sql = "
            SELECT 
                u.id, u.first_name, u.last_name, er.role_name
            FROM 
                user u
            JOIN 
                company_branch cb ON u.team_id = cb.id
            LEFT JOIN 
                employee_role er ON u.id = er.employee_id
            WHERE 
                cb.id = " . $connectionProvider->Quote($branch_id) . "
        ";

        return $connectionProvider->Fetch($sql);
    }
}
