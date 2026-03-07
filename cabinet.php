<?php 
$mysql = new mysqli("localhost", "root", "", "internship");
$mysql->query("SET NAMES 'utf8'");

// Договора
$query = "SELECT C.contract_code AS Номер, O.title AS Организация, C.start_date AS Дата_начала, C.end_date AS Дата_конца
FROM Organization O INNER JOIN Contract C ON C.organization_code = O.organization_code";

$resContract = $mysql->query($query);

// Организации
$query = "SELECT O.organization_code AS Номер, O.title AS Название, O.address AS Адрес, O.contact_person AS Контактное_лицо, O.phone_number AS Телефон, C.start_date AS Дата_начала, C.end_date AS Дата_конца, C.contract_code AS Контракт FROM Organization O LEFT JOIN Contract C ON C.organization_code = O.organization_code";
$resOrganization = $mysql->query($query);

$query = "SELECT P.practice_code AS Номер, S.code AS Код_предмета, S.title AS Предмет, P.start_date AS Дата_начала, P.end_date AS Дата_конца, T.FIO AS Преподаватель
FROM Practice P INNER JOIN Teacher T ON P.teacher = T.Tab_nom INNER JOIN subjects_in_cycle S ON S.id = P.subject_code";

$practices = $mysql->query($query);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Личный кабинет</title>
    <link rel="stylesheet" href="./cabinet.css">
</head>
<body class="cab-site site">
    <?php 
        include 'header.php';
    ?>
    <div class="cabinet">
    <aside>
        <h2>Навигация</h2>
        <a href="#organization">Организации</a>
        <a href="#practics">Практики</a>
        <br>
        <a href="#top">Наверх</a>
    </aside>

    <div class="wrapper-work">

        <!-- Раздел Договоров -->
        <div class="chapter" id="organization">
            <h2>Договора</h2>
            <div class="work-panel-for-table">
                <div class="wrapper-filtres">
                    <h3>Фильтры</h3>
                    <div class="filtr">
                        <div class="left"><span>По номеру</span></div>
                        <div class="right"><input type="text"></div>
                    </div>
                    <div class="filtr">
                        <div class="left"><span>По организации</span></div>
                        <div class="right"><input type="text"></div>
                    </div>
                    <div class="filtr">
                        <div class="left"><span>По статусу</span></div>
                        <div class="right"><input type="text"></div>
                    </div>
                </div>
                
                <div class="button">
                    <button>Поиск</button>
                    <button>Добавить</button>
                    <button>Изменить</button>
                </div>
            </div>
            
            <div class="wrapper-table">
                <?php 
                echo "<table><tr><th></th><th>№</th><th>Организация</th><th>Начало</th><th>Конец</th></tr>";
                while ($row = mysqli_fetch_array($resContract)) {
                    print("<tr><td><input type='radio' name='groupContract'></td><td>" . $row['Номер'] . "</td><td> " . $row['Организация'] ."</td><td> " . $row['Дата_начала']  . "</td><td> " . $row['Дата_конца']  . "</td></tr>");
                }
                echo "</table>";
                ?>
            </div>
        </div>
        <!-- Конец раздела организаций -->

        <!-- Раздел организаций -->
        <div class="chapter" id="organization">
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
                echo "<table><tr><th></th><th>№</th><th>Название</th><th>Адрес</th><th>Представитель</th><th>Телефон</th><th>Договор</th></tr>";
                while ($row = mysqli_fetch_array($resOrganization)) {
                    if ($row['Контракт'] != "") $tdContract = "Есть";
                    else $tdContract = "Нет";
                    print("<tr><td><input type='radio' name='groupOrg'></td><td>" . $row['Номер'] . "</td><td> " . $row['Название'] ."</td><td> " . $row['Адрес']  . "</td><td> " . $row['Контактное_лицо']  . "</td><td> " . $row['Телефон']  . "</th><td>" . $tdContract .  "</td></tr>");
                }
                echo "</table>";
                ?>
            </div>
        </div>
        <!-- Конец раздела организаций -->

        <hr><br>

        <!-- Раздел Практик -->
        <div class="chapter" id="practics">
            <h2>Практики</h2>
            <div class="work-panel-for-table">
                <div class="wrapper-filtres">
                    <h3>Фильтры</h3>
                    <div class="filtr">
                        <div class="left"><span>По предмету</span></div>
                        <div class="right"><input type="text"></div>
                    </div>
                    <div class="filtr">
                        <div class="left"><span>По преподавателю</span></div>
                        <div class="right"><input type="text"></div>
                    </div>
                    <div class="filtr">
                        <div class="left"><span>По дате в периоде</span></div>
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
                echo "<table><tr><th></th><th>№</th><th>Предмет</th><th>Начало</th><th>Конец</th><th>Преподаватель</th></tr>";
                while ($row = mysqli_fetch_array($practices)) {
                    print("<tr><td><input type='radio' name='groupPractic'/></td><td>" . $row['Номер'] . "</td><td> " . $row['Код_предмета'] ." - " . $row['Предмет'] . "</td><td> " . $row['Дата_начала']  . "</td><td> " . $row['Дата_конца']  . "</td><td> " . $row['Преподаватель']  .  "</td></tr>");
                }
                echo "</table>";
                ?>
            </div>
        </div>
        <!-- Конец практик -->

        <hr><br>
    </div>
</div>

    
</body>
</html>