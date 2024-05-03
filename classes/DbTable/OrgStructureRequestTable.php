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
        $sql = "SELECT * FROM company_branch";
        $connectionProvider = new ConnectionProvider();
        return $connectionProvider->Fetch($sql);
    }
}