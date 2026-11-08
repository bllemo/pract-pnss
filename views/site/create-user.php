<h2>Регистрация сотрудника</h2>
<hr>
<h3><?= $message ?? ''; ?></h3>
<form method="post">
    <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>
    <label>Логин</label>
    <input type="text" name="login">

    <label>Пароль</label>
    <input type="password" name="password">

    <label>Фамилия</label>
    <input type="text" name="last_name">

    <label>Имя</label>
    <input type="text" name="first_name">

    <label>Отчество</label>
    <input type="text" name="middle_name">

    <button type="submit">Зарегистрировать</button>
</form>
