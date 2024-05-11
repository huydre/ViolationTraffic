<?php
require_once '../db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["license_number"]) || empty($_POST["driver_name"]) || empty($_POST["issuing_authority"]) || empty($_POST["date_of_issue"]) || empty($_POST["date_of_expiry"])) {
        echo "Hãy điền đủ thông tin";
    } else {
        $license_number = $_POST["license_number"];
        $driver_name = $_POST["driver_name"];
        $issuing_authority = $_POST["issuing_authority"];
        $date_of_issue = $_POST["date_of_issue"];
        $date_of_expiry = $_POST["date_of_expiry"];
    
        $sql = "INSERT INTO driving_licenses (license_number, driver_name, issuing_authority, date_of_issue, date_of_expiry)
        VALUES ('$license_number', '$driver_name', '$issuing_authority', '$date_of_issue', '$date_of_expiry')";
    
        if ($con->query($sql) === TRUE) {
            echo "Thêm giấy phép lái xe thành công!";
        } else {
            echo "Lỗi: " . $sql . "<br>" . $con->error;
        }
    }
} else {
    echo "Dữ liệu không hợp lệ!";
}
?>