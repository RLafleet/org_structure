<?php
declare(strict_types=1);
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/classes/dbTable/WorkerTable.class.php';

use classes\dbTable\WorkerTable;
$branch_id = intval($_GET['branch_id'] ?? "");

try {
    $worker_id = intval($_POST['worker_id'] ?? "");
    WorkerTable::WorkerDataDelete($worker_id);
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}

header("Location: /branch.php?id=" . $branch_id);
exit;