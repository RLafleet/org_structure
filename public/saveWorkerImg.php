<?php
declare(strict_types=1);
require_once __DIR__ . '/vendor/autoload.php';

try {
    $workerId = intval($_GET['id'] ?? "");
    $branchId = intval($_GET['branch_id'] ?? "");

    // Путь к папке, куда будут сохраняться изображения
    $uploadDirectory = __DIR__ . '/static/';

    // Проверяем, был ли загружен файл
    if(isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['photo']['tmp_name'];
        $fileName = $_FILES['photo']['name'];
        $fileSize = $_FILES['photo']['size'];
        $fileType = $_FILES['photo']['type'];

        // Генерируем новое имя файла
        $newFileName = 'worker-img-' . $workerId . '.png';

        // Перемещаем файл в папку загрузки с новым именем
        $uploadFilePath = $uploadDirectory . $newFileName;

        // Преобразование изображения в формат PNG
        $image = imagecreatefromstring(file_get_contents($fileTmpPath));
        if ($image !== false) {
            // Сохранение изображения в формате PNG
            imagepng($image, $uploadFilePath);
            imagedestroy($image); // Освобождаем память, занятую изображением
        } else {
            throw new Exception('Ошибка при преобразовании изображения в формат PNG.');
        }

        // Ваш код для сохранения пути к файлу в базе данных или как-либо еще
    } else {
        throw new Exception('Ошибка при загрузке файла.');
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}

header("Location: /worker.php?id=" . $workerId . "&branch_id=" . $branchId);
exit;
?>
