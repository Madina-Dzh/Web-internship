<?php 
    $mysql = new mysqli("localhost", "root", "", "internship");
    $mysql->query("SET NAMES 'utf8'");

    $query = "SELECT `Shifr_spec` AS Шифр, `Nazvanie` AS Название, `Sokrashenie` AS Сокращение, `Srok_obuch` AS Срок_обучение FROM `speciality`";
    $resSpec = $mysql->query($query);
    $row_cnt = $resSpec->num_rows;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Специальности</title>
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
                <a href="./organizations.php" class="tab">Организации</a>
                <a href="./groups.php" class="tab">Группы</a>
                <a href="./specialities.php" class="tab active">Специальности</a>
            </div>

            <!-- Фильтры -->
            <div class="filter-container">
                <label for="subject-filter">Шифр:</label>
                <input type="text" id="subject-filter" placeholder="Введите шифр">

                <label for="subject-filter">Сокращение:</label>
                <input type="text" id="subject-filter" placeholder="Введите Сокращение">
            </div>

            <!-- Таблица договоров -->
            <div class="table-wrapper" style="height: 380px;">
                <?php 
                echo "<table class='contracts-table'><tr><th>Шифр</th><th>Название</th><th>Сокращение</th><th>Срок_обучение</th></tr>";
                while ($row = mysqli_fetch_array($resSpec)) {
                    print("<tr><td>" . $row['Шифр'] . "</td><td> " . $row['Название'] ."</td><td> " . $row['Сокращение']  . "</td><td> " . $row['Срок_обучение'] . "</td></tr>");
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
        include 'includes/footer.php';
    ?>
</body>
</html>
