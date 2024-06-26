<?php
declare(strict_types=1);
require_once __DIR__ . '/vendor/autoload.php';

try {
    $workerId = intval($_GET['id'] ?? "");
    $branchId = intval($_GET['branch_id'] ?? "");

    $uploadDirectory = __DIR__ . '/static/';

    if(isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['photo']['tmp_name'];
        $fileName = $_FILES['photo']['name'];
        $fileSize = $_FILES['photo']['size'];
        $fileType = $_FILES['photo']['type'];

        $newFileName = 'worker-img-' . $workerId . '.png';

        $uploadFilePath = $uploadDirectory . $newFileName;

        $image = imagecreatefromstring(file_get_contents($fileTmpPath));
        if ($image !== false) {
            imagepng($image, $uploadFilePath);
            imagedestroy($image);
        } else {
            throw new Exception('Ошибка при преобразовании изображения в формат PNG.');
        }
    } else {
        throw new Exception('Ошибка при загрузке файла.');
    }
} catch (\Exception $e) {
    error_log($e->getMessage());
}

header("Location: /worker.php?id=" . $workerId . "&branch_id=" . $branchId);
exit;