<?php 
    $mysql = new mysqli("localhost", "root", "", "internship");
    $mysql->query("SET NAMES 'utf8'");

    $query = "SELECT G.Shifr_gr AS Группа, G.Shifr_spec AS Специальность, G.God_post AS Год_поступления, G.God_okon AS Год_окончания, T.fio AS Куратор, G.`Kol-vo_stud` AS Количество_студентов 
FROM `group` G LEFT JOIN teacher T ON G.Tab_nom = T.Tab_nom";
    $resGroup = $mysql->query($query);
    $row_cnt = $resGroup->num_rows;

    require_once dirname(__DIR__) . '/includes/config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Группы</title>
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
                <a href="<?php echo REFERENCES_URL; ?>organizations.php" class="tab">Организации</a>
                <a href="<?php echo REFERENCES_URL; ?>groups.php" class="tab active">Группы</a>
                <a href="<?php echo REFERENCES_URL; ?>specialities.php" class="tab">Специальности</a>
            </div>

            <!-- Фильтры -->
            <div class="filter-container">
                <label for="subject-filter">Название:</label>
                <input type="text" id="subject-filter" placeholder="Введите название">

                <label for="subject-filter">Договор:</label>
                <input type="text" id="subject-filter" placeholder="Есть/Нет">
            </div>

            <div class="table-wrapper" style="height: 380px;">
                <?php 
                echo "<table class='contracts-table'><tr><th>Группа</th><th>Специальность</th><th>Год_поступления</th><th>Год_окончания</th><th>Куратор</th><th>Количество_студентов</th></tr>";
                while ($row = mysqli_fetch_array($resGroup)) {
                    if(!$row['Куратор']) $row['Куратор'] = "-";
                    print("<tr><td>" . $row['Группа'] . "</td><td> " . $row['Специальность'] ."</td><td> " . $row['Год_поступления']  . "</td><td> " . $row['Год_окончания']  . "</td><td> " . $row['Куратор']  . "</td><td>" . $row['Количество_студентов'] .  "</td></tr>");
                    
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
