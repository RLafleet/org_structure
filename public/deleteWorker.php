<?php
declare(strict_types=1);
require_once __DIR__ . '/vendor/autoload.php';

use App\DbTable\WorkerTable;

try {
    $worker_id = intval($_POST['worker_id'] ?? "");
    $branch_id = intval($_GET['branch_id'] ?? "");
    WorkerTable::WorkerDataDelete($worker_id);
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}

header("Location: /branch.php?id=" . $branch_id);
exit;