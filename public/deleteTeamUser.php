<?php
declare(strict_types=1);
require_once __DIR__ . '/vendor/autoload.php';

use App\DbTable\TeamUserTable;

$team_id = intval($_POST['team_id'] ?? 0);
$user_id = intval($_POST['user_id'] ?? 0);

if ($team_id <= 0 || $user_id <= 0) {
    die("Invalid input data");
}

try {
    TeamUserTable::removeUserFromTeam($team_id, $user_id);
    header("Location: teamUser.php?id=" . $team_id);
    exit;
} catch (\Exception $e) {
    die("Error: " . $e->getMessage());
}