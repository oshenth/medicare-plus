<?php
include 'db.php';

header('Content-Type: application/json; charset=utf-8');

$sender_id = intval($_POST['sender_id'] ?? 0);
$receiver_id = intval($_POST['receiver_id'] ?? 0);
$message = trim($_POST['message'] ?? '');

if ($sender_id <= 0 || $receiver_id <= 0 || $message === '') {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid message data."
    ]);
    exit;
}

try {
    $stmtSender = $conn->prepare("SELECT id, role FROM users WHERE id = ?");
    $stmtSender->bind_param("i", $sender_id);
    $stmtSender->execute();
    $senderResult = $stmtSender->get_result();

    $stmtReceiver = $conn->prepare("SELECT id, role, name FROM users WHERE id = ?");
    $stmtReceiver->bind_param("i", $receiver_id);
    $stmtReceiver->execute();
    $receiverResult = $stmtReceiver->get_result();

    if ($senderResult->num_rows === 0 || $receiverResult->num_rows === 0) {
        echo json_encode([
            "status" => "error",
            "message" => "Invalid sender or receiver."
        ]);
        exit;
    }

    $sender = $senderResult->fetch_assoc();
    $receiver = $receiverResult->fetch_assoc();

    $allowed =
        ($sender['role'] === 'patient' && $receiver['role'] === 'doctor') ||
        ($sender['role'] === 'doctor' && $receiver['role'] === 'patient') ||
        ($sender['role'] === 'admin');

    if (!$allowed) {
        echo json_encode([
            "status" => "error",
            "message" => "Messaging is allowed only between doctors and patients."
        ]);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO messages (sender_id, receiver_id, message, is_read) VALUES (?, ?, ?, 0)");
    $stmt->bind_param("iis", $sender_id, $receiver_id, $message);

    if ($stmt->execute()) {
        echo json_encode([
            "status" => "success",
            "message" => "Message sent successfully."
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Failed to send message."
        ]);
    }

} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}
?>