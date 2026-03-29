<?php

$mysql = new mysqli("localhost", "root", "", "internship");
$mysql->query("SET NAMES 'utf8'");

// Получаем параметр 'id' из URL
$id = isset($_GET['id']) ? $_GET['id'] : '';

// Название организации
$query = "SELECT C.contract_code AS Договор, O.title AS title, C.start_date AS Дата_начала, C.end_date AS Дата_конца
FROM contract C INNER JOIN organization O ON O.organization_code = C.organization_code
WHERE C.contract_code = " . $id;
$result = $mysql->query($query);
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $organization = $row['title'];
    $startDAte = $row['Дата_начала'];
    $endDate = $row['Дата_конца'];
}
else {
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
$query = "SELECT d.id AS Номер, d.Shifr_spec AS Шифр_спец, C.Nazvanie AS Специальность, C.Sokrashenie AS Сокр_спец, s.title AS Практика, g.shifr_gr AS Группа, d.quantity AS Количество, p.start_date AS Дата_начала, p.end_date AS Дата_конца, R.contract_code AS Договор, P.practice_code AS код_практики
FROM contract_details D INNER JOIN speciality C ON c.Shifr_spec=d.Shifr_spec INNER JOIN practice P ON P.practice_code = d.practice_code INNER JOIN subjects_in_cycle S ON S.id = P.subject_code INNER JOIN contract R ON R.contract_code = D.contract_code INNER JOIN `group` G ON G.Shifr_spec = C.Shifr_spec 
WHERE R.contract_code = " . $id;
$details = $mysql->query($query);
$row_cnt = $details->num_rows;

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
    <?php include dirname(__DIR__, 2) . '/includes/header.php';?>
    <div class="container">
        <?php include dirname(__DIR__, 2) . '/includes/aside.php'; ?>
        <div class="main-wrapper">
            
            <?php if ($message): ?>
                <div style="padding: 10px; margin: 15px 0; border-radius: 4px; <?php
                    echo $messageType === 'success' ?
                        'background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb;' :
                        'background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb;';
                ?>">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <div class="info-compact">
                <span class="info-item contract-num">Договор № <?php print(str_pad($id, 3, '0', STR_PAD_LEFT)) ?></span>
                <span class="info-item organization">Организация: <?php print($organization) ?></span>
                <span class="info-item start-date">Начало: <?php print(date( 'd.m.Y', strtotime($startDAte))) ?></span>
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
            <th>Сроки организации практической подготовки (в соответствии с календарным учебным графиком / с...по...)</th>
        </tr>
    </thead>
    <tbody>";


if ($details && $row_cnt > 0) {
    $count = 1;
    while ($row = mysqli_fetch_array($details)) {
        print("<tr data-id='" . htmlspecialchars($row['Номер']) . "'>
                  <td class='radio'>
                      <input type='radio' name='selected_group' value='" . (int)$row['Номер'] . "'>
                      <input type='hidden' name='practice_code' value='" . htmlspecialchars($row['код_практики']) . "'>
                  </td>
                  <td>" . $count . "</td>
                  <td>" . htmlspecialchars($row['Практика']) . "\n" . htmlspecialchars($row["Группа"]) . "</td>
                  <td>" . htmlspecialchars($row['Количество']) . "</td>
                  <td>c " . date('d.m.Y', strtotime($row['Дата_начала'])) . " по " . date('d.m.Y', strtotime($row['Дата_конца'])) . "</td>
              </tr>");
        $count++;
    }
} else {
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
                    <button class="action-btn edit">Изменить дату</button>
                    <button class="action-btn add" onclick="window.location.href='./planning-collDet.php?id=<?php echo $id; ?>'">Добавить группу</button>
                    <button class="action-btn edit" onclick="editGroup(<?php print($id) ?>)">Изменить для группы</button>
                    <button class="action-btn delete" onclick="deleteGroup()">Удалить группу из договора</button>
                </div>
                <div class="record-count">Записей: <?php print($row_cnt) ?></div>
            </div>
        </div>
    </div>
    <?php include dirname(__DIR__, 2) . '/includes/footer.php'; ?>

<script>
function deleteGroup() {
    // Находим выбранную радиокнопку
    const selectedRadio = document.querySelector('input[name="selected_group"]:checked');

    if (!selectedRadio) {
        alert('Пожалуйста, сначала выберите группу для удаления!');
        return false;
    }

    const groupId = parseInt(selectedRadio.value);
    console.log('Выбран ID для удаления:', groupId);

    // Проверка валидности ID
    if (isNaN(groupId) || groupId <= 0) {
        alert('Ошибка: некорректный ID группы');
        return false;
    }

    const confirmed = confirm('Вы уверены, что хотите удалить группу с ID ' + groupId + '?');
    if (confirmed) {
        window.location.href = 'dell_collDet.php?id=' + groupId + '&contract_id=<?php echo urlencode($id); ?>';
    } else {
        console.log('Удаление отменено пользователем');
    }
}

function editGroup( id) {
    // Находим выбранную радиокнопку
    const selectedRadio = document.querySelector('input[name="selected_group"]:checked');
    const contractcode = id

    if (!selectedRadio) {
        alert('Пожалуйста, сначала выберите группу для редактирования!');
        return false;
    }

    const groupId = parseInt(selectedRadio.value);
    console.log('Выбран ID для редактирования:', groupId);

    // Проверка валидности ID
    if (isNaN(groupId) || groupId <= 0) {
        alert('Ошибка: некорректный ID группы');
        return false;
    }

    // Получаем строку таблицы, содержащую выбранные данные
    const row = selectedRadio.closest('tr');

    // Извлекаем код практики из скрытого поля
    const practiceCode = row.querySelector('input[name="practice_code"]').value;

    // Остальные данные извлекаем из видимых ячеек
    const group = row.querySelector('td:nth-child(3)').textContent.split('\n')[1];
    const quantity = row.querySelector('td:nth-child(4)').textContent;

    // Формируем URL с параметрами (передаём код практики)
    const url = `update_collDetForm.php?contract_id=${parseInt(contractcode)}&groupId=${encodeURIComponent(groupId)}&practice_code=${encodeURIComponent(practiceCode)}&group=${encodeURIComponent(group)}&quantity=${encodeURIComponent(quantity)}`;

    // Переходим на страницу редактирования
    window.location.href = url;
}

</script>
</body>
</html>