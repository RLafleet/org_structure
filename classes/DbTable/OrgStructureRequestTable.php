<?php
namespace App\DbTable;
require_once __DIR__ . '/../../public/vendor/autoload.php';

use App\Util\DbQueryUtil;

class OrgStructureRequestTable
{
    /**
     * @return array
     */
    public static function GetInfoAboutOrgBranches(): array
    {
        $sql = "SELECT * FROM company_branch";

        return DbQueryUtil::Fetch($sql);
    }
}