<?php
//Включаем запрет на неявное преобразование типов
declare(strict_types=1);
// убрать всяческие предупреждения об использовании старых функций
error_reporting(E_ALL ^ E_DEPRECATED);
session_start();

try {
    //Создаем экземпляр приложения и запускаем его
    $app = require_once __DIR__ . '/../core/bootstrap.php';
    $app->run();
} catch (\Throwable $exception) {
    echo '<pre>';
    print_r($exception);
    /* echo "ошибка блять"; */
    echo '</pre>';
}
