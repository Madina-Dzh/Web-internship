<?php
header('Content-Type: text/html; charset=utf-8');

$mysql = new mysqli("localhost", "root", "", "internship");
$mysql->query("SET NAMES 'utf8'");

$id = isset($_POST['id']) ? $_POST['id'] : null;
$practice_code = isset($_POST['practice_code']) ? $_POST['practice_code'] : null;
$quantity = isset($_POST['quantity']) ? $_POST['quantity'] : null;
$group = isset($_POST['group']) ? $_POST['group'] : null;

// УБРАТЬ ВСЕ echo ПЕРЕД header()

$id_safe = $mysql->real_escape_string($id);
$practice_code_safe = $mysql->real_escape_string($practice_code);
$quantity_safe = $mysql->real_escape_string($quantity);
$group_safe = $mysql->real_escape_string($group);

$getSpecQuery = "SELECT G.Shifr_gr, G.Shifr_spec
                  FROM `group` G
                  INNER JOIN speciality S ON S.Shifr_spec = G.Shifr_spec
                  WHERE G.Shifr_gr = '$group_safe'";
$specResult = $mysql->query($getSpecQuery);

if (!$specResult) {
    // Логируем ошибку, но не выводим в браузер
    error_log("Ошибка при получении специальности для группы: " . $mysql->error);
    exit;
}

if ($specResult->num_rows == 0) {
    // Аналогично — логируем, не показываем пользователю
    error_log("Ошибка: группа '$group' не найдена в базе данных");
    exit;
}

$specRow = $specResult->fetch_assoc();
$shifr_spec_safe = $mysql->real_escape_string($specRow['Shifr_spec']);

$query = "INSERT INTO `contract_details`
        (`contract_code`, `practice_code`, `shifr_gr`, `quantity`, `Shifr_spec`)
        VALUES ('$id_safe', '$practice_code_safe', '$group_safe', '$quantity_safe', '$shifr_spec_safe')";

// Проверяем статус контракта через JOIN с корректным условием
$checkQuery = "SELECT C.contract_code
              FROM contract_details C INNER JOIN practice P ON P.practice_code = C.practice_code
              WHERE P.end_date > CURRENT_DATE()
              AND C.contract_code = $id_safe
              LIMIT 1";

$result = $mysql->query($checkQuery);
if (!$result) {
    die("Ошибка SELECT: " . $mysql->error);
}

if ($result->num_rows > 0) {
    echo "Дата поздняя — активно\n";
    $updateQuery = "UPDATE `contract`
                  SET `status` = 'active'
                  WHERE contract_code = '$id_safe'";
    if (!$mysql->query($updateQuery)) {
        die("Ошибка UPDATE (active): " . $mysql->error);
    }
} else {
    echo "Дата неудачна — истекший\n";
    $updateQuery = "UPDATE `contract`
                  SET `status` = 'expired'
                  WHERE contract_code = '$id_safe'";
    if (!$mysql->query($updateQuery)) {
        die("Ошибка UPDATE (expired): " . $mysql->error);
    }
}

if ($mysql->query($query)) {
    header("Location: collective-details.php?id=$id"); // Используем Location вместо Refresh
    exit;
} else {
    error_log("Ошибка при добавлении записи: " . $mysql->error);
}
?>
