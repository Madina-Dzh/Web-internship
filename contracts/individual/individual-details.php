<?php
$mysql = new mysqli("localhost", "root", "", "internship");
$mysql->query("SET NAMES 'utf8'");

// Получаем параметр 'id' из URL
$id = isset($_GET['id']) ? $_GET['id'] : '';

// Получаем данные о договоре напрямую из таблицы contract (не зависит от наличия деталей)
$query = "SELECT C.contract_code AS Договор, O.title AS title, C.start_date AS Дата_начала, C.end_date AS Дата_конца
FROM contract C
LEFT JOIN organization O ON O.organization_code = C.organization_code
WHERE C.contract_code = " . $id;
$result = $mysql->query($query);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $organization = $row['title'] ?? "Организация не указана";
    $startDate = $row['Дата_начала'];
    $endDate = $row['Дата_конца'];
} else {
    // Если договор не найден вообще
    $organization = "Договор не найден";
    $startDate = "";
    $endDate = "";
}

// Сравниваем даты (с проверкой на пустоту)
if (!empty($endDate) && $endDate >= date('Y-m-d')) {
    $status = "Действует";
} else {
    $status = "Завершен";
}

// Для таблицы — теперь безопасно, даже если деталей нет
$query = "SELECT d.id AS Номер, d.Shifr_spec AS Шифр_спец, C.Sokrashenie AS Специальность, G.Shifr_gr, C.Sokrashenie AS Сокр_спец, s.title AS Практика, d.fio AS ФИО, p.start_date AS Дата_начала, p.end_date AS Дата_конца, R.contract_code AS Договор
FROM contract_details D
INNER JOIN contract R ON R.contract_code = D.contract_code
INNER JOIN practice P ON P.practice_code = D.practice_code
INNER JOIN subjects_in_cycle S ON S.id = P.subject_code
INNER JOIN speciality c ON C.Shifr_spec = d.Shifr_spec
INNER JOIN `group` G ON G.Shifr_spec = C.Shifr_spec
WHERE R.contract_code = " . $id . " group BY Номер";
$details = $mysql->query($query);
$row_cnt = $details ? $details->num_rows : 0;

require_once dirname(__DIR__, 2) . '/includes/config.php';
?>

<?php
$message = isset($_GET['message']) ? htmlspecialchars($_GET['message']) : '';
$messageType = isset($_GET['type']) ? htmlspecialchars($_GET['type']) : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Детали договора</title>
    <link rel="stylesheet" href="<?php echo CSS_URL; ?>contract-details.css">
</head>
<body>
      <?php include dirname(__DIR__, 2) . '/includes/header.php'; ?>
    <div class="container">
          <?php include dirname(__DIR__, 2) . '/includes/aside.php'; ?>
        <div class="main-wrapper">
            <div class="info-compact">
                <span class="info-item contract-num">Договор № <?php print(str_pad($id, 3, '0', STR_PAD_LEFT)) ?></span>
                <span class="info-item organization">Организация: <?php print($organization) ?></span>
                <span class="info-item start-date">Начало: <?php if (!empty($startDate)) print(date('d.m.Y', strtotime($startDate))); ?></span>
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
            <th>ФИО обучающихся</th>
            <th>Сроки организации практической подготовки (в соответствии с календарным учебным графиком / с...по...)</th>
        </tr>
    </thead>
    <tbody>";

if ($details && $row_cnt > 0) {
    $count = 1;
    while ($row = mysqli_fetch_array($details)) {
        print("<tr data-id='" . htmlspecialchars($row['Номер']) . "'>
                  <td class='radio'><input type='radio' name='details' value='" . (int)$row['Номер'] . "'></td>
                  <td>" . $count . "</td>
                  <td>" . htmlspecialchars($row['Практика']) . "\n" . htmlspecialchars($row["Специальность"]) . "</td>
                  <td>" . htmlspecialchars($row['ФИО']) . "</td>
                  <td>c " . date('d.m.Y', strtotime($row['Дата_начала'])) . " по " . date('d.m.Y', strtotime($row['Дата_конца'])) . "</td>
              </tr>");
        $count++;
    }
} else {
    // Если нет данных — выводим одну пустую строку
    print("<tr>
              <td class='radio'></td>
              <td colspan='4' style='text-align: center; color: #666;'>Данные отсутствуют</td>
          </tr>");
}

echo "</tbody></table>";
?>
            </div>

            <!-- Футер таблицы с кнопками и счётчиком -->
            <div class="table-footer">
                <div class="actions">
                    <button class="action-btn edit" onclick="window.location.href='./updateDate.php?id=<?php echo $id; ?>'">Изменить дату</button>
                    <button class="action-btn add" onclick="window.location.href='./planning-indDet.php?id=<?php echo $id; ?>'">Добавить студента</button>
                    <button class="action-btn delete" onclick="deleteStud()">Удалить студента из договора</button>
                </div>
                <div class="record-count">Записей: <?php print($row_cnt) ?></div>
            </div>
        </div>
    </div>
      <?php include dirname(__DIR__, 2) . '/includes/footer.php'; ?>

      <script>
        function deleteStud() {
    // Находим выбранную радиокнопку
    const selectedRadio = document.querySelector('input[name="details"]:checked');

    if (!selectedRadio) {
        alert('Пожалуйста, сначала выберите группу для удаления!');
        return false;
    }
    const selectesId = parseInt(selectedRadio.value);
    console.log('Выбран ID для удаления:', selectesId);

    // Проверка валидности ID
    if (isNaN(selectesId) || selectesId <= 0) {
        alert('Ошибка: некорректный ID группы');
        return false;
    }

    const confirmed = confirm('Вы уверены, что хотите удалить группу с ID ' + selectesId + '?');
    if (confirmed) {
       window.location.href = 'dell_indDet.php?id=' + selectesId + '&contract_id=<?php echo urlencode($id)?>';
    } else {
        console.log('Удаление отменено пользователем');
    }
}
      </script>
</body>
</html>