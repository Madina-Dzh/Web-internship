<?php 

/*
+  название фильтра и поле разместить по разные стороны от родительского блока
+  блок с кнопками выровнять с блоком с фильтрами
3. Изменить стили, чтобы шапка таблицы оставалась видна при вертикальном скролинге
*/




$mysql = new mysqli("localhost", "root", "", "internship");
$mysql->query("SET NAMES 'utf8'");
$query = "SELECT I.internship_code AS Номер, S.FIO AS Студент, S.Shifr_gr AS Группа, O.title AS Организация, U.code AS Код_предмета, T.FIO AS Преподаватель, P.start_date AS Дата_начала, P.end_date AS Дата_окончания, I.assessment AS Оценка, I.internship_status AS Статус, I.note AS Заметки, I.report AS Отчёт FROM Internship I INNER JOIN Practice P ON P.practice_code = I.practice_code INNER JOIN Student S ON I.student_code = S.Nom_stud LEFT JOIN Organization O ON I.organization_code = O.organization_code INNER JOIN subjects_in_cycle U ON U.id = P.subject_code LEFT JOIN Teacher T ON P.teacher = T.Tab_nom;";
$res = $mysql->query($query);  
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Личный кабинет</title>
    <link rel="stylesheet" href="./cabinet.css">
</head>
<body class="site">
    <?php 
        include 'header.php';
    ?>
    <div class="cabinet">
        <aside>

        </aside>

        <div class="wrapper-work">
            <h2>Ведомости</h2>

            <div class="work-panel-for-table">
                <div class="wrapper-filtres">
                    <h3>Фильтры</h3>
                    <div class="filtr">
                        <div class="left">
                            <span>По имени студента</span>
                        </div>
                        <div class="right">
                            <input type="text">
                        </div>
                    </div>
                    <div class="filtr">
                        <div class="left">
                            <span>По имени преподавателя</span>
                        </div>
                        <div class="right">
                            <input type="text">
                        </div>
                    </div>
                    <div class="filtr">
                        <div class="left">
                            <span>По названию организации</span>
                        </div>
                        <div class="right">
                            <input type="text">
                        </div>
                    </div>
                    <div class="filtr">
                        <div class="left">
                            <span>По коду практики</span>
                        </div>
                        <div class="right">
                            <input type="text">
                        </div>
                    </div>
                </div>
                <div class="button">
                    <button>Поиск</button>
                    <Button>Изменить</Button>
                    <button>Удалить</button>
                </div>
            </div>
            
            <div class="wrapper-table">
                <?php 
                echo "<table><tr><th>№</th><th>Студент</th><th>Группа</th><th>Организация</th><th>Практика</th><th>Статус</th><th>Оценка</th><th>Преподаватель</th><th>Отчёт</th><th>Статус</th></tr>";
                while ($row = mysqli_fetch_array($res)) {
                    print("<tr><td>" . $row['Номер'] . "</td><td> " . $row['Студент'] ."</td><td> " . $row['Группа']  . "</td><td> " . $row['Организация']  . "</td><td> " . $row['Код_предмета']  . "</td><td> " . $row['Статус'] . "</th><td>". $row['Оценка'] . "</th><td>". $row['Преподаватель'] . "</th><td>". $row['Отчёт'] . "</th><td>". $row['Статус'] .  "<br>");
                }
                ?>
            </div>
        </div>
    </div>
    
</body>
</html>