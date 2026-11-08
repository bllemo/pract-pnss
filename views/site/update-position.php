<h2>Редактирование должности</h2>
<hr>
<form method="post">
    <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>
    <label>Название</label>
    <input type="text" name="name" value="<?= $position->name ?>">

    <button type="submit">Сохранить</button>
</form>
