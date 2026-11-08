<h2>Регистрация врача</h2>
<hr>
<form method="post">
    <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>" />
    <label>Фамилия</label>
    <input type="text" name="last_name">

    <label>Имя</label>
    <input type="text" name="first_name">

    <label>Отчество</label>
    <input type="text" name="middle_name">

    <label>Дата рождения</label>
    <input type="date" name="birth_date">

    <label>Должность</label>
    <select name="position_id">
        <option value="null">Отсутствует</option>
        <?php foreach ($positions as $position): ?>
            <option value="<?= $position->id ?>"><?= $position->name ?></option>
        <?php endforeach; ?>
    </select>

    <label>Специализация</label>
    <select name="specification_id">
        <option value="null">Отсутствует</option>
        <?php foreach ($specifications as $specification): ?>
            <option value="<?= $specification->id ?>"><?= $specification->name ?></option>
        <?php endforeach; ?>
    </select>

    <button type="submit">Сохранить</button>
</form>
