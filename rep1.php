<?php
$mysql = new mysqli("localhost", "root", "", "internship");
$mysql->query("SET NAMES 'utf8'");

// SQL-запрос
$query = "
    SELECT S.Shifr_gr AS Группа, B.code AS Практика, ROUND(AVG(I.assessment), 2) AS Средняя_успеваемость
    FROM Student S
    INNER JOIN Internship I ON S.Nom_stud = I.student_code
    INNER JOIN Practice P ON P.practice_code = I.practice_code
    INNER JOIN subjects_in_cycle B ON B.id = P.subject_code
    WHERE I.assessment IS NOT NULL AND I.assessment <> 0
    GROUP BY S.Shifr_gr, B.code
";

// Выполнение запроса
$result = $mysql->query( $query);

// Сбор данных из запроса
$groups = [];          // Группы
$practices = [];       // Название практик
$averages = [];        // Средние оценки

while ( $row = $result->fetch_assoc()) {
    $groups[] = $row['Группа'];
    $practices[] = $row['Практика'];
    $averages[] = floatval( $row['Средняя_успеваемость']);
}

// Используем библиотеку jpgraph для визуализации
require_once('src/jpgraph.php');
require_once('src/jpgraph_bar.php');

// Размер графика
$graph = new Graph(400, 300);
$graph->SetScale("textlin", 2, 5);

// Стили графики
$graph->SetMarginColor("#F2F2F2");
$graph->SetFrame(true, '#DCDCDC', 1);

// Настройка заголовка и шрифтов
$graph->title->Set("Средняя успеваемость по практикам");

// Ось X и Y
$graph->xaxis->title->Set("Название практики");
$graph->yaxis->title->Set("Средний балл");

// ...

// Построение барчарта
$barplot = new BarPlot($averages);
$barplot->SetFillColor('#e87a7c');

// Подписи к каждому столбцу (названия практик)
$graph->xaxis->SetTickLabels($practices); // Здесь мы устанавливаем метки одной командой

// Легенда
$graph->legend->Pos(0.05, 0.95,"right", "bottom");

// Отображение графика
$graph->Add($barplot);

// ...

$graph->Stroke();
?>