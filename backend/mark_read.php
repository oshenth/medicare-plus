<?php
include 'db.php';

header('Content-Type: application/json; charset=utf-8');

$user1 = intval($_GET['user1'] ?? 0);
$user2 = intval($_GET['user2'] ?? 0);

if ($user1 <= 0 || $user2 <= 0) {
    echo json_encode([]);
    exit;
}

try {
    $stmt = $conn->prepare("
        SELECT m.*, s.name AS sender_name, r.name AS receiver_name
        FROM messages m
        JOIN users s ON m.sender_id = s.id
        JOIN users r ON m.receiver_id = r.id
        WHERE (m.sender_id = ? AND m.receiver_id = ?)
           OR (m.sender_id = ? AND m.receiver_id = ?)
        ORDER BY m.sent_at ASC
    ");
    $stmt->bind_param("iiii", $user1, $user2, $user2, $user1);
    $stmt->execute();
    $result = $stmt->get_result();

    $messages = [];
    while ($row = $result->fetch_assoc()) {
        $messages[] = $row;
    }

    echo json_encode($messages);

} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}
?>