<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="/main.css" rel="stylesheet">
    <title>Медицинская система</title>
</head>
<body>
<header>
    <nav>
        <a class="logo" href="<?= app()->route->getUrl('/hello') ?>">МедицинSystem</a>
        <ul>
            <?php if (!app()->auth::check()): ?>
                <li>
                    <a href="<?= app()->route->getUrl('/login') ?>">Вход</a>
                </li>
            <?php else: ?>
                <li>
                    <a href="<?= app()->route->getUrl('/hello') ?>">Главная</a>
                </li>

                <?php if (app()->auth::user()->role === "user"): ?>
                <li>
                    <a href="<?= app()->route->getUrl('/patients') ?>">Пациенты</a>
                    </li>
                    <?php endif ?>
                <?php if (app()->auth::user()->role === 'admin'): ?>
                    <li>
                        <a href="<?= app()->route->getUrl('/signup') ?>">Регистрация сотрудника</a>
                    </li>
                <?php endif ?>
                <li>
                    <a href="<?= app()->route->getUrl('/logout') ?>">
                        Выход (<?= app()->auth::user()->last_name ?> <?= app()->auth::user()->first_name ?>)
                    </a>
                </li>
            <?php
            endif;
            ?>
        </ul>
    </nav>
</header>
<main>
    <?= $content ?? '' ?>
</main>
<footer>
    <p>сделано сквозь боль</p>
</footer>
</body>
</html>
