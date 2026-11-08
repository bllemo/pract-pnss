<h1>Пациенты</h1>
<hr>
<div>
    <a class="button" href="<?= app()->route->getUrl('/patients/create') ?>">Добавить пациента</a>
</div>
<br>
<form method="get" class="search-form">
    <input type="text" name="search" placeholder="ФИО" value="<?= $search ?? '' ?>">
    <input type="date" name="birth_date" value="<?= $birth_date ?? '' ?>">
    <button type="submit">Найти</button>
    <a class="button" href="<?= app()->route->getUrl('/patients') ?>">Сбросить</a>
</form>
<br>
<?php $csrf = app()->auth::generateCSRF(); ?>
<table>
    <tr>
        <th>Фамилия</th>
        <th>Имя</th>
        <th>Отчество</th>
        <th>Дата рождения</th>
        <th>Действия</th>
    </tr>
    <?php
    foreach ($patients as $patient):
        ?>
        <tr>
            <td><?= $patient->last_name ?></td>
            <td><?= $patient->first_name ?></td>
            <td><?= $patient->middle_name ?></td>
            <td><?= $patient->birth_date ?></td>
            <td>
                <a href="<?= app()->route->getUrl('/patients/update/' . $patient->id) ?>">Изменить</a>
                <form method="post" action="<?= app()->route->getUrl('/patients/delete/' . $patient->id) ?>" style="display:inline">
                    <input name="csrf_token" type="hidden" value="<?= $csrf ?>"/>
                    <button type="submit">Удалить</button>
                </form>
            </td>
        </tr>
    <?php
    endforeach;
    ?>
</table>
