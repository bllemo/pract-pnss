<h2><?= $message ?? ''; ?></h2>

<div class="possible-actions">
    <?php if (app()->auth::user()->role === "user"): ?>
        <a href="<?= app()->route->getUrl('/patients') ?>">Пациенты</a>
    <?php endif ?>
    <?php if (app()->auth::user()->role === 'admin'): ?>
        <a href="<?= app()->route->getUrl('/signup') ?>">Регистрация сотрудника</a>
        <a href="<?= app()->route->getUrl('/users') ?>">Сотрудники</a>
        <a href="<?= app()->route->getUrl('/doctors') ?>">Врачи</a>
        <a href="<?= app()->route->getUrl('/positions') ?>">Должности</a>
        <a href="<?= app()->route->getUrl('/specifications') ?>">Специализации</a>
    <?php endif ?>
    <a href="<?= app()->route->getUrl('/appointments') ?>">Записи</a>
</div>
