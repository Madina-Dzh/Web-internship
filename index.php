<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Главная страница</title>
    <link rel="stylesheet" href="./css/index.css">
</head>
<body class="site">
    <?php
        include 'includes/header.php';
    ?>
    <div class="container">
        <?php include 'includes/aside.php'; ?>
        <div class="main-wrapper">
            <div class="dashboard">
                <h1>Добрый день, Любовь Владимировна!</h1>

                <div class="stats-grid">
                    <div class="stat-card">
                        <h3>Активных договоров</h3>
                        <p class="stat-value">N</p>
                    </div>
                    <div class="stat-card">
                        <h3>Практик в текущем семестре</h3>
                        <p class="stat-value">M</p>
                    </div>
                    <div class="stat-card">
                        <h3>Договоров без деталей</h3>
                        <p class="stat-value">K</p>
                    </div>
                    <div class="stat-card">
                        <h3>Ближайшее событие</h3>
                        <p class="stat-value">Договор №001 истечёт 30.10.2026</p>
                    </div>
                </div>

                <div class="recent-actions">
                    <h2>Последние действия</h2>
                    <ul class="actions-list">
                        <li>Добавлен договор №005</li>
                        <li>Обновлено расписание практики №3</li>
                        <li>Назначена практика</li>
                        <li>Создан новый справочник организаций</li>
                        <li>Обновлены данные по группе ИТ-401</li>
                    </ul>
                </div>

                <div class="quick-actions">
                    <button class="btn btn-primary">Создать новый договор</button>
                    <button class="btn btn-secondary">Запланировать практику</button>
                    <button class="btn btn-outline">Проверить справочники</button>
                </div>
            </div>
        </div>
    </div>
    <?php
        include 'includes/footer.php';
    ?>
</body>
</html>
