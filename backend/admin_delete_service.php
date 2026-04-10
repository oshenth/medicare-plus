<?php
include 'db.php';

$id = intval($_POST['id'] ?? 0);

$stmt = $conn->prepare("DELETE FROM services WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "Service deleted successfully";
} else {
    echo "Error deleting service";
}
?>