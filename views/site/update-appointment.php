<h2>Редактирование записи</h2>
<hr>

<form method="post">
    <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>

    <label>Пациент</label>
    <select name="patient_id">
        <option value="">Выберите пациента</option>
        <?php foreach ($patients as $patient): ?>
            <option value="<?= $patient->id ?>" <?= $patient->id == $appointment->patient_id ? 'selected' : '' ?>>
                <?= $patient->last_name ?> <?= $patient->first_name ?> <?= $patient->middle_name ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label>Врач</label>
    <select name="doctor_id">
        <option value="">Выберите врача</option>
        <?php foreach ($doctors as $doctor): ?>
            <option value="<?= $doctor->id ?>" <?= $doctor->id == $appointment->doctor_id ? 'selected' : '' ?>>
                <?= $doctor->last_name ?> <?= $doctor->first_name ?> <?= $doctor->middle_name ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label>Дата и время приёма</label>
    <input type="datetime-local" name="visit_timestamp" value="<?= date('Y-m-d\TH:i', strtotime($appointment->visit_timestamp)) ?>">

    <label>Статус</label>
    <select name="status">
        <option value="wait" <?= $appointment->status === 'wait' ? 'selected' : '' ?>>Ожидание</option>
        <option value="cancelled" <?= $appointment->status === 'cancelled' ? 'selected' : '' ?>>Отменено</option>
        <option value="success" <?= $appointment->status === 'success' ? 'selected' : '' ?>>Завершено</option>
    </select>

    <button type="submit">Сохранить</button>
</form>
