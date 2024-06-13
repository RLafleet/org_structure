<?php
declare(strict_types=1);

// Устанавливаем переменную окружения, сигнализирующую приложению, что оно
//  запускается в режиме тестирования.
putenv('APP_ENV=test');

require_once __DIR__ . '/../public/vendor/autoload.php';