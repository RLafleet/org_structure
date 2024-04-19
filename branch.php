<?php
declare(strict_types=1);
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/dbTable/BranchWorkersRequestTable.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/dbTable/WorkerInsertTable.class.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$TEMPLATE_NAME = "/public/branch.html.twig";


$branchId = $_GET['id'] ?? '';
$rows = BranchWorkersRequestTable::GetInfoAboutBranchesWorkers($branchId);
$loader = new FilesystemLoader(__DIR__);
$twig = new Environment($loader);

$name = $_GET['name'] ?? "";
$lastName = $_GET['lastName'] ?? "";
$middleName = $_GET['middleName'] ?? "";
$position = $_GET['position'] ?? "";
if(!empty($name) && !empty($lastName) && !empty($middleName) && !empty($position)) {
    $result = WorkerInsertTable::WorkerDataInsert($branchId, $name, $lastName, $middleName, $position);
    $str = "Location: /branch.php?id=" . $branchId;
    header($str);
}

echo $twig->render($TEMPLATE_NAME,
    ['rows' => $rows]
);