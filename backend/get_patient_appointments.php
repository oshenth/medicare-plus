<?php
include 'db.php';

header('Content-Type: application/json');

$patient_id = intval($_GET['patient_id'] ?? 0);

$stmt = $conn->prepare("
    SELECT 
        a.*,
        u.name AS doctor_name,
        CASE WHEN r.id IS NULL THEN 0 ELSE 1 END AS has_review
    FROM appointments a
    JOIN users u ON a.doctor_id = u.id
    LEFT JOIN reviews r ON a.id = r.appointment_id
    WHERE a.patient_id = ?
    ORDER BY a.date DESC, a.time DESC
");
$stmt->bind_param("i", $patient_id);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
?>