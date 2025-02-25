<?php
declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use App\DbTable\RoleRequestTable;
use App\Auth;

session_start();

$current_user_id = $_COOKIE['user_id'] ?? 0;

if ($current_user_id <= 0) {
    header("Location: /index.php");
    exit;
}

try {
    RoleRequestTable::createRequest((int)$current_user_id, 3);

    header("Location: /index.php");
    exit;
} catch (\Exception $e) {
    die("Error: " . $e->getMessage());
}