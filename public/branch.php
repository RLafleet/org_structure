<?php
declare(strict_types=1);
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/classes/dbTable/BranchWorkersRequestTable.class.php';
require_once __DIR__ . '/classes/dbTable/WorkerInsertTable.class.php';

use classes\dbTable\BranchWorkersRequestTable;
use classes\dbTable\WorkerInsertTable;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$TEMPLATE_NAME = "/branch.html.twig";

$branchId = $_GET['id'] ?? "";
$rows = BranchWorkersRequestTable::GetInfoAboutBranchesWorkers((int)$branchId);
$loader = new FilesystemLoader(__DIR__);
$twig = new Environment($loader);

$name = $_POST['name'] ?? "";
$lastName = $_POST['lastName'] ?? "";
$middleName = $_POST['middleName'] ?? "";
$position = $_POST['position'] ?? "";
if(!empty($name) && !empty($lastName) && !empty($middleName) && !empty($position))
{
    $result = WorkerInsertTable::WorkerDataInsert($branchId, $name, $lastName, $middleName, $position);
}

echo $twig->render($TEMPLATE_NAME,
    [
        'branch_id' => $branchId,
        'rows' => $rows
    ]
);