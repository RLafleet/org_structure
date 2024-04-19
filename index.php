<?php
declare(strict_types=1);
//DIR
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/dbTable/OrgStructureRequestTable.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/dbTable/BranchInsertTable.class.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$TEMPLATE_NAME = "/public/index.html.twig";

//В отдельный класс
$loader = new FilesystemLoader($_SERVER['DOCUMENT_ROOT']);
$twig = new Environment($loader);

$rows = OrgStructureRequestTable::GetInfoAboutOrgBranches();

$city = $_GET['city'] ?? "";
$workersCount = $_GET['workersCount'] ?? "";
$address = $_GET['address'] ?? "";
if(!empty($city) && !empty($workersCount) && !empty($address)) {
    $result = BranchInsertTable::BranchDataInsert($city, $workersCount, $address);
    header("Location: /index.php");
}

echo $twig->render($TEMPLATE_NAME,
    ['rows' => $rows]
);
?>
