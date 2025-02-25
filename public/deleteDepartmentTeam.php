<?php
declare(strict_types=1);
require_once __DIR__ . '/vendor/autoload.php';

use App\DbTable\{TeamTable, DepartmentTeamTable};

$department_id = intval($_POST['department_id'] ?? 0);
$team_id = intval($_POST['team_id'] ?? 0);

if ($department_id <= 0 || $team_id <= 0) {
    die("Invalid input data");
}

try {
    DepartmentTeamTable::removeTeamFromDepartment($department_id, $team_id);

    TeamTable::deleteTeam($team_id);

    header("Location: departmentTeam.php?id=" . $department_id);
    exit;
} catch (\Exception $e) {
    die("Error: " . $e->getMessage());
}