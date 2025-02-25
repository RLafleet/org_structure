<?php
declare(strict_types=1);
require_once __DIR__ . '/vendor/autoload.php';

use App\DbTable\DepartmentTable;

try {
    $branch_id = intval($_POST['branch_id'] ?? "");
    $department_name = trim($_POST['department_name'] ?? "");

    if (empty($branch_id) || empty($department_name)) {
        throw new \InvalidArgumentException("Invalid input data");
    }

    DepartmentTable::insertDepartment($branch_id, $department_name);
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}

header("Location: /branchDepartment.php?id=" . $branch_id);