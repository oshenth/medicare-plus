<?php
include 'db.php';

$name = trim($_POST['name'] ?? '');
$description = trim($_POST['description'] ?? '');

if ($name === '' || $description === '') {
    exit("All service fields are required");
}

$imagePath = null;

if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
    $fileName = time() . "_" . basename($_FILES['image']['name']);
    $targetPath = "uploads/services/" . $fileName;
    $fullPath = __DIR__ . "/" . $targetPath;

    if (move_uploaded_file($_FILES['image']['tmp_name'], $fullPath)) {
        $imagePath = $targetPath;
    }
}

$stmt = $conn->prepare("INSERT INTO services (name, description, image) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $name, $description, $imagePath);

if ($stmt->execute()) {
    echo "Service added successfully";
} else {
    echo "Error: " . $stmt->error;
}
?>