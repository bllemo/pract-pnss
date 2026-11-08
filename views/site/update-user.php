<h2>Редактирование сотрудника</h2>
<hr>

<form method="post">
    <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>
    <label>Логин</label>
    <input type="text" name="login" value="<?= $user->login ?>">

    <label>Пароль</label>
    <input type="password" name="password" placeholder="Оставьте пустым, чтобы не менять">

    <label>Фамилия</label>
    <input type="text" name="last_name" value="<?= $user->last_name ?>">

    <label>Имя</label>
    <input type="text" name="first_name" value="<?= $user->first_name ?>">

    <label>Отчество</label>
    <input type="text" name="middle_name" value="<?= $user->middle_name ?>">

    <button type="submit">Сохранить</button>
</form>
