<?php 
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
            <?php ; 
                echo "<table><tr><th>Номер</th><th>Студент</th><th>Группа</th></tr>";
                while ($row = mysqli_fetch_array($res)) {
                    print("<tr><td>" . $row['Номер'] . "</td><td> " . $row['Студент'] ."</td><td> " . $row['Группа'] . "<br>");
                }
            ?>
        </div>
    </div>
    
</body>
</html>