<?php
declare(strict_types=1);
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/dbTable/OrgStructureRequestTable.class.php';
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$TEMPLATE_NAME = "/public/index.html.twig";

$loader = new FilesystemLoader($_SERVER['DOCUMENT_ROOT']);
$twig = new Environment($loader);

$rows = OrgStructureRequestTable::GetInfoAboutOrgBranches();

echo $twig->render($TEMPLATE_NAME,
    ['rows' => $rows]
);
