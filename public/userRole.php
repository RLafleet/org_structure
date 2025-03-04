<?php
declare(strict_types=1);
require_once __DIR__ . '/vendor/autoload.php';

use App\Util\Breadcrumbs;
use App\DbTable\{RoleRequestTable, UserTable, EmployeeRoleTable};
use App\Loader\TwigLoader;

$twig = TwigLoader::LoadTwigStable();

$TEMPLATE_NAME = "/twig/userRole.html.twig";
$ERROR_TEMPLATE = "/twig/error.html.twig";

session_start();
$current_team = (int)$_GET['id'] ?? 0;

$current_user_role = $_COOKIE['user_role'] ?? 0;

if ($current_user_role < 3) {
    echo $twig->render($ERROR_TEMPLATE, [
        'code' => 403,
        'text' => "Access Denied",
        'hint' => "You do not have permission to access this page."
    ]);
    exit;
}

$breadcrumbs = new Breadcrumbs();
$breadcrumbs->add('Home', '/index.php');
$breadcrumbs->add('Team Users','/teamUser.php?id' . $current_team);
$breadcrumbs->add('User Roles');

if ($current_user_role < 3) {
    echo $twig->render($ERROR_TEMPLATE, [
        'code' => 403,
        'text' => "Access Denied",
        'hint' => "You do not have permission to access this page."
    ]);
    exit;
}

$user_id = intval($_GET['id'] ?? "");
if ($user_id <= 0) {
    die("Invalid user ID");
}

$userInfo = UserTable::getUserDetails($user_id);
if (!$userInfo) {
    error_log('213');
    die("User not found");
}

$userRoles = EmployeeRoleTable::getRolesByUser($user_id);

$roleRequests = [];
if ($current_user_role > 3) {
    $roleRequests = RoleRequestTable::getAllRequests();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_role'])) {
    $role_name = trim($_POST['role_name'] ?? "");
    $accessibility = intval($_POST['accessibility'] ?? 0);

    if (!empty($role_name)) {
        try {
            EmployeeRoleTable::addRoleToUser($user_id, $role_name, $accessibility);
            header("Location: userRole.php?id=" . $user_id);
            exit;
        } catch (\Exception $e) {
            die("Error: " . $e->getMessage());
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_user'])) {
    $firstName = trim($_POST['first_name'] ?? "");
    $lastName = trim($_POST['last_name'] ?? "");
    $email = trim($_POST['email'] ?? "");
    $password = trim($_POST['password'] ?? "");

    if (!empty($firstName) && !empty($lastName) && !empty($email) && !empty($password)) {
        try {
            UserTable::registerUser($firstName, $lastName, $email, $password);
            header("Location: userRole.php?id=" . $user_id);
            exit;
        } catch (\Exception $e) {
            die("Error: " . $e->getMessage());
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['approve_request'])) {
    $request_id = intval($_POST['request_id'] ?? 0);

    if ($request_id > 0) {
        try {
            RoleRequestTable::approveRequest($request_id);
            header("Location: userRole.php?id=" . $user_id);
            exit;
        } catch (\Exception $e) {
            die("Error: " . $e->getMessage());
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reject_request'])) {
    $request_id = intval($_POST['request_id'] ?? 0);

    if ($request_id > 0) {
        try {
            RoleRequestTable::rejectRequest($request_id);
            header("Location: userRole.php?id=" . $user_id);
            exit;
        } catch (\Exception $e) {
            die("Error: " . $e->getMessage());
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_user'])) {
    $data = [];

    if (!empty($_POST['first_name'])) {
        $data['first_name'] = trim($_POST['first_name']);
    }
    if (!empty($_POST['last_name'])) {
        $data['last_name'] = trim($_POST['last_name']);
    }
    if (!empty($_POST['middle_name'])) {
        $data['middle_name'] = trim($_POST['middle_name']);
    }
    if (!empty($_POST['phone_number'])) {
        $data['phone_number'] = trim($_POST['phone_number']);
    }
    if (!empty($_POST['email'])) {
        $data['email'] = trim($_POST['email']);
    }
    if (!empty($_POST['sex'])) {
        $data['sex'] = trim($_POST['sex']);
    }
    if (!empty($_POST['birth_date'])) {
        $data['birth_date'] = trim($_POST['birth_date']);
    }
    if (!empty($_POST['hiring_date'])) {
        $data['hiring_date'] = trim($_POST['hiring_date']);
    }
    if (!empty($_POST['comment'])) {
        $data['comment'] = trim($_POST['comment']);
    }

    try {
        UserTable::updateUser($user_id, $data);
        header("Location: userRole.php?id=" . $user_id);
        exit;
    } catch (\Exception $e) {
        die("Error: " . $e->getMessage());
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user'])) {
    $delete_user_id = intval($_POST['delete_user_id'] ?? 0);

    if ($delete_user_id > 0) {
        try {
            $userRole = EmployeeRoleTable::getUserRole($delete_user_id);
            if ($userRole == 4) {
                throw new \Exception("Cannot delete the main admin.");
            }

            UserTable::deleteUser($delete_user_id);
            header("Location: userRole.php?id=" . $user_id);
            exit;
        } catch (\Exception $e) {
            die("Error: " . $e->getMessage());
        }
    }
}

try {
    echo $twig->render($TEMPLATE_NAME, [
        'user_id' => $user_id,
        'userInfo' => $userInfo,
        'userRoles' => $userRoles,
        'current_user_role' => $current_user_role,
        'breadcrumbs' => $breadcrumbs->getCrumbs(),
        'roleRequests' => $roleRequests,
    ]);
} catch (\Throwable $e) {
    error_log($e->getMessage());

    echo $twig->render($ERROR_TEMPLATE, [
        'code' => 500,
        'text' => "It's okay, we'll work on fixing these issues rn.",
        'hint' => "Wait a bit"
    ]);
}