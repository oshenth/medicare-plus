<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = new mysqli("127.0.0.1", "root", "", "medicare_plus", 3306);
    $conn->set_charset("utf8mb4");
} catch (Exception $e) {
    header('Content-Type: application/json');
    echo json_encode([
        "status" => "error",
        "message" => "Database connection failed",
        "details" => $e->getMessage()
    ]);
    exit;
}
?>