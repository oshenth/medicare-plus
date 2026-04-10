<?php
include 'db.php';

$doctor_profile_id = intval($_POST['doctor_profile_id'] ?? 0);
$user_id = intval($_POST['user_id'] ?? 0);
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$specialization = trim($_POST['specialization'] ?? '');
$experience = intval($_POST['experience'] ?? 0);
$fee = floatval($_POST['fee'] ?? 0);
$availability = trim($_POST['availability'] ?? '');

if ($doctor_profile_id <= 0 || $user_id <= 0) {
    exit("Invalid doctor data");
}

$conn->begin_transaction();

try {
    $stmt1 = $conn->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
    $stmt1->bind_param("ssi", $name, $email, $user_id);
    $stmt1->execute();

    $stmt2 = $conn->prepare("UPDATE doctors SET specialization = ?, experience = ?, fee = ?, availability = ? WHERE id = ? AND user_id = ?");
    $stmt2->bind_param("sidsii", $specialization, $experience, $fee, $availability, $doctor_profile_id, $user_id);
    $stmt2->execute();

    $conn->commit();
    echo "Doctor updated successfully";
} catch (Exception $e) {
    $conn->rollback();
    echo "Error: " . $e->getMessage();
}
?>