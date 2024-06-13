<?php
declare(strict_types=1);
require_once __DIR__ . '/vendor/autoload.php';

use App\DbTable\BranchTable;

$city = $_POST['city'] ?? "";
$address = $_POST['address'] ?? "";

try {
    $branch_id = intval($_GET['id'] ?? "");
    BranchTable::updateBranch($branch_id, $city, $address);
} catch (\Exception $e) {
    error_log($e->getMessage());
}

exit;