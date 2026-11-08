<h2>Новая запись на приём</h2>
<hr>

<form method="post">
    <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>

    <label>Пациент</label>
    <select name="patient_id">
        <option value="">Выберите пациента</option>
        <?php foreach ($patients as $patient): ?>
            <option value="<?= $patient->id ?>">
                <?= $patient->last_name ?> <?= $patient->first_name ?> <?= $patient->middle_name ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label>Врач</label>
    <select name="doctor_id">
        <option value="">Выберите врача</option>
        <?php foreach ($doctors as $doctor): ?>
            <option value="<?= $doctor->id ?>">
                <?= $doctor->last_name ?> <?= $doctor->first_name ?> <?= $doctor->middle_name ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label>Дата и время приёма</label>
    <input type="datetime-local" name="visit_timestamp">

    <label>Статус</label>
    <select name="status">
        <option value="wait">Ожидание</option>
        <option value="cancelled">Отменено</option>
        <option value="success">Завершено</option>
    </select>

    <button type="submit">Сохранить</button>
</form>
