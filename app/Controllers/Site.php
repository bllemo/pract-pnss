<?php

namespace Controllers;

use Models\Patient;
use Models\User;
use Src\Request;
use Src\View;
use Src\Auth\Auth;

class Site
{
    public function index(): void
    {
        app()->route->redirect('/hello');
    }

    public function hello(): string
    {
        $user = Auth::user();
        return new View('site.hello', ['message' => 'Здравствуйте, ' . $user->first_name]);
    }

    //Регистрация сотрудника (доступна только администратору)
    public function signup(Request $request): string
    {
        if ($request->method === 'POST') {
            $body = $request->all();
            $body['role'] = "user";
            User::create($body);
            app()->route->redirect('/patients');
        }
        return new View('site.create-user');
    }

    //Список пациентов
    public function patients(): string
    {
        $patients = Patient::all();
        return new View('site.patients', ['patients' => $patients]);
    }

    //Регистрация пациента (доступна сотрудникам)
    public function createPatient(Request $request): string
    {
        if ($request->method === 'POST') {
            Patient::create($request->all());
            app()->route->redirect('/patients');
        }
        return new View('site.create-patient');
    }

    public function login(Request $request): string
    {
        if ($request->method === 'GET') {
            return new View('site.login');
        }
        if (Auth::attempt($request->all())) {
            app()->route->redirect('/hello');
        }
        return new View('site.login', ['message' => 'Неправильные логин или пароль']);
    }

    public function logout(): void
    {
        Auth::logout();
        app()->route->redirect('/hello');
    }
}
