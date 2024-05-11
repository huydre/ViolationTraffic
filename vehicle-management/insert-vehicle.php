<?php
require_once '../db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["license_plate"]) || empty($_POST["vehicle_type"]) || empty($_POST["color"]) || empty($_POST["owner_name"]) || empty($_POST["registration_date"])) {
        echo "Hãy điền đủ thông tin";
    } else {
        $license_plate = $_POST["license_plate"];
        $vehicle_type = $_POST["vehicle_type"];
        $color = $_POST["color"];
        $owner_name = $_POST["owner_name"];
        $registration_date = $_POST["registration_date"];
    
        $sql = "INSERT INTO vehicles (license_plate, vehicle_type, color, owner_name, registration_date)
        VALUES ('$license_plate', '$vehicle_type', '$color', '$owner_name', '$registration_date')";
    
        if ($con->query($sql) === TRUE) {
            echo "Thêm phương tiện thành công!";
        } else {
            echo "Lỗi: " . $sql . "<br>" . $con->error;
        }
    }
} else {
    echo "Dữ liệu không hợp lệ!";
}
?>