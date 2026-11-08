<h2>Добавление специализации</h2>
<hr>
<form method="post">
    <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>
    <label>Название</label>
    <input type="text" name="name">

    <button type="submit">Сохранить</button>
</form>
