<?php
include 'db.php';

$user_id = intval($_POST['user_id'] ?? 0);

$stmt = $conn->prepare("DELETE FROM users WHERE id = ? AND role = 'doctor'");
$stmt->bind_param("i", $user_id);

if ($stmt->execute()) {
    echo "Doctor deleted successfully";
} else {
    echo "Error deleting doctor";
}
?>