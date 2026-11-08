<?php

namespace Controllers;

use Models\Appointment;
use Models\Doctor;
use Models\Patient;
use Models\Position;
use Models\Specification;
use Models\User;
use Src\Request;
use Src\Validator\Validator;
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

    public function signup(Request $request): string
    {

        if ($request->method === 'POST') {
            $validator = new Validator($request->all(), [
                'login' => ['required', 'min:3', 'max:255', 'unique:users,login', 'regex:/^[a-zA-Z0-9]*$/'],
                'password' => ['required', 'min:5', 'max:255'],
                'last_name' => ['required', 'min:3', 'max:255'],
                'first_name' => ['required', 'min:3', 'max:255'],
                'middle_name' => ['max:255']
            ], [
                'required' => 'Поле :field пусто',
                'unique' => 'Значение для :field не подходит! Оно уже занято',
                'max' => 'Длина поля :field слишком длинное! Максимум: :value',
                'min' => 'Длина поля :field слишком короткое! Минимум: :value',
                'regex' => 'Поле логина должно иметь только латинские буквы и цифры'
            ]);
            if ($validator->fails()) {
                return new View('site.create-user', ['errors' => $validator->errors()]);
            }
            User::create($request->all());
            app()->route->redirect('/patients');
        }
        return new View('site.create-user');
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

    //Список пациентов (с поиском по ФИО и дате рождения)
    public function patients(Request $request): string
    {
        $params = $request->all();
        $search = $this->filterValue($params, 'search');
        $birth_date = $this->filterValue($params, 'birth_date');

        $query = Patient::query();
        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('last_name', 'like', "%{$search}%")
                    ->orWhere('first_name', 'like', "%{$search}%")
                    ->orWhere('middle_name', 'like', "%{$search}%");
            });
        }
        if ($birth_date !== '') {
            $query->where('birth_date', $birth_date);
        }
        $patients = $query->get();

        return new View('site.patients', [
            'patients' => $patients,
            'search' => $search,
            'birth_date' => $birth_date,
        ]);
    }

    //Список сотрудников (доступен администратору, с поиском по логину/ФИО и роли)
    public function users(Request $request): string
    {
        $params = $request->all();
        $search = $this->filterValue($params, 'search');
        $role = $this->filterValue($params, 'role');

        $query = User::query();
        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('login', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('first_name', 'like', "%{$search}%")
                    ->orWhere('middle_name', 'like', "%{$search}%");
            });
        }
        if (in_array($role, ['admin', 'user'], true)) {
            $query->where('role', $role);
        }
        $users = $query->get();

        return new View('site.users', [
            'users' => $users,
            'search' => $search,
            'role' => $role,
        ]);
    }

    //Регистрация пациента (доступна сотрудникам)
    public function createPatient(Request $request): string
    {
        if ($request->method === 'POST') {
            $validator = new Validator($request->all(), [
                'last_name' => ['required', 'min:3', 'max:255'],
                'first_name' => ['required', 'min:3', 'max:255'],
                'middle_name' => ['max:255'],
                'birth_date' => ['required', 'regex:/^\d{4}-\d{2}-\d{2}$/']
            ], [
                'required' => 'Поле :field пусто',
                'max' => 'Длина поля :field слишком длинное! Максимум: :value',
                'min' => 'Длина поля :field слишком короткое! Минимум: :value',
                'regex' => 'Поле :field должно быть в формате ГГГГ-ММ-ДД'
            ]);
            if ($validator->fails()) {
                return new View('site.create-patient', ['errors' => $validator->errors()]);
            }
            Patient::create($request->all());
            app()->route->redirect('/patients');
        }
        return new View('site.create-patient');
    }

    //Редактирование пациента (доступно сотрудникам)
    public function updatePatient($id, Request $request): string
    {
        $patient = Patient::find($id);
        if (!$patient) {
            app()->route->redirect('/patients');
            return '';
        }
        if ($request->method === 'POST') {
            $validator = new Validator($request->all(), [
                'last_name' => ['required', 'min:3', 'max:255'],
                'first_name' => ['required', 'min:3', 'max:255'],
                'middle_name' => ['max:255'],
                'birth_date' => ['required', 'regex:/^\d{4}-\d{2}-\d{2}$/']
            ], [
                'required' => 'Поле :field пусто',
                'max' => 'Длина поля :field слишком длинное! Максимум: :value',
                'min' => 'Длина поля :field слишком короткое! Минимум: :value',
                'regex' => 'Поле :field должно быть в формате ГГГГ-ММ-ДД'
            ]);
            if ($validator->fails()) {
                return new View('site.update-patient', ['errors' => $validator->errors(), 'patient' => $patient]);
            }
            $patient->update($request->all());
            app()->route->redirect('/patients');
        }
        return new View('site.update-patient', ['patient' => $patient]);
    }

    //Удаление пациента (доступно сотрудникам)
    public function deletePatient($id, Request $request): void
    {
        $patient = Patient::find($id);
        if ($patient) {
            //Сначала удаляем связанные записи (ограничение внешнего ключа)
            $patient->appointments()->delete();
            $patient->delete();
        }
        app()->route->redirect('/patients');
    }

    //Редактирование сотрудника (доступно администратору)
    public function updateUser($id, Request $request): string
    {
        $user = User::find($id);
        if (!$user) {
            app()->route->redirect('/users');
            return '';
        }
        if ($request->method === 'POST') {
            $input = $request->all();
            $password = $input['password'] ?? '';
            unset($input['password']);
            $rules = [
                'login' => ['required', 'min:3', 'max:255', 'regex:/^[a-zA-Z0-9]*$/'],
                'last_name' => ['required', 'min:3', 'max:255'],
                'first_name' => ['required', 'min:3', 'max:255'],
                'middle_name' => ['max:255']
            ];
            //Правило unique применяем, только если логин изменился
            if (($input['login'] ?? null) !== $user->login) {
                $rules['login'][] = 'unique:users,login';
            }
            //Пароль необязателен: проверяем только если он заполнен
            if (!empty($password)) {
                $rules['password'] = ['min:5', 'max:255'];
            }
            $validator = new Validator($input, $rules, [
                'required' => 'Поле :field пусто',
                'unique' => 'Значение для :field не подходит! Оно уже занято',
                'max' => 'Длина поля :field слишком длинное! Максимум: :value',
                'min' => 'Длина поля :field слишком короткое! Минимум: :value',
                'regex' => 'Поле логина должно иметь только латинские буквы и цифры'
            ]);
            if ($validator->fails()) {
                return new View('site.update-user', ['errors' => $validator->errors(), 'user' => $user]);
            }
            $user->update($input);
            //Пароль меняем и хешируем отдельно, как при регистрации
            if (!empty($password)) {
                $user->password = md5($password);
                $user->save();
            }
            app()->route->redirect('/users');
        }
        return new View('site.update-user', ['user' => $user]);
    }

    //Список врачей (доступен администратору, с поиском по ФИО, должности и специализации)
    public function doctors(Request $request): string
    {
        $params = $request->all();
        $search = $this->filterValue($params, 'search');
        $position_id = $this->filterValue($params, 'position_id');
        $specification_id = $this->filterValue($params, 'specification_id');

        $query = Doctor::with(['position', 'specification'])->where('deleted', false);
        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('last_name', 'like', "%{$search}%")
                    ->orWhere('first_name', 'like', "%{$search}%")
                    ->orWhere('middle_name', 'like', "%{$search}%");
            });
        }
        if ($position_id !== '') {
            $query->where('position_id', $position_id);
        }
        if ($specification_id !== '') {
            $query->where('specification_id', $specification_id);
        }
        $doctors = $query->get();

        return new View('site.doctors', [
            'doctors' => $doctors,
            'positions' => Position::all(),
            'specifications' => Specification::all(),
            'search' => $search,
            'position_id' => $position_id,
            'specification_id' => $specification_id,
        ]);
    }

    //Регистрация врача (доступна администратору)
    public function createDoctor(Request $request): string
    {
        if ($request->method === 'POST') {
            $params = $request->all();
            $to_merge = [];
            if (!$this->isEmptyRelation($params['position_id'] ?? null)) {
                $to_merge['position_id'] = ['required', 'exists:positions,id'];
            }
            if (!$this->isEmptyRelation($params['specification_id'] ?? null)) {
                $to_merge['specification_id'] = ['required', 'exists:specifications,id'];
            }
            $validator = new Validator($request->all(), array_merge([
                'last_name' => ['required', 'min:3', 'max:255'],
                'first_name' => ['required', 'min:3', 'max:255'],
                'middle_name' => ['max:255'],
                'birth_date' => ['required', 'regex:/^\d{4}-\d{2}-\d{2}$/'],
            ], $to_merge), [
                'required' => 'Поле :field пусто',
                'exists' => 'Вы ввели несуществующее значение в поле :field!',
                'max' => 'Длина поля :field слишком длинное! Максимум: :value',
                'min' => 'Длина поля :field слишком короткое! Минимум: :value',
                'regex' => 'Поле :field должно быть в формате ГГГГ-ММ-ДД'
            ]);
            if ($validator->fails()) {
                return new View('site.create-doctor', [
                    'errors' => $validator->errors(),
                    'positions' => Position::all(),
                    'specifications' => Specification::all()
                ]);
            }
            Doctor::create($this->doctorData($request->all()));
            app()->route->redirect('/doctors');
        }
        return new View('site.create-doctor', [
            'positions' => Position::all(),
            'specifications' => Specification::all()
        ]);
    }

    //Редактирование врача (доступно администратору)
    public function updateDoctor($id, Request $request): string
    {
        $doctor = Doctor::find($id);
        if (!$doctor) {
            app()->route->redirect('/doctors');
            return '';
        }
        if ($request->method === 'POST') {
            $params = $request->all();
            $to_merge = [];
            if (!$this->isEmptyRelation($params['position_id'] ?? null)) {
                $to_merge['position_id'] = ['required', 'exists:positions,id'];
            }
            if (!$this->isEmptyRelation($params['specification_id'] ?? null)) {
                $to_merge['specification_id'] = ['required', 'exists:specifications,id'];
            }
            $validator = new Validator($request->all(), array_merge(
                [
                    'last_name' => ['required', 'min:3', 'max:255'],
                    'first_name' => ['required', 'min:3', 'max:255'],
                    'middle_name' => ['max:255'],
                    'birth_date' => ['required', 'regex:/^\d{4}-\d{2}-\d{2}$/'],
                ],
                $to_merge
            ), [
                'required' => 'Поле :field пусто',
                'exists' => 'Вы ввели несуществующее значение в поле :field!',
                'max' => 'Длина поля :field слишком длинное! Максимум: :value',
                'min' => 'Длина поля :field слишком короткое! Минимум: :value',
                'regex' => 'Поле :field должно быть в формате ГГГГ-ММ-ДД'
            ]);
            if ($validator->fails()) {
                return new View('site.update-doctor', [
                    'errors' => $validator->errors(),
                    'doctor' => $doctor,
                    'positions' => Position::all(),
                    'specifications' => Specification::all()
                ]);
            }
            $doctor->update($this->doctorData($request->all()));
            app()->route->redirect('/doctors');
        }
        return new View('site.update-doctor', [
            'doctor' => $doctor,
            'positions' => Position::all(),
            'specifications' => Specification::all()
        ]);
    }

    //Удаление врача (доступно администратору)
    public function deleteDoctor($id, Request $request): void
    {
        $doctor = Doctor::find($id);
        if ($doctor) {
            $doctor->deleted = true;
            $doctor->save();
        }
        app()->route->redirect('/doctors');
    }

    //Список должностей (доступен администратору, с поиском по названию)
    public function positions(Request $request): string
    {
        $search = $this->filterValue($request->all(), 'search');
        $query = Position::query();
        if ($search !== '') {
            $query->where('name', 'like', "%{$search}%");
        }
        return new View('site.positions', ['positions' => $query->get(), 'search' => $search]);
    }

    //Добавление должности (доступно администратору)
    public function createPosition(Request $request): string
    {
        if ($request->method === 'POST') {
            $validator = new Validator($request->all(), [
                'name' => ['required', 'min:3', 'max:100']
            ], [
                'required' => 'Поле :field пусто',
                'max' => 'Длина поля :field слишком длинное! Максимум: :value',
                'min' => 'Длина поля :field слишком короткое! Минимум: :value'
            ]);
            if ($validator->fails()) {
                return new View('site.create-position', ['errors' => $validator->errors()]);
            }
            Position::create($request->all());
            app()->route->redirect('/positions');
        }
        return new View('site.create-position');
    }

    //Редактирование должности (доступно администратору)
    public function updatePosition($id, Request $request): string
    {
        $position = Position::find($id);
        if (!$position) {
            app()->route->redirect('/positions');
            return '';
        }
        if ($request->method === 'POST') {
            $validator = new Validator($request->all(), [
                'name' => ['required', 'min:3', 'max:100']
            ], [
                'required' => 'Поле :field пусто',
                'max' => 'Длина поля :field слишком длинное! Максимум: :value',
                'min' => 'Длина поля :field слишком короткое! Минимум: :value'
            ]);
            if ($validator->fails()) {
                return new View('site.update-position', ['errors' => $validator->errors(), 'position' => $position]);
            }
            $position->update($request->all());
            app()->route->redirect('/positions');
        }
        return new View('site.update-position', ['position' => $position]);
    }

    //Удаление должности (доступно администратору)
    public function deletePosition($id, Request $request): void
    {
        $position = Position::find($id);
        if ($position) {
            $position->delete();
        }
        app()->route->redirect('/positions');
    }

    //Список специализаций (доступен администратору, с поиском по названию)
    public function specifications(Request $request): string
    {
        $search = $this->filterValue($request->all(), 'search');
        $query = Specification::query();
        if ($search !== '') {
            $query->where('name', 'like', "%{$search}%");
        }
        return new View('site.specifications', ['specifications' => $query->get(), 'search' => $search]);
    }

    //Добавление специализации (доступно администратору)
    public function createSpecification(Request $request): string
    {
        if ($request->method === 'POST') {
            $validator = new Validator($request->all(), [
                'name' => ['required', 'min:3', 'max:100']
            ], [
                'required' => 'Поле :field пусто',
                'max' => 'Длина поля :field слишком длинное! Максимум: :value',
                'min' => 'Длина поля :field слишком короткое! Минимум: :value'
            ]);
            if ($validator->fails()) {
                return new View('site.create-specification', ['errors' => $validator->errors()]);
            }
            Specification::create($request->all());
            app()->route->redirect('/specifications');
        }
        return new View('site.create-specification');
    }

    //Редактирование специализации (доступно администратору)
    public function updateSpecification($id, Request $request): string
    {
        $specification = Specification::find($id);
        if (!$specification) {
            app()->route->redirect('/specifications');
            return '';
        }
        if ($request->method === 'POST') {
            $validator = new Validator($request->all(), [
                'name' => ['required', 'min:3', 'max:100']
            ], [
                'required' => 'Поле :field пусто',
                'max' => 'Длина поля :field слишком длинное! Максимум: :value',
                'min' => 'Длина поля :field слишком короткое! Минимум: :value'
            ]);
            if ($validator->fails()) {
                return new View('site.update-specification', ['errors' => $validator->errors(), 'specification' => $specification]);
            }
            $specification->update($request->all());
            app()->route->redirect('/specifications');
        }
        return new View('site.update-specification', ['specification' => $specification]);
    }

    //Удаление специализации (доступно администратору)
    public function deleteSpecification($id, Request $request): void
    {
        $specification = Specification::find($id);
        if ($specification) {
            $specification->delete();
        }
        app()->route->redirect('/specifications');
    }

    //Правила проверки полей записи на приём
    private function appointmentRules(): array
    {
        return [
            'patient_id' => ['required', 'exists:patients,id'],
            'doctor_id' => ['required', 'exists:doctors,id'],
            //Двоеточие записано как \x3a: парсер валидатора разбивает правило по символу ":"
            'visit_timestamp' => ['required', 'regex:/^\d{4}-\d{2}-\d{2}T\d{2}\x3a\d{2}$/'],
            'status' => ['required', 'regex:/^(wait|cancelled|success)$/'],
        ];
    }

    //Сообщения об ошибках для записи на приём
    private function appointmentMessages(): array
    {
        return [
            'required' => 'Поле :field пусто',
            'exists' => 'Вы ввели несуществующее значение в поле :field!',
            'regex' => 'Поле :field заполнено неверно',
        ];
    }

    //Данные для формы записи (пациенты и неудалённые врачи)
    private function appointmentFormData(?Appointment $appointment = null): array
    {
        $doctors = Doctor::where('deleted', false)->get();
        //Если врач записи уже удалён, оставляем его в списке, чтобы не потерять связь
        if ($appointment && $appointment->doctor && !$doctors->contains('id', $appointment->doctor_id)) {
            $doctors->push($appointment->doctor);
        }
        return [
            'patients' => Patient::all(),
            'doctors' => $doctors,
        ];
    }

    //Приведение полей записи к виду, пригодному для сохранения в БД
    private function appointmentData(array $input, bool $withCreator = false): array
    {
        $input['visit_timestamp'] = str_replace('T', ' ', $input['visit_timestamp']) . ':00';
        $input['cancelled_at'] = $input['status'] === 'cancelled' ? date('Y-m-d') : null;
        if ($withCreator) {
            $input['created_by'] = Auth::user()->id;
        }
        return $input;
    }

    //Список записей на приём (доступен сотрудникам, с поиском по пациенту, врачу, статусу и дате)
    public function appointments(Request $request): string
    {
        $params = $request->all();
        $search = $this->filterValue($params, 'search');
        $doctor_id = $this->filterValue($params, 'doctor_id');
        $status = $this->filterValue($params, 'status');
        $visit_date = $this->filterValue($params, 'visit_date');

        $query = Appointment::with(['patient', 'doctor', 'creator']);
        if ($search !== '') {
            $query->whereHas('patient', function ($q) use ($search) {
                $q->where('last_name', 'like', "%{$search}%")
                    ->orWhere('first_name', 'like', "%{$search}%")
                    ->orWhere('middle_name', 'like', "%{$search}%");
            });
        }
        if ($doctor_id !== '') {
            $query->where('doctor_id', $doctor_id);
        }
        if (in_array($status, ['wait', 'cancelled', 'success'], true)) {
            $query->where('status', $status);
        }
        if ($visit_date !== '') {
            $query->whereDate('visit_timestamp', $visit_date);
        }
        $appointments = $query->get();

        return new View('site.appointments', [
            'appointments' => $appointments,
            'doctors' => Doctor::where('deleted', false)->get(),
            'search' => $search,
            'doctor_id' => $doctor_id,
            'status' => $status,
            'visit_date' => $visit_date,
        ]);
    }

    //Создание записи на приём (доступно сотрудникам)
    public function createAppointment(Request $request): string
    {
        if ($request->method === 'POST') {
            $validator = new Validator($request->all(), $this->appointmentRules(), $this->appointmentMessages());
            if ($validator->fails()) {
                return new View('site.create-appointment', array_merge(
                    ['errors' => $validator->errors()],
                    $this->appointmentFormData()
                ));
            }
            Appointment::create($this->appointmentData($request->all(), true));
            app()->route->redirect('/appointments');
        }
        return new View('site.create-appointment', $this->appointmentFormData());
    }

    //Редактирование записи на приём (доступно сотрудникам)
    public function updateAppointment($id, Request $request): string
    {
        $appointment = Appointment::find($id);
        if (!$appointment) {
            app()->route->redirect('/appointments');
            return '';
        }
        if ($request->method === 'POST') {
            $validator = new Validator($request->all(), $this->appointmentRules(), $this->appointmentMessages());
            if ($validator->fails()) {
                return new View('site.update-appointment', array_merge(
                    ['errors' => $validator->errors(), 'appointment' => $appointment],
                    $this->appointmentFormData($appointment)
                ));
            }
            $appointment->update($this->appointmentData($request->all()));
            app()->route->redirect('/appointments');
        }
        return new View('site.update-appointment', array_merge(
            ['appointment' => $appointment],
            $this->appointmentFormData($appointment)
        ));
    }

    //Удаление записи на приём (доступно сотрудникам)
    public function deleteAppointment($id, Request $request): void
    {
        $appointment = Appointment::find($id);
        if ($appointment) {
            $appointment->delete();
        }
        app()->route->redirect('/appointments');
    }

    //Безопасное получение строкового значения фильтра из запроса
    private function filterValue(array $params, string $key): string
    {
        $value = $params[$key] ?? '';
        return is_string($value) ? trim($value) : '';
    }

    //Считается ли значение пустой связью (поле <select> с вариантом "Отсутствует")
    private function isEmptyRelation($value): bool
    {
        return $value === null || $value === '' || $value === 'null';
    }

    //Приведение position_id/specification_id к NULL перед сохранением врача
    private function doctorData(array $input): array
    {
        foreach (['position_id', 'specification_id'] as $field) {
            if ($this->isEmptyRelation($input[$field] ?? null)) {
                $input[$field] = null;
            }
        }
        return $input;
    }
}
