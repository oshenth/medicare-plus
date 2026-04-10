<?php
include 'db.php';

header('Content-Type: application/json');

$email = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');

$stmt = $conn->prepare("SELECT id, name, email, role FROM users WHERE email = ? AND password = ?");
$stmt->bind_param("ss", $email, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    echo json_encode([
        "status" => "success",
        "user" => $user
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid email or password"
    ]);
}
?>