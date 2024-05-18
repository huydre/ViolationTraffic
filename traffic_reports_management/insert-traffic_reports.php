<?php
require_once '../db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate input
    $license_plate = trim($_POST["license_plate"]);
    $violation_type = trim($_POST["violation_type"]);
    $license_number = trim($_POST["license_number"]);
    $fine = trim($_POST["fine"]);
    $location = trim($_POST["location"]);
    $report_date = trim($_POST["report_date"]);

    if (empty($license_plate) || empty($violation_type) || empty($license_number) || empty($fine) || empty($location) || empty($report_date)) {
        echo "Hãy điền đủ thông tin";
    } else {
        // Prepare an SQL statement to prevent SQL injection
        $sql = "INSERT INTO traffic_reports (license_plate, violation_type, license_number, fine, location, report_date, is_payment_done)
        VALUES ('$license_plate', '$violation_type', '$license_number', '$fine', '$location', '$report_date', 0)";
     
        if ($con->query($sql) === TRUE) {
            echo "Thêm lỗi vi phạm thành công!";
        } else {
            echo "Lỗi: " . $sql . "<br>" . $con->error;
        }
    }
} else {
    echo "Dữ liệu không hợp lệ!";
}

// Close the database connection
$con->close();
?>