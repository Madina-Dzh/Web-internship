<?php 
    $mysql = new mysqli("localhost", "root", "", "internship");
    $mysql->query("SET NAMES 'utf8'");

    $query = "SELECT O.organization_code AS Номер, O.title AS Название, O.address AS Адрес, O.contact_person AS Контактное_лицо, O.phone_number AS Телефон, C.start_date AS Дата_начала, C.end_date AS Дата_конца, C.contract_code AS Контракт FROM Organization O LEFT JOIN Contract C ON C.organization_code = O.organization_code";
    $resOrganization = $mysql->query($query);
    $row_cnt = $resOrganization->num_rows;

    require_once dirname(__DIR__) . '/includes/config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Организации</title>
    <link rel="stylesheet" href="<?php echo CSS_URL; ?>contracts.css">
</head>
<body class="site">
    <?php
        include '../includes/header.php';
    ?>
    <div class="container">
        <?php include '../includes/aside.php'; ?>
        <div class="main-wrapper">
            <!-- Вкладки -->
            <div class="tabs">
                <a href="<?php echo REFERENCES_URL; ?>organizations.php" class="tab active">Организации</a>
                <a href="<?php echo REFERENCES_URL; ?>groups.php" class="tab">Группы</a>
                <a href="<?php echo REFERENCES_URL; ?>specialities.php" class="tab">Специальности</a>
            </div>

            <!-- Фильтры -->
            <div class="filter-container">
                <label for="subject-filter">Группа:</label>
                <input type="text" id="subject-filter" placeholder="Введите группу">

                <label for="subject-filter">Специальность:</label>
                <input type="text" id="subject-filter" placeholder="Введите специальность">

                <label for="subject-filter">Куратор:</label>
                <input type="text" id="subject-filter" placeholder="Введите ФИО">
            </div>

            <!-- Таблица договоров -->
            <div class="table-wrapper" style="height: 380px;">
                <?php 
                echo "<table class='contracts-table'><tr><th>№</th><th>Название</th><th>Адрес</th><th>Представитель</th><th>Телефон</th><th>Договор</th></tr>";
                while ($row = mysqli_fetch_array($resOrganization)) {
                    if ($row['Контракт'] != "") $tdContract = "Есть";
                    else $tdContract = "Нет";
                    print("<tr><td>" . $row['Номер'] . "</td><td> " . $row['Название'] ."</td><td> " . $row['Адрес']  . "</td><td> " . $row['Контактное_лицо']  . "</td><td> " . $row['Телефон']  . "</th><td>" . $tdContract .  "</td></tr>");
                }
                echo "</table>";
                ?>
            </div>

            <!-- Футер таблицы с кнопками и счётчиком -->
            <div class="table-footer">
                <div class="actions">
                    
                </div>
                <div class="record-count">Записей: 
                    <?php 
                        print($row_cnt); 
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php
        include '../includes/footer.php';
    ?>
</body>
</html>
