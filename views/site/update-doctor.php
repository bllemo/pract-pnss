<h2>Редактирование врача</h2>
<hr>
<form method="post">
    <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>
    <label>Фамилия</label>
    <input type="text" name="last_name" value="<?= $doctor->last_name ?>">

    <label>Имя</label>
    <input type="text" name="first_name" value="<?= $doctor->first_name ?>">

    <label>Отчество</label>
    <input type="text" name="middle_name" value="<?= $doctor->middle_name ?>">

    <label>Дата рождения</label>
    <input type="date" name="birth_date" value="<?= $doctor->birth_date ?>">

    <label>Должность</label>
    <select name="position_id">
        <option value="null" <?= $doctor->position_id === null ? 'selected' : '' ?>>Отсутствует</option>
        <?php foreach ($positions as $position): ?>
            <option value="<?= $position->id ?>" <?= $position->id == $doctor->position_id ? 'selected' : '' ?>><?= $position->name ?></option>
        <?php endforeach; ?>
    </select>

    <label>Специализация</label>
    <select name="specification_id">
        <option value="null" <?= $doctor->specification_id === null ? 'selected' : '' ?>>Отсутствует</option>
        <?php foreach ($specifications as $specification): ?>
            <option value="<?= $specification->id ?>" <?= $specification->id == $doctor->specification_id ? 'selected' : '' ?>><?= $specification->name ?></option>
        <?php endforeach; ?>
    </select>

    <button type="submit">Сохранить</button>
</form>
