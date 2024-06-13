<?php
declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use App\DbTable\BranchTable;
use App\Loader\TwigLoader;

$TEMPLATE_NAME = "/index.html.twig";
$ERROR_TEMPLATE = "/error.html.twig";

ini_set('log_errors', '1');
ini_set('error_log', __DIR__ . '/logs/app.log');

$twig = TwigLoader::LoadTwigStable();

$city = $_POST['city'] ?? "";
$address = $_POST['address'] ?? "";

try {
    if (!empty($city) && !empty($address)) {
        BranchTable::insertBranch($city, $address);
    }

    $rows = BranchTable::listBranches();

    echo $twig->render($TEMPLATE_NAME, ['rows' => $rows]);

} catch (\Throwable $e) {
    error_log($e->getMessage());

    echo $twig->render($ERROR_TEMPLATE, [
        'code' => 500,
        'text' => "It's okay, we'll work on fixing these issues rn.",
        'hint' => "Wait a bit"
    ]);
}
