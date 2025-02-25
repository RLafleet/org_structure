<?php
declare(strict_types=1);
require_once __DIR__ . '/vendor/autoload.php';

use App\Connection\ConnectionProvider;
use App\DbTable\TeamTable;
use App\DbTable\DepartmentTeamTable;

$department_id = intval($_GET['id'] ?? 0);

if ($department_id <= 0) {
    die("Invalid department ID");
}

// Получаем список команд для отдела
$teams = TeamTable::listTeams($department_id);

// Обработка добавления команды
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_team'])) {
    $team_name = trim($_POST['team_name'] ?? "");

    if (!empty($team_name)) {
        try {
            TeamTable::insertTeam($team_name);
            $new_team_id = ConnectionProvider::getConnection()->insert_id;
            DepartmentTeamTable::addTeamToDepartment($department_id, $new_team_id);
            header("Location: departmentTeam.php?id=" . $department_id);
            exit;
        } catch (\Exception $e) {
            die("Error: " . $e->getMessage());
        }
    }
}

// Обработка удаления команды
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_team'])) {
    $team_id = intval($_POST['team_id'] ?? 0);

    if ($team_id > 0) {
        try {
            DepartmentTeamTable::removeTeamFromDepartment($department_id, $team_id);
            TeamTable::deleteTeam($team_id);
            header("Location: departmentTeam.php?id=" . $department_id);
            exit;
        } catch (\Exception $e) {
            die("Error: " . $e->getMessage());
        }
    }
}