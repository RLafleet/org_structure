<?php
declare(strict_types=1);
require_once __DIR__ . '/vendor/autoload.php';

use App\DbTable\{BranchDepartment, BranchDepartmentHandler};
use App\Loader\TwigLoader;


$twig = TwigLoader::LoadTwigStable();

$TEMPLATE_NAME = "/twig/branch.html.twig";
$ERROR_TEMPLATE = "/twig/error.html.twig";

$branchId = intval($_GET['id'] ?? "");
$rows = BranchDepartmentHandler::getBranchDepartments($branchId);
$departmentsInfo = BranchDepartment::findDepartment($branchId);

$departmentName = $_POST['department_name'] ?? "";
error_log("__---------__", $departmentName);

if (!empty($departmentName)) {
    error_log("__---------__", $departmentName);
    try {
        BranchDepartment::insertDepartment($branchId, $departmentName);
    } catch (\Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}

try {
    echo $twig->render($TEMPLATE_NAME,
        [
            'branch_id' => $branchId,
            'rows' => $rows,
            '$departmentsInfo' => $departmentsInfo[0],
        ]
    );
} catch (\Throwable $e) {
    error_log($e->getMessage());

    echo $twig->render($ERROR_TEMPLATE, [
        'code' => 500,
        'text' => "It's okay, we'll work on fixing these issues rn.",
        'hint' => "Wait a bit"
    ]);
}