<?php
declare(strict_types=1);
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/classes/dbTable/WorkerRequestTable.class.php';
require_once __DIR__ . '/classes/dbTable/WorkerUpdate.class.php';
require_once __DIR__ . '/classes/loader/TwigLoader.class.php';
require_once __DIR__ . '/classes/util/PostParameterHandler.class.php';

use classes\dbTable\WorkerRequestTable;
use classes\dbTable\WorkerUpdate;
use classes\loader\TwigLoader;
use classes\util\PostParameterHandler;

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

echo $twig->render($TEMPLATE_NAME,
    [
        'row' => $rows[0],
        'branch_id' => $branchId,
    ]
);