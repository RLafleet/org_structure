<?php
declare(strict_types=1);
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/dbTable/WorkerRequestTable.class.php';

use classes\dbTable\WorkerRequestTable;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$TEMPLATE_NAME = "/worker.html.twig";

$worker_id = $_GET['id'] ?? '';
$rows = WorkerRequestTable::GetInfoAboutWorker($worker_id);
$loader = new FilesystemLoader(__DIR__);
$twig = new Environment($loader);

echo $twig->render($TEMPLATE_NAME,
    ['row' => $rows[0]]
);