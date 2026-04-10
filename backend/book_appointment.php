<?php
include 'db.php';

header('Content-Type: application/json');

$patient_id = intval($_POST['patient_id'] ?? 0);
$doctor_id = intval($_POST['doctor_id'] ?? 0);
$date = trim($_POST['date'] ?? '');
$time = trim($_POST['time'] ?? '');

if ($patient_id <= 0 || $doctor_id <= 0 || $date === '' || $time === '') {
    echo json_encode([
        "status" => "error",
        "message" => "All fields are required."
    ]);
    exit;
}

try {
    $today = date('Y-m-d');

    if ($date < $today) {
        echo json_encode([
            "status" => "error",
            "message" => "Past dates are not allowed. Please select today or a future date."
        ]);
        exit;
    }

    $stmtPatient = $conn->prepare("SELECT id, role FROM users WHERE id = ?");
    $stmtPatient->bind_param("i", $patient_id);
    $stmtPatient->execute();
    $patientResult = $stmtPatient->get_result();

    if ($patientResult->num_rows === 0) {
        echo json_encode([
            "status" => "error",
            "message" => "Please login to book an appointment."
        ]);
        exit;
    }

    $patient = $patientResult->fetch_assoc();

    if ($patient['role'] !== 'patient') {
        echo json_encode([
            "status" => "error",
            "message" => "Only patients can book an appointment."
        ]);
        exit;
    }

    $stmtDoctor = $conn->prepare("SELECT id FROM users WHERE id = ? AND role = 'doctor'");
    $stmtDoctor->bind_param("i", $doctor_id);
    $stmtDoctor->execute();
    $doctorResult = $stmtDoctor->get_result();

    if ($doctorResult->num_rows === 0) {
        echo json_encode([
            "status" => "error",
            "message" => "Selected doctor is invalid."
        ]);
        exit;
    }

    $stmtCheck = $conn->prepare("SELECT id FROM appointments WHERE doctor_id = ? AND date = ? AND time = ?");
    $stmtCheck->bind_param("iss", $doctor_id, $date, $time);
    $stmtCheck->execute();
    $checkResult = $stmtCheck->get_result();

    if ($checkResult->num_rows > 0) {
        echo json_encode([
            "status" => "error",
            "message" => "The selected doctor is not available at the chosen date and time. Please select another slot."
        ]);
        exit;
    }

    $stmtInsert = $conn->prepare("INSERT INTO appointments (patient_id, doctor_id, date, time) VALUES (?, ?, ?, ?)");
    $stmtInsert->bind_param("iiss", $patient_id, $doctor_id, $date, $time);

    if ($stmtInsert->execute()) {
        echo json_encode([
            "status" => "success",
            "message" => "Appointment booked successfully."
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Failed to book appointment."
        ]);
    }

} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => "Server error: " . $e->getMessage()
    ]);
}
?>