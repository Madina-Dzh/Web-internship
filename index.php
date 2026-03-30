<?php
$mysql = new mysqli("localhost", "root", "", "internship");
    $mysql->query("SET NAMES 'utf8'");

    $query = "SELECT * FROM `contract` WHERE status = 'active'";
    $activeContracts = $mysql->query($query);
    $activeContracts_cnt = $activeContracts->num_rows;

    $query = "SELECT *
FROM practice
WHERE
  -- Практика начинается в текущем полугодии ИЛИ
  (start_date >= CASE
    WHEN MONTH(CURRENT_DATE) <= 6 THEN DATE_FORMAT(CURRENT_DATE, '%Y-01-01')
    ELSE DATE_FORMAT(CURRENT_DATE, '%Y-07-01')
  END
  AND start_date <= CASE
    WHEN MONTH(CURRENT_DATE) <= 6 THEN DATE_FORMAT(CURRENT_DATE, '%Y-06-30')
    ELSE DATE_FORMAT(CURRENT_DATE, '%Y-12-31')
  END)
  -- ИЛИ заканчивается в текущем полугодии
  OR (end_date >= CASE
    WHEN MONTH(CURRENT_DATE) <= 6 THEN DATE_FORMAT(CURRENT_DATE, '%Y-01-01')
    ELSE DATE_FORMAT(CURRENT_DATE, '%Y-07-01')
  END
  AND end_date <= CASE
    WHEN MONTH(CURRENT_DATE) <= 6 THEN DATE_FORMAT(CURRENT_DATE, '%Y-06-30')
    ELSE DATE_FORMAT(CURRENT_DATE, '%Y-12-31')
  END)
  -- ИЛИ полностью охватывает текущее полугодие
  OR (start_date < CASE
    WHEN MONTH(CURRENT_DATE) <= 6 THEN DATE_FORMAT(CURRENT_DATE, '%Y-01-01')
    ELSE DATE_FORMAT(CURRENT_DATE, '%Y-07-01')
  END
  AND end_date > CASE
    WHEN MONTH(CURRENT_DATE) <= 6 THEN DATE_FORMAT(CURRENT_DATE, '%Y-06-30')
    ELSE DATE_FORMAT(CURRENT_DATE, '%Y-12-31')
  END);";
  $actualPractice = $mysql->query($query);
    $actualPractice_cnt = $actualPractice->num_rows;

    $query = "SELECT * FROM `contract` WHERE `status`= 'draft'";
    $draftContacts = $mysql->query($query);
    $draftContacts_cnt = $draftContacts->num_rows;

    $query = "SELECT `contract_code`, `organization_code`, `start_date`, `end_date`, `status`, `type` 
FROM `contract`  
WHERE `end_date`>= CURRENT_DATE()
ORDER BY `end_date`
LIMIT 1";
    $upcomingIvent = $mysql->query($query);
?>
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
                        <p class="stat-value"><?php print($activeContracts_cnt) ?></p>
                    </div>
                    <div class="stat-card">
                        <h3>Практик в текущем семестре</h3>
                        <p class="stat-value"><?php print($actualPractice_cnt) ?></p>
                    </div>
                    <div class="stat-card">
                        <h3>Договоров без деталей</h3>
                        <p class="stat-value"><?php print($draftContacts_cnt) ?></p>
                    </div>
                    <div class="stat-card">
                        <h3>Ближайшее событие</h3>
                        <p class="stat-value">
                            <?php
                                while ($row = mysqli_fetch_array($upcomingIvent)) {
                                    print("Договор № " . str_pad($row['contract_code'], 3, '0', STR_PAD_LEFT) . " истечёт " . date('d.m.Y', strtotime($row['end_date'])));
                                }
                            ?>
                        </p>
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
