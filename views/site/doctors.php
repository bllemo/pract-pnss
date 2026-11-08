<h1>Врачи</h1>
<hr>
<div>
    <a class="button" href="<?= app()->route->getUrl('/doctors/create') ?>">Добавить врача</a>
</div>
<br>
<form method="get" class="search-form">
    <input type="text" name="search" placeholder="ФИО" value="<?= $search ?? '' ?>">
    <select name="position_id">
        <option value="">Все должности</option>
        <?php foreach ($positions as $position): ?>
            <option value="<?= $position->id ?>" <?= ($position_id ?? '') == $position->id ? 'selected' : '' ?>><?= $position->name ?></option>
        <?php endforeach; ?>
    </select>
    <select name="specification_id">
        <option value="">Все специализации</option>
        <?php foreach ($specifications as $specification): ?>
            <option value="<?= $specification->id ?>" <?= ($specification_id ?? '') == $specification->id ? 'selected' : '' ?>><?= $specification->name ?></option>
        <?php endforeach; ?>
    </select>
    <button type="submit">Найти</button>
    <a class="button" href="<?= app()->route->getUrl('/doctors') ?>">Сбросить</a>
</form>
<br>
<?php $csrf = app()->auth::generateCSRF(); ?>
<table>
    <tr>
        <th>Фамилия</th>
        <th>Имя</th>
        <th>Отчество</th>
        <th>Дата рождения</th>
        <th>Должность</th>
        <th>Специализация</th>
        <th>Действия</th>
    </tr>
    <?php
    foreach ($doctors as $doctor):
    ?>
        <tr>
            <td><?= $doctor->last_name ?></td>
            <td><?= $doctor->first_name ?></td>
            <td><?= $doctor->middle_name ?></td>
            <td><?= $doctor->birth_date ?></td>
            <td><?= $doctor->position->name ?? '' ?></td>
            <td><?= $doctor->specification->name ?? '' ?></td>
            <td>
                <a href="<?= app()->route->getUrl('/doctors/update/' . $doctor->id) ?>">Изменить</a>
                <form method="post" action="<?= app()->route->getUrl('/doctors/delete/' . $doctor->id) ?>" style="display:inline">
                    <input name="csrf_token" type="hidden" value="<?= $csrf ?>" />
                    <button type="submit">Удалить</button>
                </form>
            </td>
        </tr>
    <?php
    endforeach;
    ?>
</table>
