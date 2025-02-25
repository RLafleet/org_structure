<?php
declare(strict_types=1);
require_once __DIR__ . '/vendor/autoload.php';

use App\DbTable\{TeamTable, UserTable, TeamUserTable};
use App\Loader\TwigLoader;

$twig = TwigLoader::LoadTwigStable();

$TEMPLATE_NAME = "/twig/teamUser.html.twig";
$ERROR_TEMPLATE = "/twig/error.html.twig";

$team_id = intval($_GET['id'] ?? "");
if ($team_id <= 0) {
    die("Invalid team ID");
}

$teamInfo = TeamTable::findTeam($team_id);
if (!$teamInfo) {
    die("Team not found");
}

$teamUsers = TeamUserTable::getUsersByTeam($team_id);

$allUsers = UserTable::listUsers();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_user'])) {
    $user_id = intval($_POST['user_id'] ?? 0);

    if ($user_id > 0) {
        try {
            TeamUserTable::addUserToTeam($team_id, $user_id);
            header("Location: teamUser.php?id=" . $team_id);
            exit;
        } catch (\Exception $e) {
            die("Error: " . $e->getMessage());
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user'])) {
    $user_id = intval($_POST['user_id'] ?? 0);

    if ($user_id > 0) {
        try {
            TeamUserTable::removeUserFromTeam($team_id, $user_id);
            header("Location: teamUser.php?id=" . $team_id);
            exit;
        } catch (\Exception $e) {
            die("Error: " . $e->getMessage());
        }
    }
}

try {
    echo $twig->render($TEMPLATE_NAME, [
        'team_id' => $team_id,
        'teamInfo' => $teamInfo,
        'teamUsers' => $teamUsers,
        'allUsers' => $allUsers,
    ]);
} catch (\Throwable $e) {
    error_log($e->getMessage());

    echo $twig->render($ERROR_TEMPLATE, [
        'code' => 500,
        'text' => "It's okay, we'll work on fixing these issues rn.",
        'hint' => "Wait a bit"
    ]);
}