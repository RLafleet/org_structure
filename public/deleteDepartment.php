<?php
declare(strict_types=1);
require_once __DIR__ . '/vendor/autoload.php';

use App\DbTable\DepartmentTable;

try {
    $department_id = intval($_POST['department_id'] ?? "");
    error_log((string)$department_id);
    DepartmentTable::deleteDepartment($department_id);
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}

//header("Location: /branchDepartment.php?id=" . $_POST['department_id']);
    header("Location: /branchDepartment.php?id=1");
