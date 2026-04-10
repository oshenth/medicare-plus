<?php
include 'db.php';

header('Content-Type: application/json');

try {
    $search = trim($_GET['search'] ?? '');
    $specialization = trim($_GET['specialization'] ?? '');

    $sql = "
        SELECT 
            d.id AS doctor_profile_id,
            d.user_id,
            d.specialization,
            d.experience,
            d.fee,
            d.availability,
            u.name,
            COALESCE(ROUND(AVG(r.rating), 1), 0) AS average_rating,
            COUNT(r.id) AS total_reviews
        FROM doctors d
        JOIN users u ON d.user_id = u.id
        LEFT JOIN reviews r ON d.user_id = r.doctor_id
        WHERE 1=1
    ";

    $params = [];
    $types = "";

    if ($search !== '') {
        $sql .= " AND u.name LIKE ?";
        $params[] = "%" . $search . "%";
        $types .= "s";
    }

    if ($specialization !== '') {
        $sql .= " AND d.specialization = ?";
        $params[] = $specialization;
        $types .= "s";
    }

    $sql .= " GROUP BY d.id, d.user_id, d.specialization, d.experience, d.fee, d.availability, u.name
              ORDER BY u.name ASC";

    $stmt = $conn->prepare($sql);

    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    echo json_encode($data);

} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}
?>