<?php
declare(strict_types=1);
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

$TEMPLATE_NAME = "/public/index.html.twig";
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$servername = "localhost";
$username = "root";
$password = "";

$conn = new mysqli($servername, $username, $password, "org_structure");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$loader = new FilesystemLoader(__DIR__);
$twig = new Environment($loader);

echo $twig->render($TEMPLATE_NAME);
?>