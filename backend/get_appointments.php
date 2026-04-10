<?php
include 'db.php';

header('Content-Type: application/json');

$doctor_id = intval($_GET['doctor_id'] ?? 0);

if ($doctor_id > 0) {
    $stmt = $conn->prepare("SELECT a.*, u.name AS patient_name
                            FROM appointments a
                            JOIN users u ON a.patient_id = u.id
                            WHERE a.doctor_id = ?
                            ORDER BY a.date DESC, a.time DESC");
    $stmt->bind_param("i", $doctor_id);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query("SELECT * FROM appointments ORDER BY date DESC, time DESC");
}

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
?>