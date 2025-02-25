<?php
declare(strict_types=1);
require_once __DIR__ . '/vendor/autoload.php';

use App\Connection\ConnectionProvider;
use App\DbTable\{TeamTable, DepartmentTeamTable};

$department_id = intval($_POST['department_id'] ?? 0);
$team_name = trim($_POST['team_name'] ?? "");

if ($department_id <= 0 || empty($team_name)) {
    die("Invalid input data");
}

try {
    TeamTable::insertTeam($team_name);
    $new_team_id = ConnectionProvider::getConnection()->insert_id;

    DepartmentTeamTable::addTeamToDepartment($department_id, $new_team_id);

    header("Location: departmentTeam.php?id=" . $department_id);
    exit;
} catch (\Exception $e) {
    die("Error: " . $e->getMessage());
}