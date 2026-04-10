<?php
include 'db.php';

header('Content-Type: application/json');

$doctor_id = intval($_GET['doctor_id'] ?? 0);

try {
    $stmt = $conn->prepare("
        SELECT 
            COALESCE(AVG(rating), 0) AS average_rating,
            COUNT(*) AS total_reviews
        FROM reviews
        WHERE doctor_id = ?
    ");
    $stmt->bind_param("i", $doctor_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $summary = $result->fetch_assoc();

    $stmt2 = $conn->prepare("
        SELECT r.rating, r.comment, r.created_at, u.name AS patient_name
        FROM reviews r
        JOIN users u ON r.patient_id = u.id
        WHERE r.doctor_id = ?
        ORDER BY r.created_at DESC
    ");
    $stmt2->bind_param("i", $doctor_id);
    $stmt2->execute();
    $result2 = $stmt2->get_result();

    $reviews = [];
    while ($row = $result2->fetch_assoc()) {
        $reviews[] = $row;
    }

    echo json_encode([
        "average_rating" => round((float)$summary['average_rating'], 1),
        "total_reviews" => intval($summary['total_reviews']),
        "reviews" => $reviews
    ]);

} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}
?>