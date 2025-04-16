<?php
header('Content-Type: text/plain; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nurse_id = $_POST['nurse_id'] ?? '—';
    $ward_id = $_POST['ward_id'] ?? '—';
    $shift = $_POST['shift'] ?? '—';

    echo "Результати у форматі TXT:\n";
    echo "Медсестра ID: $nurse_id\n";
    echo "Палата ID: $ward_id\n";
    echo "Зміна: $shift\n";
} else {
    echo "Метод не підтримується.";
}
