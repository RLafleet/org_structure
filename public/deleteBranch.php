<?php
declare(strict_types=1);
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/classes/dbTable/OrgStructureRequestTable.class.php';
require_once __DIR__ . '/classes/dbTable/BranchTable.class.php';
require_once __DIR__ . '/classes/loader/TwigLoader.class.php';

use classes\dbTable\BranchTable;

try {
    $branch_id = intval($_POST['branch_id'] ?? "");
    BranchTable::BranchDataDelete($branch_id);
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}

header("Location: /index.php");
exit;