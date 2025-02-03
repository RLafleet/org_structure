<?php
setcookie('is_authenticated', '', time() - 3600, '/'); // Удаляем cookie
header('Location: /index.php');
exit;
