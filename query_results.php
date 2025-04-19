<?php
include 'db_connect.php';



if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $nurse_id = $_GET['nurse_id'];
    $ward_id = $_GET['ward_id'];
    $shift = $_GET['shift'];

    // палати, де чергує обрана медсестра
    $stmt_ward_nurse = $pdo->prepare("SELECT ward.name FROM ward
                                      JOIN nurse_ward ON ward.id_ward = nurse_ward.fid_ward
                                      WHERE nurse_ward.fid_nurse = :nurse_id");
    $stmt_ward_nurse->execute(['nurse_id' => $nurse_id]);
    $wards_for_nurse = $stmt_ward_nurse->fetchAll(PDO::FETCH_ASSOC);

    // медсестри обраного відділення
    $stmt_nurses_in_department = $pdo->prepare("SELECT nurse.name FROM nurse
                                                WHERE nurse.department = (SELECT department FROM nurse WHERE id_nurse = :nurse_id)");
    $stmt_nurses_in_department->execute(['nurse_id' => $nurse_id]);
    $nurses_in_department = $stmt_nurses_in_department->fetchAll(PDO::FETCH_ASSOC);

    // чергування в обрану зміну
    $stmt_shifts = $pdo->prepare("SELECT nurse.name, ward.name AS ward_name FROM nurse
                                  JOIN nurse_ward ON nurse_ward.fid_nurse = nurse.id_nurse
                                  JOIN ward ON nurse_ward.fid_ward = ward.id_ward
                                  WHERE nurse.shift = :shift");
    $stmt_shifts->execute(['shift' => $shift]);
    $shifts = $stmt_shifts->fetchAll(PDO::FETCH_ASSOC);
}

?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Результати запиту</title>
</head>
<body>
    <h1>Результати запиту</h1>

    <h2>Перелік палат, у яких чергує обрана медсестра:</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Назва палати</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($wards_for_nurse as $ward): ?>
                <tr>
                    <td><?= $ward['name'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2>Медсестри обраного відділення:</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Назва медсестри</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($nurses_in_department as $nurse): ?>
                <tr>
                    <td><?= $nurse['name'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2>Чергування в зазначену зміну:</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Медсестра</th>
                <th>Палата</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($shifts as $shift): ?>
                <tr>
                    <td><?= $shift['name'] ?></td>
                    <td><?= $shift['ward_name'] ?></td> <!-- Виведення правильного поля для назви палати -->
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>
</html>
