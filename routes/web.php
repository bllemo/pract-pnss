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
Route::add(['GET', 'POST'], '/patients/update/{id:\d+}', [Controllers\Site::class, 'updatePatient'])->middleware('auth');
Route::add('POST', '/patients/delete/{id:\d+}', [Controllers\Site::class, 'deletePatient'])->middleware('auth');

//Сотрудники — только администратор
Route::add('GET', '/users', [Controllers\Site::class, 'users'])->middleware('auth', 'admin-only');
Route::add(['GET', 'POST'], '/users/update/{id:\d+}', [Controllers\Site::class, 'updateUser'])->middleware('auth', 'admin-only');

//Врачи — только администратор
Route::add('GET', '/doctors', [Controllers\Site::class, 'doctors'])->middleware('auth', 'admin-only');
Route::add(['GET', 'POST'], '/doctors/create', [Controllers\Site::class, 'createDoctor'])->middleware('auth', 'admin-only');
Route::add(['GET', 'POST'], '/doctors/update/{id:\d+}', [Controllers\Site::class, 'updateDoctor'])->middleware('auth', 'admin-only');
Route::add('POST', '/doctors/delete/{id:\d+}', [Controllers\Site::class, 'deleteDoctor'])->middleware('auth', 'admin-only');

//Должности — только администратор
Route::add('GET', '/positions', [Controllers\Site::class, 'positions'])->middleware('auth', 'admin-only');
Route::add(['GET', 'POST'], '/positions/create', [Controllers\Site::class, 'createPosition'])->middleware('auth', 'admin-only');
Route::add(['GET', 'POST'], '/positions/update/{id:\d+}', [Controllers\Site::class, 'updatePosition'])->middleware('auth', 'admin-only');
Route::add('POST', '/positions/delete/{id:\d+}', [Controllers\Site::class, 'deletePosition'])->middleware('auth', 'admin-only');

//Специализации — только администратор
Route::add('GET', '/specifications', [Controllers\Site::class, 'specifications'])->middleware('auth', 'admin-only');
Route::add(['GET', 'POST'], '/specifications/create', [Controllers\Site::class, 'createSpecification'])->middleware('auth', 'admin-only');
Route::add(['GET', 'POST'], '/specifications/update/{id:\d+}', [Controllers\Site::class, 'updateSpecification'])->middleware('auth', 'admin-only');
Route::add('POST', '/specifications/delete/{id:\d+}', [Controllers\Site::class, 'deleteSpecification'])->middleware('auth', 'admin-only');

//Записи на приём — любой авторизованный сотрудник
Route::add('GET', '/appointments', [Controllers\Site::class, 'appointments'])->middleware('auth');
Route::add(['GET', 'POST'], '/appointments/create', [Controllers\Site::class, 'createAppointment'])->middleware('auth');
Route::add(['GET', 'POST'], '/appointments/update/{id:\d+}', [Controllers\Site::class, 'updateAppointment'])->middleware('auth');
Route::add('POST', '/appointments/delete/{id:\d+}', [Controllers\Site::class, 'deleteAppointment'])->middleware('auth');
