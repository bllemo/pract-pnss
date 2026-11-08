<h2>Регистрация пациента</h2>
<hr>
<h3><?= $message ?? ''; ?></h3>
<form method="post">        
    <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>
    <label>Фамилия</label>
    <input type="text" name="last_name">

    <label>Имя</label>
    <input type="text" name="first_name">

    <label>Отчество</label>
    <input type="text" name="middle_name">

    <label>Дата рождения</label>
    <input type="date" name="birth_date">

    <button type="submit">Сохранить</button>
</form>
