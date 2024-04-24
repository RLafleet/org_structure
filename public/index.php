<?php
declare(strict_types=1);
//DIR
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/classes/dbTable/OrgStructureRequestTable.class.php';
require_once __DIR__ . '/classes/dbTable/BranchInsertTable.class.php';

use classes\dbTable\BranchInsertTable;
use classes\dbTable\OrgStructureRequestTable;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$TEMPLATE_NAME = "/index.html.twig";

//В отдельный класс
$loader = new FilesystemLoader($_SERVER['DOCUMENT_ROOT']);
$twig = new Environment($loader);

$rows = OrgStructureRequestTable::GetInfoAboutOrgBranches();

$city = $_POST['city'] ?? "";
$workersCount = $_POST['workersCount'] ?? "";
$address = $_POST['address'] ?? "";
if(!empty($city) && !empty($workersCount) && !empty($address)) {
    $result = BranchInsertTable::BranchDataInsert($city, (int)$workersCount, $address);
}

echo $twig->render($TEMPLATE_NAME,
    ['rows' => $rows]
);
?>
