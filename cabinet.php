<?php 
$mysql = new mysqli("localhost", "root", "", "internship");
$mysql->query("SET NAMES 'utf8'");

// Ведомости
$query = "SELECT I.internship_code AS Номер, S.FIO AS Студент, S.Shifr_gr AS Группа, O.title AS Организация, U.code AS Код_предмета, T.FIO AS Преподаватель, P.start_date AS Дата_начала, P.end_date AS Дата_окончания, I.assessment AS Оценка, I.internship_status AS Статус, I.note AS Заметки, I.report AS Отчёт FROM Internship I INNER JOIN Practice P ON P.practice_code = I.practice_code INNER JOIN Student S ON I.student_code = S.Nom_stud LEFT JOIN Organization O ON I.organization_code = O.organization_code INNER JOIN subjects_in_cycle U ON U.id = P.subject_code LEFT JOIN Teacher T ON P.teacher = T.Tab_nom;";
$resInternship = $mysql->query($query);  

// Организации
$query = "SELECT O.organization_code AS Номер, O.title AS Название, O.address AS Адрес, O.contact_person AS Контактное_лицо, O.phone_number AS Телефон, C.start_date AS Дата_начала, C.end_date AS Дата_конца, C.contract_code AS Контракт FROM Organization O LEFT JOIN Contract C ON C.organization_code = O.organization_code";
$resOrganization = $mysql->query($query);

// Образцовый отчёт
$query = "SELECT S.Shifr_gr AS Группа, B.code AS Практика, Round(avg(I.assessment), 2) AS Средняя_успеваемость FROM Student S INNER JOIN Internship I ON S.Nom_stud = I.student_code INNER JOIN Practice P ON P.practice_code = I.practice_code INNER JOIN subjects_in_cycle B ON B.id = P.subject_code WHERE I.assessment IS NOT NULL AND I.assessment <> 0 GROUP BY S.Shifr_gr, B.code";

// Выполняем запрос
$exampleRep = $mysql->query($query);

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
    <!-- <aside></aside>-->

    <div class="wrapper-work">

        <!-- Раздел ведомостей -->
        <div class="chapter">
            <h2>Ведомости</h2>
            <div class="work-panel-for-table">
                <div class="wrapper-filtres">
                    <h3>Фильтры</h3>
                    <div class="filtr">
                        <div class="left"><span>По имени студента</span></div>
                        <div class="right"><input type="text"></div>
                    </div>
                    <div class="filtr">
                        <div class="left"><span>По имени преподавателя</span></div>
                        <div class="right"><input type="text"></div>
                    </div>
                    <div class="filtr">
                        <div class="left"><span>По названию организации</span></div>
                        <div class="right"><input type="text"></div>
                    </div>
                    <div class="filtr">
                        <div class="left"><span>По коду практики</span></div>
                        <div class="right"><input type="text"></div>
                    </div>
                </div>
                
                <div class="button">
                    <button>Поиск</button>
                    <button>Изменить</button>
                    <button>Удалить</button>
                </div>
            </div>
            
            <div class="wrapper-table">
                <?php 
                echo "<table><tr><th>№</th><th>Студент</th><th>Группа</th><th>Организация</th><th>Практика</th><th>Статус</th><th>Оценка</th><th>Преподаватель</th><th>Отчёт</th><th>Статус</th></tr>";
                while ($row = mysqli_fetch_array($resInternship)) {
                    print("<tr><td>" . $row['Номер'] . "</td><td> " . $row['Студент'] ."</td><td> " . $row['Группа']  . "</td><td> " . $row['Организация']  . "</td><td> " . $row['Код_предмета']  . "</td><td> " . $row['Статус'] . "</td><td>". $row['Оценка'] . "</td><td>". $row['Преподаватель'] . "</td><td>". $row['Отчёт'] . "</td><td>". $row['Статус'] .  "</td></tr>");
                }
                echo "</table>";
                ?>
            </div>
        </div>
        <!-- Конец раздела ведомостей -->
        
        <hr><br>

        <!-- Раздел организаций -->
        <div class="chapter">
            <h2>Организации</h2>
            <div class="work-panel-for-table">
                <div class="wrapper-filtres">
                    <h3>Фильтры</h3>
                    <div class="filtr">
                        <div class="left"><span>По названию организации</span></div>
                        <div class="right"><input type="text"></div>
                    </div>
                    <div class="filtr">
                        <div class="left"><span>По адресу организации</span></div>
                        <div class="right"><input type="text"></div>
                    </div>
                    <div class="filtr">
                        <div class="left"><span>По имени представителя</span></div>
                        <div class="right"><input type="text"></div>
                    </div>
                    <div class="filtr">
                        <div class="left"><span>По номеру телефона</span></div>
                        <div class="right"><input type="text"></div>
                    </div>
                </div>
                
                <div class="button">
                    <button>Поиск</button>
                    <button>Изменить</button>
                    <button>Удалить</button>
                </div>
            </div>
            
            <div class="wrapper-table">
                <?php 
                echo "<table><tr><th>№</th><th>Название</th><th>Адрес</th><th>Представитель</th><th>Телефон</th></tr>";
                while ($row = mysqli_fetch_array($resOrganization)) {
                    print("<tr><td>" . $row['Номер'] . "</td><td> " . $row['Название'] ."</td><td> " . $row['Адрес']  . "</td><td> " . $row['Контактное_лицо']  . "</td><td> " . $row['Телефон']  .  "</td></tr>");
                }
                echo "</table>";
                ?>
            </div>
        </div>
        <!-- Конец раздела организаций -->

        <hr><br>

        <!-- Раздел отчётов -->
        <div class="chapter" id="rep-chapter">
            <h2>Отчёты</h2>
            <div class="report">
                <h3>Успеваемость групп по практикам</h3>
                    <div class="wrapper-table rep-table">
                        <?php 
                        echo "<table><tr><th>Группа</th><th>Практика</th><th>Средняя_успеваемость</th></tr>";
                        while ($row = mysqli_fetch_array($exampleRep)) {
                            print("<tr><td>" . $row['Группа'] . "</td><td> " . $row['Практика'] ."</td><td> " . $row['Средняя_успеваемость']  . "</td></tr>");
                        }
                        echo "</table>";
                        ?>
                    </div>
                    <div class="right">
                        <img src="report.php"/>
                    </div>
                
            </div>
        </div>
    </div>
</div>

    
</body>
</html>