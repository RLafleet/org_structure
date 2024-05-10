<?php
declare(strict_types=1);
require_once __DIR__ . '/vendor/autoload.php';

use App\DbTable\BranchWorkersRequestTable;
use App\DbTable\WorkerTable;
use App\Loader\TwigLoader;
use App\DbTable\OrgStructureRequestTable;


$twig = TwigLoader::LoadTwigStable();

$TEMPLATE_NAME = "/branch.html.twig";

$branchId = intval($_GET['id'] ?? "");
$rows = BranchWorkersRequestTable::GetInfoAboutBranchesWorkers($branchId);
$branchInfo = OrgStructureRequestTable::GetInfoAboutOrgBranch($branchId);

$name = $_POST['name'] ?? "";
$lastName = $_POST['lastName'] ?? "";
$middleName = $_POST['middleName'] ?? "";
$position = $_POST['position'] ?? "";

if (!empty($name) && !empty($lastName) && !empty($middleName) && !empty($position)) {
    try {
        WorkerTable::WorkerDataInsert($branchId, $name, $lastName, $middleName, $position);
    } catch (\Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}

try {
    echo $twig->render($TEMPLATE_NAME,
        [
            'branch_id' => $branchId,
            'rows' => $rows,
            'branchInfo' => $branchInfo[0]
        ]
    );
} catch (\Twig\Error\LoaderError|\Twig\Error\RuntimeError|\Twig\Error\SyntaxError $e) {
}