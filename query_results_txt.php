<?php
header('Content-Type: text/plain; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $nurse_id = $_GET['nurse_id'] ?? '—';
    $ward_id = $_GET['ward_id'] ?? '—';
    $shift = $_GET['shift'] ?? '—';

    echo "Результати у форматі TXT:\n";
    echo "Медсестра ID: $nurse_id\n";
    echo "Палата ID: $ward_id\n";
    echo "Зміна: $shift\n";
} else {
    echo "Метод не підтримується.";
}

