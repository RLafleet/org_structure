<?php
declare(strict_types=1);
require_once __DIR__ . '/vendor/autoload.php';

$city = $_POST['city'] ?? "";
$address = $_POST['address'] ?? "";
$workers_count = $_POST['workers_count'] ?? "";

try {
    $branch_id = intval($_GET['branch_id'] ?? "");
    //BranchTable::BranchDataUpdate($branch_id, $city, $address, $workers_count;
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}

header("Location: /index.php");
exit;