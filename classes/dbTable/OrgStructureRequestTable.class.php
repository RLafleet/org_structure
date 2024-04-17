<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/util/dbQueryUtil.class.php';

class OrgStructureRequestTable
{
    /**
     * @return array
     */
    public static function GetInfoAboutOrgBranches(): array
    {
        $sql = "SELECT * FROM company_branch";

        return DbQueryUtils::Fetch($sql);
    }
}