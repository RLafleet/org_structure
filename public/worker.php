<?php
declare(strict_types=1);
require_once __DIR__ . '/vendor/autoload.php';

use App\DbTable\WorkerTable;
use App\Loader\TwigLoader;
use App\Util\PostParameterHandler;

$twig = TwigLoader::LoadTwigStable();

$TEMPLATE_NAME = "/worker.html.twig";
$ERROR_TEMPLATE = "/error.html.twig";

$worker_id = $_GET['id'] ?? '';
$branchId = $_GET['branch_id'] ?? '';
$rows = WorkerTable::findWorker($worker_id);

$params = ['name', 'lastName', 'middleName', 'email', 'sex', 'birthDate', 'hiringDate', 'position', 'comment', 'phoneNumber'];
$postParams = [];
foreach ($params as $param) {
    $postParams[$param] = PostParameterHandler::GetParameter($param);
}

$IsElemsArrayEmpty = in_array('', $postParams, true);
if (!$IsElemsArrayEmpty) {
    try
    {
        WorkerTable::updateWorker((int)$worker_id, (int)$branchId, ...array_values($postParams));
    } catch (\Exception $e) {
        error_log($e->getMessage());
    }
}

try {
    echo $twig->render($TEMPLATE_NAME,
        [
            'row' => $rows[0],
            'branch_id' => $branchId,
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