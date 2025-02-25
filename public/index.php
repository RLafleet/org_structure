<?php
declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use App\DbTable\BranchTable;
use App\Auth\Auth;
use App\Loader\TwigLoader;

$LOGIN_TEMPLATE = "/twig/login.html.twig";
$REGISTER_TEMPLATE = "/twig/register.html.twig";
$INDEX_TEMPLATE = "/twig/index.html.twig";
$ERROR_TEMPLATE = "/twig/error.html.twig";

ini_set('log_errors', '1');
ini_set('error_log', __DIR__ . '/logs/app.log');

$twig = TwigLoader::LoadTwigStable();

$UNIVERSAL_LOGIN = 'owner';
$UNIVERSAL_PASSWORD = 'password123';

$isAuthenticated = isset($_COOKIE['is_authenticated']) && $_COOKIE['is_authenticated'] === 'true';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset(
        $_POST['register_username'],
        $_POST['register_password'],
        $_POST['confirm_password'],
        $_POST['first_name'],
        $_POST['last_name']
    )) {
        $username = $_POST['register_username'];
        $password = $_POST['register_password'];
        $confirmPassword = $_POST['confirm_password'];
        $firstName = $_POST['first_name'];
        $lastName = $_POST['last_name'];

        if ($password !== $confirmPassword) {
            echo $twig->render($REGISTER_TEMPLATE, ['error' => 'Passwords do not match.']);
            exit;
        }

        try {
            Auth::register(
                $firstName,
                $lastName,
                $username,
                $password
            );
            setcookie('is_authenticated', 'true', time() + 3600, '/');
            header('Location: /index.php');
            exit;
        } catch (Exception $e) {
            echo $twig->render($REGISTER_TEMPLATE, ['error' => $e->getMessage()]);
            exit;
        }
    }
}

if (!$isAuthenticated) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['username'], $_POST['password'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];

            try {
                if ($username === $UNIVERSAL_LOGIN && $password === $UNIVERSAL_PASSWORD) {
                    setcookie('is_authenticated', 'true', time() + 3600, '/');
                    header('Location: /index.php');
                    exit;
                }

                if (Auth::login($username, $password)) {
                    setcookie('is_authenticated', 'true', time() + 3600, '/');
                    header('Location: /index.php');
                    exit;
                }
            } catch (Exception $e) {
                echo $twig->render($LOGIN_TEMPLATE, ['error' => $e->getMessage()]);
                exit;
            }
        }

        if (isset(
            $_POST['register_username'],
            $_POST['register_password'],
            $_POST['confirm_password'],
            $_POST['first_name'],
            $_POST['last_name']
        )) {
            $username = $_POST['register_username'];
            $password = $_POST['register_password'];
            $confirmPassword = $_POST['confirm_password'];
            $firstName = $_POST['first_name'];
            $lastName = $_POST['last_name'];

            if ($password !== $confirmPassword) {
                echo $twig->render($REGISTER_TEMPLATE, ['error' => 'Passwords do not match.']);
                exit;
            }

            try {
                Auth::register(
                    $firstName,
                    $lastName,
                    $username,
                    $password
                );
                setcookie('is_authenticated', 'true', time() + 3600, '/');
                header('Location: /index.php');
                exit;
            } catch (Exception $e) {
                echo $twig->render($REGISTER_TEMPLATE, ['error' => $e->getMessage()]);
                exit;
            }
        }
    }

    if ($_GET['action'] ?? '' === 'register') {
        echo $twig->render($REGISTER_TEMPLATE);
        exit;
    }

    echo $twig->render($LOGIN_TEMPLATE);
    exit;
}

$current_user_role = $_COOKIE['user_role'] ?? 0;

if ($current_user_role < 3) {
    echo $twig->render($ERROR_TEMPLATE, [
        'code' => 403,
        'text' => "Access Denied",
        'hint' => "You do not have permission to access this page."
    ]);
    exit;
}

try {
    $city = $_POST['city'] ?? "";
    $address = $_POST['address'] ?? "";
    $branch_description = $_POST['branch_description'] ?? "";

    if (!empty($city) && !empty($address)) {
        BranchTable::insertBranch($city, $address, $branch_description);
    }

    $rows = BranchTable::listBranches();

    echo $twig->render($INDEX_TEMPLATE, ['rows' => $rows]);
} catch (\Throwable $e) {
    error_log($e->getMessage());

    echo $twig->render($ERROR_TEMPLATE, [
        'code' => 500,
        'text' => "It's okay, we'll work on fixing these issues rn.",
        'hint' => "Wait a bit"
    ]);
}
