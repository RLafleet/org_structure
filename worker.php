<?php
declare(strict_types=1);
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$TEMPLATE_NAME = "/public/worker.html.twig";

$loader = new FilesystemLoader(__DIR__);
$twig = new Environment($loader);

echo $twig->render($TEMPLATE_NAME);