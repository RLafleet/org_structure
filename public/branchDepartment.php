<?php
declare(strict_types=1);
require_once __DIR__ . '/vendor/autoload.php';

use App\DbTable\{DepartmentTable, BranchTable};
use App\Loader\TwigLoader;

$twig = TwigLoader::LoadTwigStable();

$TEMPLATE_NAME = "/twig/branch.html.twig";
$ERROR_TEMPLATE = "/twig/error.html.twig";

$branchId = intval($_GET['id'] ?? "");
if ($branchId <= 0) {
    die("Invalid branch ID");
}

$branchInfo = BranchTable::findBranch($branchId);
if (!$branchInfo) {
    die("Branch not found");
}

$departments = DepartmentTable::listDepartments($branchId);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_department'])) {
    $departmentName = trim($_POST['department_name'] ?? "");

    if (!empty($departmentName)) {
        try {
            DepartmentTable::insertDepartment($branchId, $departmentName);
            header("Location: branchDepartment.php?id=" . $branchId);
            exit;
        } catch (\Exception $e) {
            die("Error: " . $e->getMessage());
        }
    }
}

try {
    echo $twig->render($TEMPLATE_NAME, [
        'branch_id' => $branchId,
        'branchInfo' => $branchInfo,
        'departments' => $departments,
    ]);
} catch (\Throwable $e) {
    error_log($e->getMessage());

    echo $twig->render($ERROR_TEMPLATE, [
        'code' => 500,
        'text' => "It's okay, we'll work on fixing these issues rn.",
        'hint' => "Wait a bit"
    ]);
}