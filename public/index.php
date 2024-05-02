<?php
declare(strict_types=1);
//DIR
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/classes/dbTable/OrgStructureRequestTable.class.php';
require_once __DIR__ . '/classes/dbTable/BranchInsertTable.class.php';
require_once __DIR__ . '/classes/loader/TwigLoader.class.php';

use classes\dbTable\BranchInsertTable;
use classes\dbTable\OrgStructureRequestTable;
use classes\loader\TwigLoader;

$TEMPLATE_NAME = "/index.html.twig";

$twig = TwigLoader::LoadTwigStable();

$rows = OrgStructureRequestTable::GetInfoAboutOrgBranches();

$city = $_POST['city'] ?? "";
$workersCount = $_POST['workersCount'] ?? "";
$address = $_POST['address'] ?? "";

try
{
    if(!empty($city) && !empty($workersCount) && !empty($address)) {
        $result = BranchInsertTable::BranchDataInsert($city, (int)$workersCount, $address);
    }
} catch (\Exception $e)
{
    echo "Error: " . $e->getMessage();
}

echo $twig->render($TEMPLATE_NAME,
    ['rows' => $rows]
);
?>
