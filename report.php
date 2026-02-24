<?php
            require_once ('src/jpgraph.php');
            require_once ('src/jpgraph_bar.php');

            // Пример данных
            $data = array(40, 60, 75, 80, 95);

            // Создать график
            $graph = new Graph(350, 250);
            $graph->SetScale("textlin");

            // Создать столбчатую диаграмму
            $bplot = new BarPlot($data);
            $graph->Add($bplot);

            // Установить заголовки
            $graph->title->Set("Sales Performance");
            $graph->xaxis->title->Set("Product Categories");
            $graph->yaxis->title->Set("Sales (in thousands)");
            // Отобразить график
            $graph->Stroke();
?>