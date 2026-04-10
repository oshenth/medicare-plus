<?php
include 'db.php';

$id = intval($_POST['id'] ?? 0);

$stmt = $conn->prepare("DELETE FROM users WHERE id = ? AND role = 'patient'");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "Patient deleted successfully";
} else {
    echo "Error deleting patient";
}
?>