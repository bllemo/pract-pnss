<h1>Сотрудники</h1>
<hr>
<div>
    <a class="button" href="<?= app()->route->getUrl('/signup') ?>">Добавить сотрудника</a>
</div>
<br>
<form method="get" class="search-form">
    <input type="text" name="search" placeholder="Логин или ФИО" value="<?= $search ?? '' ?>">
    <select name="role">
        <option value="">Все роли</option>
        <option value="admin" <?= ($role ?? '') === 'admin' ? 'selected' : '' ?>>admin</option>
        <option value="user" <?= ($role ?? '') === 'user' ? 'selected' : '' ?>>user</option>
    </select>
    <button type="submit">Найти</button>
    <a class="button" href="<?= app()->route->getUrl('/users') ?>">Сбросить</a>
</form>
<br>
<table>
    <tr>
        <th>Логин</th>
        <th>Фамилия</th>
        <th>Имя</th>
        <th>Отчество</th>
        <th>Роль</th>
        <th>Действия</th>
    </tr>
    <?php
    foreach ($users as $user):
        ?>
        <tr>
            <td><?= $user->login ?></td>
            <td><?= $user->last_name ?></td>
            <td><?= $user->first_name ?></td>
            <td><?= $user->middle_name ?></td>
            <td><?= $user->role ?></td>
            <td><a href="<?= app()->route->getUrl('/users/update/' . $user->id) ?>">Изменить</a></td>
        </tr>
    <?php
    endforeach;
    ?>
</table>
