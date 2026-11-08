<h1>Специализации</h1>
<hr>
<div>
    <a class="button" href="<?= app()->route->getUrl('/specifications/create') ?>">Добавить специализацию</a>
</div>
<br>
<form method="get" class="search-form">
    <input type="text" name="search" placeholder="Название" value="<?= $search ?? '' ?>">
    <button type="submit">Найти</button>
    <a class="button" href="<?= app()->route->getUrl('/specifications') ?>">Сбросить</a>
</form>
<br>
<?php $csrf = app()->auth::generateCSRF(); ?>
<table>
    <tr>
        <th>Название</th>
        <th>Действия</th>
    </tr>
    <?php
    foreach ($specifications as $specification):
        ?>
        <tr>
            <td><?= $specification->name ?></td>
            <td>
                <a href="<?= app()->route->getUrl('/specifications/update/' . $specification->id) ?>">Изменить</a>
                <form method="post" action="<?= app()->route->getUrl('/specifications/delete/' . $specification->id) ?>" style="display:inline">
                    <input name="csrf_token" type="hidden" value="<?= $csrf ?>"/>
                    <button type="submit">Удалить</button>
                </form>
            </td>
        </tr>
    <?php
    endforeach;
    ?>
</table>
