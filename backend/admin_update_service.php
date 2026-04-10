<?php
include 'db.php';

$id = intval($_POST['id'] ?? 0);
$name = trim($_POST['name'] ?? '');
$description = trim($_POST['description'] ?? '');

if ($id <= 0 || $name === '' || $description === '') {
    exit("Invalid service data");
}

if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
    $fileName = time() . "_" . basename($_FILES['image']['name']);
    $targetPath = "uploads/services/" . $fileName;
    $fullPath = __DIR__ . "/" . $targetPath;

    if (move_uploaded_file($_FILES['image']['tmp_name'], $fullPath)) {
        $stmt = $conn->prepare("UPDATE services SET name = ?, description = ?, image = ? WHERE id = ?");
        $stmt->bind_param("sssi", $name, $description, $targetPath, $id);
    } else {
        exit("Image upload failed");
    }
} else {
    $stmt = $conn->prepare("UPDATE services SET name = ?, description = ? WHERE id = ?");
    $stmt->bind_param("ssi", $name, $description, $id);
}

if ($stmt->execute()) {
    echo "Service updated successfully";
} else {
    echo "Error updating service";
}
?>