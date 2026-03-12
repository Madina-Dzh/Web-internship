<?php
$mysql = new mysqli("localhost", "root", "", "internship");
$mysql->query("SET NAMES 'utf8'");

// Получаем параметр 'id' из URL
$id = isset($_GET['id']) ? $_GET['id'] : '';

// Название организации
$query = "SELECT O.title AS title, C.start_date AS Дата_начала, C.end_date AS Дата_конца
FROM contract_details D INNER JOIN contract C ON C.contract_code=D.contract_code INNER JOIN organization O ON O.organization_code = C.organization_code
WHERE D.contract_code = $id";
$result = $mysql->query($query);
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $organization = $row['title'];
    $startDAte = $row['Дата_начала'];
    $endDate = $row['Дата_конца'];
}
else {
    $row = $result->fetch_assoc();
    $organization = "";
    $startDate = "";
    $endDate = "";
}

// Сравниваем даты
if ($endDate >= date('Y-m-d')) {
    $status = "Действует"; // Контракт ещё действует
} else {
    $status = "Завершен";  // Контракт завершён
}

// Для таблицы
$query = "SELECT d.id AS Номер, c.Shifr_spec AS Шифр_спец, C.Nazvanie AS Специальность, C.Sokrashenie AS Сокр_спец, s.title AS Практика, d.shifr_gr AS Группа, d.quantity AS Количество, p.start_date AS Дата_начала, p.end_date AS Дата_конца, p.hours AS Часы FROM contract_details D INNER JOIN practice P ON P.practice_code = D.practice_code INNER JOIN subjects_in_cycle S ON S.id = P.subject_code INNER JOIN `group` G ON g.Shifr_gr = D.shifr_gr INNER JOIN speciality c ON C.Shifr_spec = G.Shifr_spec;";
$details = $mysql->query($query);
$row_cnt = $details->num_rows;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Детали договора</title>
    <link rel="stylesheet" href="./css/contract-details.css">
</head>
<body>
     <?php
        include 'includes/header.php';
    ?>
    <div class="container">
        <?php include 'includes/aside.php';?>
        <div class="main-wrapper">
            <div class="info-compact">
                <span class="info-item contract-num">Договор № <?php print(str_pad($id, 3, '0', STR_PAD_LEFT)) ?></span>
                <span class="info-item organization">Организация: <?php print($organization) ?></span>
                <span class="info-item start-date">Начало: <?php print(date('d.m.Y', strtotime($startDAte))) ?></span>
                <span class="info-item status status-<?php print(strtolower($status)) ?>">Статус: <?php print($status) ?></span>
            </div>

            <!-- Таблица договоров -->
            <div class="table-wrapper">
                <?php
echo "<table class='contracts-table'>
    <thead>
        <tr>
            <th class='radio'></th>
            <th>№ п/п</th>
            <th>Наименование компонента образовательной программы, при реализации которого организуется практическая подготовка</th>
            <th>Количество обучающихся, осваивающих соответствующий компонент образовательной программы</th>
            <th>Сроки органищации практической подготовки (в соответствии с календарным учебным графиком / с...по...)</th>
            <th>Объем времени, отводимый на реализацию компонента образовательной программы в форме практической подготовки (в академических часах)</th>
        </tr>
    </thead>";
while ($row = mysqli_fetch_array($details)) {
    print("<tr data-id='" . htmlspecialchars($row['Номер']) . "'>
              <td class='radio'><input type='radio' name='details'></td>
              <td>" . $row['Номер'] . "</td>
              <td>" . $row['Практика'] . "\n" . $row["Группа"] . "</td>
              <td>" . $row['Количество'] . "</td>
              <td>c " . date('d.m.Y', strtotime($row['Дата_начала'])) . " по " . date('d.m.Y', strtotime($row['Дата_конца'])) . "</td>
              <td>". $row['Часы'] ."
              </td>
          </tr>");
}
echo "</table>";
?>
                
            </div>

            <!-- Футер таблицы с кнопками и счётчиком -->
            <div class="table-footer">
                <div class="actions">
                    <button class="action-btn edit">Изменить дату</button>
                    <button class="action-btn add">Добавить группу</button>
                    <button class="action-btn edit">Изменить для группы</button>
                    <button class="action-btn delete">Удалить группу из договора</button>
                </div>
                <div class="record-count">Записей: <?php print($row_cnt) ?></div>
            </div>

        </div>
    </div>
    <?php
        include 'includes/footer.php';
    ?>
</body>
</html>