<?php
include 'db.php';

header('Content-Type: application/json');

$result = $conn->query("SELECT * FROM services ORDER BY id DESC");

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
?>