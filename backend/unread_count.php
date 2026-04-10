<?php
include 'db.php';

header('Content-Type: application/json; charset=utf-8');

$sender_id = intval($_POST['sender_id'] ?? 0);
$receiver_id = intval($_POST['receiver_id'] ?? 0);

if ($sender_id <= 0 || $receiver_id <= 0) {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid data."
    ]);
    exit;
}

try {
    $stmt = $conn->prepare("UPDATE messages SET is_read = 1 WHERE sender_id = ? AND receiver_id = ?");
    $stmt->bind_param("ii", $sender_id, $receiver_id);
    $stmt->execute();

    echo json_encode([
        "status" => "success"
    ]);

} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}
?>