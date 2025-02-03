<?php
declare(strict_types=1);
require_once __DIR__ . '/vendor/autoload.php';

use App\DbTable\BranchTable;

try {
    $branch_id = intval($_POST['branch_id'] ?? "");
    error_log((string)$branch_id);
    BranchTable::deleteBranch($branch_id);
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}

header("Location: /index.php");
exit;