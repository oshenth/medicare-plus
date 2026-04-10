<?php
include 'db.php';

header('Content-Type: application/json; charset=utf-8');

$current_user_id = intval($_GET['current_user_id'] ?? 0);
$current_role = trim($_GET['current_role'] ?? '');

if ($current_user_id <= 0 || $current_role === '') {
    echo json_encode([]);
    exit;
}

try {
    if ($current_role === 'patient') {
        $stmt = $conn->prepare("
            SELECT u.id, u.name, u.role,
            (
                SELECT COUNT(*) 
                FROM messages m 
                WHERE m.sender_id = u.id 
                  AND m.receiver_id = ? 
                  AND m.is_read = 0
            ) AS unread_count
            FROM users u
            WHERE u.role = 'doctor'
            ORDER BY u.name ASC
        ");
        $stmt->bind_param("i", $current_user_id);
    } elseif ($current_role === 'doctor') {
        $stmt = $conn->prepare("
            SELECT u.id, u.name, u.role,
            (
                SELECT COUNT(*) 
                FROM messages m 
                WHERE m.sender_id = u.id 
                  AND m.receiver_id = ? 
                  AND m.is_read = 0
            ) AS unread_count
            FROM users u
            WHERE u.role = 'patient'
            ORDER BY u.name ASC
        ");
        $stmt->bind_param("i", $current_user_id);
    } else {
        $stmt = $conn->prepare("
            SELECT u.id, u.name, u.role,
            (
                SELECT COUNT(*) 
                FROM messages m 
                WHERE m.sender_id = u.id 
                  AND m.receiver_id = ? 
                  AND m.is_read = 0
            ) AS unread_count
            FROM users u
            WHERE u.id != ?
            ORDER BY u.name ASC
        ");
        $stmt->bind_param("ii", $current_user_id, $current_user_id);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    $users = [];
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }

    echo json_encode($users);

} catch (Exception $e) {
    echo json_encode([]);
}
?>