<?php
include 'db.php';

$id = intval($_POST['id'] ?? 0);
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');

$stmt = $conn->prepare("UPDATE users SET name = ?, email = ? WHERE id = ? AND role = 'patient'");
$stmt->bind_param("ssi", $name, $email, $id);

if ($stmt->execute()) {
    echo "Patient updated successfully";
} else {
    echo "Error updating patient";
}
?>