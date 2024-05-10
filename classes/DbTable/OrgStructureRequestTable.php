<?php
namespace App\DbTable;
require_once __DIR__ . '/../../public/vendor/autoload.php';

use App\Connection\ConnectionProvider;

class OrgStructureRequestTable
{
    /**
     * @return array
     */
    public static function GetInfoAboutOrgBranches(): array
    {
        $connectionProvider = new ConnectionProvider();
        $sql = "SELECT * FROM company_branch";
        return $connectionProvider->Fetch($sql);
    }

    /**
     * @param int $id
     * @return array
     */
    public static function GetInfoAboutOrgBranch(int $id): array
    {
        $connectionProvider = new ConnectionProvider();
        $sql = "SELECT * FROM company_branch WHERE id = '" . $connectionProvider->Quote($id) . "' ";
        return $connectionProvider->Fetch($sql);
    }
}