<?php
include 'db.php';

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');

if ($name === '' || $email === '' || $password === '') {
    exit("All patient fields are required");
}

$stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'patient')");
$stmt->bind_param("sss", $name, $email, $password);

if ($stmt->execute()) {
    echo "Patient added successfully";
} else {
    echo "Error: " . $stmt->error;
}
?>