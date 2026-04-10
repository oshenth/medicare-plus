<?php

include 'db.php';

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');
$specialization = trim($_POST['specialization'] ?? '');
$experience = intval($_POST['experience'] ?? 0);
$fee = floatval($_POST['fee'] ?? 0);
$availability = trim($_POST['availability'] ?? '');

if ($name === '' || $email === '' || $password === '' || $specialization === '' || $experience <= 0 || $fee <= 0 || $availability === '') {
    exit("All doctor fields are required");
}

$conn->begin_transaction();

try {
    $stmt1 = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'doctor')");
    $stmt1->bind_param("sss", $name, $email, $password);
    $stmt1->execute();

    $user_id = $conn->insert_id;

    $stmt2 = $conn->prepare("INSERT INTO doctors (user_id, specialization, experience, fee, availability) VALUES (?, ?, ?, ?, ?)");
    $stmt2->bind_param("isids", $user_id, $specialization, $experience, $fee, $availability);
    $stmt2->execute();

    $conn->commit();
    echo "Doctor added successfully";
} catch (Exception $e) {
    $conn->rollback();
    echo "Error: " . $e->getMessage();
}
?>