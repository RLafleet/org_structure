<?php
declare(strict_types=1);
require_once __DIR__ . '/vendor/autoload.php';

use App\DbTable\WorkerRequestTable;
use App\DbTable\WorkerUpdate;
use App\Loader\TwigLoader;
use App\Util\PostParameterHandler;

$twig = TwigLoader::LoadTwigStable();

$TEMPLATE_NAME = "/worker.html.twig";

$worker_id = $_GET['id'] ?? '';
$branchId = $_GET['branch_id'] ?? '';
$rows = WorkerRequestTable::GetInfoAboutWorker($worker_id);

$params = ['name', 'lastName', 'middleName', 'email', 'sex', 'birthDate', 'hiringDate', 'position', 'comment', 'phoneNumber'];
$postParams = [];
foreach ($params as $param) {
    $postParams[$param] = PostParameterHandler::GetParameter($param);
}

$IsElemsArrayEmpty = in_array('', $postParams, true);
if (!$IsElemsArrayEmpty) {
    try
    {
        WorkerUpdate::WorkerUpdateInfo((int)$worker_id, (int)$branchId, ...array_values($postParams));
    } catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
    }
}

try {
    echo $twig->render($TEMPLATE_NAME,
        [
            'row' => $rows[0],
            'branch_id' => $branchId,
        ]
    );
} catch (\Twig\Error\LoaderError|\Twig\Error\RuntimeError|\Twig\Error\SyntaxError $e) {
    echo "Error: " . $e->getMessage();
}