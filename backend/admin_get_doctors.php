<?php
include 'db.php';

header('Content-Type: application/json');

$sql = "SELECT d.id AS doctor_profile_id, d.user_id, u.name, u.email, d.specialization, d.experience, d.fee, d.availability
        FROM doctors d
        JOIN users u ON d.user_id = u.id
        ORDER BY d.id DESC";

$result = $conn->query($sql);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
?>