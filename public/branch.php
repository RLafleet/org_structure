<?php
declare(strict_types=1);
require_once __DIR__ . '/vendor/autoload.php';

use App\DbTable\BranchWorkersHandler;
use App\DbTable\WorkerTable;
use App\Loader\TwigLoader;
use App\DbTable\BranchTable;


$twig = TwigLoader::LoadTwigStable();

$TEMPLATE_NAME = "/twig/branch.html.twig";
$ERROR_TEMPLATE = "/twig/error.html.twig";

$current_user_role = $_COOKIE['user_role'] ?? 0;

if ($current_user_role < 3) {
    echo $twig->render($ERROR_TEMPLATE, [
        'code' => 403,
        'text' => "Access Denied",
        'hint' => "You do not have permission to access this page."
    ]);
    exit;
}

$branchId = intval($_GET['id'] ?? "");
$rows = BranchWorkersHandler::getBranchWorkers($branchId);
$branchInfo = BranchTable::findBranch($branchId);

$name = $_POST['name'] ?? "";
$lastName = $_POST['lastName'] ?? "";
$middleName = $_POST['middleName'] ?? "";
$position = $_POST['position'] ?? "";

if (!empty($name) && !empty($lastName) && !empty($middleName) && !empty($position)) {
    try {
        WorkerTable::insertWorker($branchId, $name, $lastName, $middleName, $position);
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
} catch (\Throwable $e) {
    error_log($e->getMessage());

    echo $twig->render($ERROR_TEMPLATE, [
        'code' => 500,
        'text' => "It's okay, we'll work on fixing these issues rn.",
        'hint' => "Wait a bit"
    ]);
}