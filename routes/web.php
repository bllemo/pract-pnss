<?php

use Src\Route;

//Главная страница
Route::add('GET', '/', [Controllers\Site::class, 'index']);
Route::add('GET', '/hello', [Controllers\Site::class, 'hello'])->middleware('auth');

//Авторизация
Route::add(['GET', 'POST'], '/login', [Controllers\Site::class, 'login']);
Route::add('GET', '/logout', [Controllers\Site::class, 'logout'])->middleware('auth');

//Регистрация сотрудников — только администратор
Route::add(['GET', 'POST'], '/signup', [Controllers\Site::class, 'signup'])->middleware('auth', 'admin-only');

//Пациенты — любой авторизованный сотрудник
Route::add('GET', '/patients', [Controllers\Site::class, 'patients'])->middleware('auth');
Route::add(['GET', 'POST'], '/patients/create', [Controllers\Site::class, 'createPatient'])->middleware('auth');
