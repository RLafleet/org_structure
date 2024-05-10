<?php
declare(strict_types=1);
require_once __DIR__ . '/vendor/autoload.php';

use App\DbTable\BranchTable;


$city = $_POST['city'] ?? "";
$address = $_POST['address'] ?? "";

try {
    $branch_id = intval($_GET['id'] ?? "");
    $workers_count = intval($_POST['workers_count'] ?? "");
    BranchTable::BranchDataUpdate($branch_id, $city, $workers_count, $address);
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}

exit;