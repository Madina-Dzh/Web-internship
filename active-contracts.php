<?php 
    $mysql = new mysqli("localhost", "root", "", "internship");
    $mysql->query("SET NAMES 'utf8'");

    $query = "SELECT C.contract_code AS Номер, O.title AS Организация, C.start_date AS Дата_начала, C.end_date AS Дата_конца
    FROM Organization O INNER JOIN Contract C ON C.organization_code = O.organization_code
    WHERE Date(C.end_date) > CURDATE()";

    $activeContract = $mysql->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Главная страница</title>
    <link rel="stylesheet" href="./css/contracts.css">
</head>
<body class="site">
    <?php
        include 'includes/header.php';
    ?>
    <div class="container">
        <?php include 'includes/aside.php'; ?>
        <div class="main-wrapper">
            <!-- Вкладки -->
            <div class="tabs">
                <a href="./active-contracts.php" class="tab active">Активные</a>
                <a href="#expired.html" class="tab">Истекшие</a>
                <a href="#drafts.html" class="tab">Черновики</a>
            </div>

            <!-- Таблица договоров -->
            <div class="table-wrapper">
                <?php
                    echo "<table class='contracts-table'><thead><tr>
                            <th class='radio'></th>
                            <th>Номер</th>
                            <th>Организация</th>
                            <th>Дата начала</th>
                            <th>Дата конца</th>
                            <th>Действия</th>
                        </tr></thead>";
                    while ($row = mysqli_fetch_array($activeContract)) {
                        print("<tr><td class='radio'><input type='radio' name='groupContract'></td><td>" . $row['Номер'] . "</td><td> " . $row['Организация'] ."</td><td> " . date('d.m.Y', strtotime($row['Дата_начала']))  . "</td><td> " . date('d.m.Y', strtotime($row['Дата_конца']))  . "</td>
                            <td><button class='details-btn' onclick='goToDetails('001')'>Детали</button></td>");
                    }
                    echo "</table>"
                ?>
                
            </div>

            <!-- Футер таблицы с кнопками и счётчиком -->
            <div class="table-footer">
                <div class="actions">
                    <button class="action-btn delete">Удалить договор</button>
                    <button class="action-btn add">Добавить договор с организацией</button>
                    <button class="action-btn edit">Изменить договор</button>
                </div>
                <div class="record-count">Записей: 9</div>
            </div>
        </div>
    </div>
    <?php
        include 'includes/footer.php';
    ?>
</body>
</html>
