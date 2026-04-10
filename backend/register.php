<?php
include 'db.php';

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');
$role = trim($_POST['role'] ?? '');

if ($name === '' || $email === '' || $password === '' || $role === '') {
    exit("All fields are required");
}

$stmtCheck = $conn->prepare("SELECT id FROM users WHERE email = ?");
$stmtCheck->bind_param("s", $email);
$stmtCheck->execute();
$resultCheck = $stmtCheck->get_result();

if ($resultCheck->num_rows > 0) {
    exit("This email is already registered. Please use a different email.");
}

$stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $name, $email, $password, $role);

if ($stmt->execute()) {
    echo "Registered successfully";
} else {
    echo "Error: " . $stmt->error;
}
?>