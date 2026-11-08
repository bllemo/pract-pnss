<h1>Должности</h1>
<hr>
<div>
    <a class="button" href="<?= app()->route->getUrl('/positions/create') ?>">Добавить должность</a>
</div>
<br>
<form method="get" class="search-form">
    <input type="text" name="search" placeholder="Название" value="<?= $search ?? '' ?>">
    <button type="submit">Найти</button>
    <a class="button" href="<?= app()->route->getUrl('/positions') ?>">Сбросить</a>
</form>
<br>
<?php $csrf = app()->auth::generateCSRF(); ?>
<table>
    <tr>
        <th>Название</th>
        <th>Действия</th>
    </tr>
    <?php
    foreach ($positions as $position):
        ?>
        <tr>
            <td><?= $position->name ?></td>
            <td>
                <a href="<?= app()->route->getUrl('/positions/update/' . $position->id) ?>">Изменить</a>
                <form method="post" action="<?= app()->route->getUrl('/positions/delete/' . $position->id) ?>" style="display:inline">
                    <input name="csrf_token" type="hidden" value="<?= $csrf ?>"/>
                    <button type="submit">Удалить</button>
                </form>
            </td>
        </tr>
    <?php
    endforeach;
    ?>
</table>
