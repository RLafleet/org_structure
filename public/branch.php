<?php
declare(strict_types=1);
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/classes/dbTable/BranchWorkersRequestTable.class.php';
require_once __DIR__ . '/classes/dbTable/WorkerTable.class.php';
require_once __DIR__ . '/classes/loader/TwigLoader.class.php';

use classes\dbTable\BranchWorkersRequestTable;
use classes\dbTable\WorkerTable;
use classes\loader\TwigLoader;

$twig = TwigLoader::LoadTwigStable();

$TEMPLATE_NAME = "/branch.html.twig";

$branchId = intval($_GET['id'] ?? "");
$rows = BranchWorkersRequestTable::GetInfoAboutBranchesWorkers((int)$branchId);

$name = $_POST['name'] ?? "";
$lastName = $_POST['lastName'] ?? "";
$middleName = $_POST['middleName'] ?? "";
$position = $_POST['position'] ?? "";

try {
    if (!empty($name) && !empty($lastName) && !empty($middleName) && !empty($position)) {
        WorkerTable::WorkerDataInsert($branchId, $name, $lastName, $middleName, $position);
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}

echo $twig->render($TEMPLATE_NAME,
    [
        'branch_id' => $branchId,
        'rows' => $rows
    ]
);