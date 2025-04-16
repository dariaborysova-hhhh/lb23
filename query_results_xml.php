<?php
include 'db_connect.php';

header('Content-Type: application/xml');

$xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><response></response>');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nurse_id = $_POST['nurse_id'];
    $ward_id = $_POST['ward_id'];
    $shift = $_POST['shift'];

    // Палати, де чергує обрана медсестра
    $stmt_ward_nurse = $pdo->prepare("SELECT ward.name FROM ward
                                      JOIN nurse_ward ON ward.id_ward = nurse_ward.fid_ward
                                      WHERE nurse_ward.fid_nurse = :nurse_id");
    $stmt_ward_nurse->execute(['nurse_id' => $nurse_id]);
    $wards = $stmt_ward_nurse->fetchAll(PDO::FETCH_ASSOC);

    $wards_xml = $xml->addChild('wards_for_nurse');
    foreach ($wards as $ward) {
        $wards_xml->addChild('ward', htmlspecialchars($ward['name']));
    }

    // Медсестри обраного відділення
    $stmt_nurses_in_department = $pdo->prepare("SELECT nurse.name FROM nurse
                                                WHERE nurse.department = (SELECT department FROM nurse WHERE id_nurse = :nurse_id)");
    $stmt_nurses_in_department->execute(['nurse_id' => $nurse_id]);
    $nurses = $stmt_nurses_in_department->fetchAll(PDO::FETCH_ASSOC);

    $nurses_xml = $xml->addChild('nurses_in_department');
    foreach ($nurses as $nurse) {
        $nurses_xml->addChild('nurse', htmlspecialchars($nurse['name']));
    }

    // Чергування в обрану зміну
    $stmt_shifts = $pdo->prepare("SELECT nurse.name, ward.name AS ward_name FROM nurse
                                  JOIN nurse_ward ON nurse_ward.fid_nurse = nurse.id_nurse
                                  JOIN ward ON nurse_ward.fid_ward = ward.id_ward
                                  WHERE nurse.shift = :shift");
    $stmt_shifts->execute(['shift' => $shift]);
    $shifts = $stmt_shifts->fetchAll(PDO::FETCH_ASSOC);

    $shifts_xml = $xml->addChild('shifts');
    foreach ($shifts as $shift) {
        $shift_xml = $shifts_xml->addChild('shift');
        $shift_xml->addChild('nurse', htmlspecialchars($shift['name']));
        $shift_xml->addChild('ward', htmlspecialchars($shift['ward_name']));
    }

} else {
    http_response_code(405);
    $xml->addChild('error', 'Invalid request method');
}

echo $xml->asXML();
?>
