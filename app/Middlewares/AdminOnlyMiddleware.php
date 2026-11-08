<?php

namespace Middlewares;

use Src\Auth\Auth;
use Src\Request;
use Src\View;

class AdminOnlyMiddleware
{
    public function handle(Request $request)
    {
        //Неавторизованного отправляем на вход
        if (!Auth::check()) {
            app()->route->redirect('/login');
            exit;
        }
        //Остальным показываем страницу доступна только администратору
        if (Auth::user()->role !== 'admin') {
            (new View())->render('site.error403');
            exit;
        }
    }
}
