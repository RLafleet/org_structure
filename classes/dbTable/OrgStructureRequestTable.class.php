<?php
use classes\util\dbQueryUtil;
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/util/dbQueryUtil.class.php';

class OrgStructureRequestTable
{
    /**
     * @return array
     */
    public static function GetInfoAboutOrgBranches(): array
    {
        $config = include $_SERVER['DOCUMENT_ROOT'] . '/classes/config/DbConfig.class.php';

        $sql = "SELECT * FROM company_branch";

        return DbQueryUtils::Fetch($sql);
    }
}