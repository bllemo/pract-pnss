<h1>Пациенты</h1>
<hr>
<div>
    <a class="button" href="<?= app()->route->getUrl('/patients/create') ?>">Добавить пациента</a>
</div>
<br>
<table>
    <tr>
        <th>Фамилия</th>
        <th>Имя</th>
        <th>Отчество</th>
        <th>Дата рождения</th>
    </tr>
    <?php
    foreach ($patients as $patient):
        ?>
        <tr>
            <td><?= $patient->last_name ?></td>
            <td><?= $patient->first_name ?></td>
            <td><?= $patient->middle_name ?></td>
            <td><?= $patient->birth_date ?></td>
        </tr>
    <?php
    endforeach;
    ?>
</table>
