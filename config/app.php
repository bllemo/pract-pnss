<?php
return [
    //Класс аутентификации
    'auth' => \Src\Auth\Auth::class,
    //Клас пользователя
    'identity'=>\Models\User::class,
    'routeMiddleware' => [
        'auth' => \Middlewares\AuthMiddleware::class,
        'admin-only' => \Middlewares\AdminOnlyMiddleware::class
    ],
    'validators' => [
        'required' => \Validators\RequiredValidator::class,
        'unique' => \Validators\UniqueFieldValidator::class,
        'exists' => \Validators\ExistsValueValidator::class,
        'max' => \Validators\MaxSymbolsCountValidator::class,
        'min' => \Validators\MinSymbolsCountValidator::class,
        'email' => \Validators\EmailAddressValidator::class,
        'phone' => \Validators\PhoneNumberValidator::class,
        'regex' => \Validators\RegexPatternValidation::class
    ],
    'routeAppMiddleware' => [
        'csrf' => \Middlewares\CSRFMiddleware::class,
        'trim' => \Middlewares\TrimMiddleware::class,
        'specialChars' => \Middlewares\SpecialCharsMiddleware::class,
    ],
];
