<h2>Редактирование пациента</h2>
<hr>

<form method="post">
    <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>
    <label>Фамилия</label>
    <input type="text" name="last_name" value="<?= $patient->last_name ?>">

    <label>Имя</label>
    <input type="text" name="first_name" value="<?= $patient->first_name ?>">

    <label>Отчество</label>
    <input type="text" name="middle_name" value="<?= $patient->middle_name ?>">

    <label>Дата рождения</label>
    <input type="date" name="birth_date" value="<?= $patient->birth_date ?>">

    <button type="submit">Сохранить</button>
</form>
