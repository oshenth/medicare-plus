<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = new mysqli("127.0.0.1", "root", "", "medicare_plus", 3306);
    echo "DB connected successfully";
} catch (Exception $e) {
    echo "DB connection failed: " . $e->getMessage();
}
?>