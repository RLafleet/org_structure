<?php
declare(strict_types=1);
require_once __DIR__ . '/vendor/autoload.php';

use App\DbTable\BranchTable;
use App\DbTable\OrgStructureRequestTable;
use App\Loader\TwigLoader;

$TEMPLATE_NAME = "/index.html.twig";

$twig = TwigLoader::LoadTwigStable();

$rows = OrgStructureRequestTable::GetInfoAboutOrgBranches();

$city = $_POST['city'] ?? "";
$address = $_POST['address'] ?? "";

if (!empty($city) && !empty($address)) {
    try {
        $workersCount = intval($_POST['workersCount'] ?? "");
        BranchTable::BranchDataInsert($city, $workersCount, $address);
    } catch (\Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}


echo $twig->render($TEMPLATE_NAME,
    ['rows' => $rows]
);
