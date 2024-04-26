<?php
declare(strict_types=1);
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/classes/dbTable/WorkerRequestTable.class.php';

use classes\dbTable\WorkerRequestTable;
use classes\dbTable\WorkerUpdate;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$TEMPLATE_NAME = "/worker.html.twig";

$worker_id = $_GET['id'] ?? '';
$branchId = $_GET['branch_id'] ?? '';
$rows = WorkerRequestTable::GetInfoAboutWorker($worker_id);

$name = $_POST['name'] ?? "";
$lastName = $_POST['lastName'] ?? "";
$middleName = $_POST['middleName'] ?? "";
$email = $_POST['email'] ?? "";
$sex = $_POST['sex'] ?? "";
$birth_date = $_POST['birthDate'] ?? "";
$hiring_date = $_POST['hiringDate'] ?? "";
$position = $_POST['position'] ?? "";
$comment = $_POST['comment'] ?? "";
$phoneNumber = $_POST['phoneNumber'] ?? "";

$loader = new FilesystemLoader(__DIR__);
$twig = new Environment($loader);

if( !empty($name) &&
    !empty($lastName) &&
    !empty($middleName) &&
    !empty($position) &&
    !empty($sex) &&
    !empty($email) &&
    !empty($birth_date) &&
    !empty($hiring_date) &&
    !empty($comment) &&
    !empty($phoneNumber))
{
    print_r("dsa");
    $result = WorkerUpdate::WorkerUpdateInfo(
        $worker_id,
        $branchId,
        $name,
        $lastName,
        $middleName,
        $position,
        $sex,
        $email,
        $birth_date,
        $hiring_date,
        $comment,
        $phoneNumber
    );
}

echo $twig->render($TEMPLATE_NAME,
    [
        'row' => $rows[0],
        'branch_id' => $branchId,
    ]
);