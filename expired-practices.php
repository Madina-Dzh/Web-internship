<?php 
    $mysql = new mysqli("localhost", "root", "", "internship");
    $mysql->query("SET NAMES 'utf8'");

    $query = "SELECT P.practice_code AS Номер, S.code AS Код_предмета, S.title AS Предмет, P.start_date AS Дата_начала, P.end_date AS Дата_конца, T.FIO AS Преподаватель
    FROM Practice P INNER JOIN Teacher T ON P.teacher = T.Tab_nom INNER JOIN subjects_in_cycle S ON S.id = P.subject_code
    WHERE Date(P.end_date) < CURDATE()";
    $activePractices = $mysql->query($query);
    $row_cnt = $activePractices->num_rows;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Архив</title>
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
                <a href="./active-practices.php" class="tab">Активные</a>
                <a href="./expired-practices.php" class="tab active">Архив</a>
                <a href="./planning-practices.php" class="tab">Планирование</a>
            </div>
            <!-- Фильтры -->
            <div class="filter-container">
                <label for="subject-filter">Предмет:</label>
                <input type="text" id="subject-filter" placeholder="Введите предмет">

                <div class="date-range-group">
                    <label for="start-date-from">Дата начала с:</label>
                    <input type="date" id="start-date-from">
                    <label for="start-date-to">до:</label>
                    <input type="date" id="start-date-to">
                </div>

                <div class="date-range-group">
                    <label for="end-date-from">Дата конца с:</label>
                    <input type="date" id="end-date-from">
                    <label for="end-date-to">до:</label>
                    <input type="date" id="end-date-to">
                </div>
            </div>

            <!-- Таблица договоров -->
            <div class="table-wrapper" style="height: 380px;">
                <?php
                    echo "<table class='contracts-table'><thead><tr>
                            <th>Номер</th>
                            <th>Код_предмета</th>
                            <th>Предмет</th>
                            <th>Дата_начала</th>
                            <th>Дата_конца</th>
                            <th>Преподаватель</th>
                        </tr></thead>";
                    while ($row = mysqli_fetch_array($activePractices)) {
                        print("<tr data-id='" . $row['Номер'] . "'><td>" . $row['Номер'] . "</td><td> " . $row['Код_предмета'] . "</td><td>" . $row['Предмет'] . "</td><td> " . date('d.m.Y', strtotime($row['Дата_начала']))  . "</td><td> " . date('d.m.Y', strtotime($row['Дата_конца']))  . "</td>
                            <td>" . $row['Преподаватель'] . "</td>");
                    }
                    echo "</table>"
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
        include 'includes/footer.php';
    ?>
</body>
</html>
