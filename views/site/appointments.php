<h1>Записи на приём</h1>
<hr>
<div>
    <a class="button" href="<?= app()->route->getUrl('/appointments/create') ?>">Добавить запись</a>
</div>
<br>
<form method="get" class="search-form">
    <input type="text" name="search" placeholder="ФИО пациента" value="<?= $search ?? '' ?>">
    <select name="doctor_id">
        <option value="">Все врачи</option>
        <?php foreach ($doctors as $doctor): ?>
            <option value="<?= $doctor->id ?>" <?= ($doctor_id ?? '') == $doctor->id ? 'selected' : '' ?>><?= $doctor->last_name ?> <?= $doctor->first_name ?> <?= $doctor->middle_name ?></option>
        <?php endforeach; ?>
    </select>
    <select name="status">
        <option value="">Все статусы</option>
        <option value="wait" <?= ($status ?? '') === 'wait' ? 'selected' : '' ?>>Ожидание</option>
        <option value="cancelled" <?= ($status ?? '') === 'cancelled' ? 'selected' : '' ?>>Отменено</option>
        <option value="success" <?= ($status ?? '') === 'success' ? 'selected' : '' ?>>Завершено</option>
    </select>
    <input type="date" name="visit_date" value="<?= $visit_date ?? '' ?>">
    <button type="submit">Найти</button>
    <a class="button" href="<?= app()->route->getUrl('/appointments') ?>">Сбросить</a>
</form>
<br>
<?php $csrf = app()->auth::generateCSRF(); ?>
<table>
    <tr>
        <th>Пациент</th>
        <th>Врач</th>
        <th>Дата и время приёма</th>
        <th>Статус</th>
        <th>Действия</th>
    </tr>
    <?php
    $statuses = ['wait' => 'Ожидание', 'cancelled' => 'Отменено', 'success' => 'Завершено'];
    foreach ($appointments as $appointment):
        ?>
        <tr>
            <td><?= $appointment->patient->last_name ?? '' ?> <?= $appointment->patient->first_name ?? '' ?> <?= $appointment->patient->middle_name ?? '' ?></td>
            <td><?= $appointment->doctor->last_name ?? '' ?> <?= $appointment->doctor->first_name ?? '' ?> <?= $appointment->doctor->middle_name ?? '' ?></td>
            <td><?= $appointment->visit_timestamp ?></td>
            <td><?= $statuses[$appointment->status] ?? $appointment->status ?></td>
            <td>
                <a href="<?= app()->route->getUrl('/appointments/update/' . $appointment->id) ?>">Изменить</a>
                <form method="post" action="<?= app()->route->getUrl('/appointments/delete/' . $appointment->id) ?>" style="display:inline">
                    <input name="csrf_token" type="hidden" value="<?= $csrf ?>"/>
                    <button type="submit">Удалить</button>
                </form>
            </td>
        </tr>
    <?php
    endforeach;
    ?>
</table>
