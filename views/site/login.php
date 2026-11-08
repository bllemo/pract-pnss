<h2>Авторизация</h2>
<hr>
<h3><?= $message ?? ''; ?></h3>
<?php
if (!app()->auth::check()):
    ?>
    <form method="post">
        <label>Логин</label>
        <input type="text" name="login">

        <label>Пароль</label>
        <input type="password" name="password">

        <button type="submit">Войти</button>
    </form>
<?php endif;
