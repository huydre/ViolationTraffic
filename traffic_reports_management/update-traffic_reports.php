<?php 

require_once '../db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate input
    $report_id = trim($_POST["id"]);
    $license_plate = trim($_POST["license_plate"]);
    $violation_type = trim($_POST["violation_type"]);
    $license_number = trim($_POST["license_number"]);
    $fine = trim($_POST["fine"]);
    $location = trim($_POST["location"]);
    $report_date = trim($_POST["report_date"]);

    if (empty($report_id) || empty($license_plate) || empty($violation_type) || empty($license_number) || empty($fine) || empty($location) || empty($report_date)) {
        echo "Hãy điền đủ thông tin";
    } else {
        // Prepare an SQL statement to prevent SQL injection
        $sql = "UPDATE traffic_reports SET license_plate = '$license_plate', violation_type = '$violation_type', license_number = '$license_number', fine = '$fine', location = '$location', report_date = '$report_date' WHERE report_id = $report_id";
     
        if ($con->query($sql) === TRUE) {
            echo "Cập nhật lỗi vi phạm thành công!";
        } else {
            echo "Lỗi: " . $sql . "<br>" . $con->error;
        }
    }
} else {
    echo "Dữ liệu không hợp lệ!";
}


?>