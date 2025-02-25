<?php
declare(strict_types=1);
require_once __DIR__ . '/vendor/autoload.php';

use App\DbTable\{DepartmentTeamTable, DepartmentTable};
use App\Loader\TwigLoader;

$twig = TwigLoader::LoadTwigStable();

$TEMPLATE_NAME = "/twig/departmentTeam.html.twig";
$ERROR_TEMPLATE = "/twig/error.html.twig";

$department_id = intval($_GET['id'] ?? "");
if ($department_id <= 0) {
    die("Invalid department ID");
}

$departmentInfo = DepartmentTable::findDepartment($department_id);
if (!$departmentInfo) {
    die("Department not found");
}

$teams = DepartmentTeamTable::getTeamsByDepartment($department_id);

try {
    echo $twig->render($TEMPLATE_NAME, [
        'department_id' => $department_id,
        'departmentInfo' => $departmentInfo,
        'teams' => $teams,
    ]);
} catch (\Throwable $e) {
    error_log($e->getMessage());

    echo $twig->render($ERROR_TEMPLATE, [
        'code' => 500,
        'text' => "It's okay, we'll work on fixing these issues rn.",
        'hint' => "Wait a bit"
    ]);
}