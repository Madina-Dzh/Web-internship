<?php
$mysql = new mysqli("localhost", "root", "", "internship");
$mysql->query("SET NAMES 'utf8'");

$query = "SELECT O.title AS Организация, Count(I.student_code) AS Количество_студентов, Round(avg(I.assessment), 2) AS Средняя_оценка_практики
FROM Organization O INNER JOIN Internship I ON I.organization_code = O.organization_code
WHERE assessment IS NOT NULL AND assessment <> 0
GROUP BY Организация";

$result = $mysql->query( $query);

// Сбор данных из запроса
$orgs = [];          // Организации
$countStud = [];       // Количество студентов

while ( $row = $result->fetch_assoc()) {
    $orgs[] = $row['Организация'];
    $countStud[] = $row['Количество_студентов'];
}

foreach ($orgs as &$org) {
    if (mb_strimwidth($org, 0, 3) == "ООО" OR mb_strimwidth($org, 0, 3) == "ЗАО") {
        if (strlen($org) < 15)
            $org = mb_strimwidth($org, 4, 15).'...';
        else 
            $org = mb_strimwidth($org, 4, strlen($org));
    }
    else if (mb_strimwidth($org, 0, 2) == "ИП") {
        if (strlen($org) < 15)
            $org = mb_strimwidth($org, 3, 15).'...';
        else 
            $org = mb_strimwidth($org, 3, strlen($org));
    }
    else {
        $org = mb_strimwidth($org, 0, 8).'...';
    }
}


// Включаем необходимые классы JpGraph
require_once ('src/jpgraph.php');
require_once ('src/jpgraph_pie.php');

// Создаем объект PieGraph размером 400х300 пикселей
$graph = new PieGraph(400, 300);


// Заголовок графиков
$graph->title->Set("Распределение количества студентов по организациям");

// Создаем экземпляр PiePlot с количеством студентов
$pieplot = new PiePlot($countStud);

// Добавляем легенду и связываем её с данными
$pieplot->SetLegends($orgs);

// Центр круга смещается чуть левее, чтобы было удобно читать подписи
$pieplot->SetCenter(0.9, 0.5);


// Автоматически выставляем начальное положение секторов
$pieplot->SetStartAngle(15);

// Устанавливаем радиус круговой диаграммы
$pieplot->SetSize(0.2);


// Добавляем круговую диаграмму на холст
$graph->Add($pieplot);

// Отображаем график
$graph->Stroke();
?>
