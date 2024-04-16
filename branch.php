<?php
declare(strict_types=1);
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/dbTable/BranchWorkersRequestTable.class.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$TEMPLATE_NAME = "/public/branch.html.twig";


$id = $_GET['id'] || '';

$rows = BranchWorkersRequestTable::GetInfoAboutBranchesWorkers();

$loader = new FilesystemLoader(__DIR__);
$twig = new Environment($loader);

echo $twig->render($TEMPLATE_NAME);