<?php
    include 'db_connect.php';

    header('Content-Type: application/json');

    $response = [];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nurse_id = $_POST['nurse_id'];
        $ward_id = $_POST['ward_id'];
        $shift = $_POST['shift'];

        // палати, де чергує обрана медсестра
        $stmt_ward_nurse = $pdo->prepare("SELECT ward.name FROM ward
                                        JOIN nurse_ward ON ward.id_ward = nurse_ward.fid_ward
                                        WHERE nurse_ward.fid_nurse = :nurse_id");
        $stmt_ward_nurse->execute(['nurse_id' => $nurse_id]);
        $response['wards_for_nurse'] = $stmt_ward_nurse->fetchAll(PDO::FETCH_ASSOC);

        // медсестри обраного відділення
        $stmt_nurses_in_department = $pdo->prepare("SELECT nurse.name FROM nurse
                                                    WHERE nurse.department = (SELECT department FROM nurse WHERE id_nurse = :nurse_id)");
        $stmt_nurses_in_department->execute(['nurse_id' => $nurse_id]);
        $response['nurses_in_department'] = $stmt_nurses_in_department->fetchAll(PDO::FETCH_ASSOC);

        // чергування в обрану зміну
        $stmt_shifts = $pdo->prepare("SELECT nurse.name, ward.name AS ward_name FROM nurse
                                    JOIN nurse_ward ON nurse_ward.fid_nurse = nurse.id_nurse
                                    JOIN ward ON nurse_ward.fid_ward = ward.id_ward
                                    WHERE nurse.shift = :shift");
        $stmt_shifts->execute(['shift' => $shift]);
        $response['shifts'] = $stmt_shifts->fetchAll(PDO::FETCH_ASSOC);
    } else {
        http_response_code(405);
        $response['error'] = 'Invalid request method';
    }

    echo json_encode($response);
?>
