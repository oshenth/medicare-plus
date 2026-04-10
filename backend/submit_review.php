<?php
include 'db.php';

header('Content-Type: application/json');

$appointment_id = intval($_POST['appointment_id'] ?? 0);
$patient_id = intval($_POST['patient_id'] ?? 0);
$doctor_id = intval($_POST['doctor_id'] ?? 0);
$rating = intval($_POST['rating'] ?? 0);
$comment = trim($_POST['comment'] ?? '');

if ($appointment_id <= 0 || $patient_id <= 0 || $doctor_id <= 0 || $rating < 1 || $rating > 5) {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid review data."
    ]);
    exit;
}

try {
    $stmtCheck = $conn->prepare("SELECT id FROM appointments WHERE id = ? AND patient_id = ? AND doctor_id = ?");
    $stmtCheck->bind_param("iii", $appointment_id, $patient_id, $doctor_id);
    $stmtCheck->execute();
    $checkResult = $stmtCheck->get_result();

    if ($checkResult->num_rows === 0) {
        echo json_encode([
            "status" => "error",
            "message" => "Appointment not found."
        ]);
        exit;
    }

    $stmtExists = $conn->prepare("SELECT id FROM reviews WHERE appointment_id = ?");
    $stmtExists->bind_param("i", $appointment_id);
    $stmtExists->execute();
    $existsResult = $stmtExists->get_result();

    if ($existsResult->num_rows > 0) {
        echo json_encode([
            "status" => "error",
            "message" => "Feedback has already been submitted for this appointment."
        ]);
        exit;
    }

    $stmtInsert = $conn->prepare("INSERT INTO reviews (appointment_id, patient_id, doctor_id, rating, comment) VALUES (?, ?, ?, ?, ?)");
    $stmtInsert->bind_param("iiiis", $appointment_id, $patient_id, $doctor_id, $rating, $comment);

    if ($stmtInsert->execute()) {
        echo json_encode([
            "status" => "success",
            "message" => "Feedback submitted successfully."
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Failed to submit feedback."
        ]);
    }

} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => "Server error: " . $e->getMessage()
    ]);
}
?>