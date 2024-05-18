<?php
require_once 'db.php';
if (isset($_POST['licensePlate'])) {
    $licensePlate = $_POST['licensePlate'];

    // Connect to your database

    $sql = "SELECT * FROM traffic_reports WHERE license_plate = '$licensePlate'";
    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result) == 0) {
        echo "Không tìm thấy thông tin vi phạm cho biển số xe này.";
        return;
    }

    echo "<tr>";
    echo "<th>Số biên bản</th>";
    echo "<th>Biển số xe</th>";
    echo "<th>Loại vi phạm</th>";
    echo "<th>Ngày vi phạm</th>";
    echo "<th>Địa điểm</th>";
    echo "<th>Trạng thái thanh toán</th>";
    echo "</tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['report_id'] . "</td>";
        echo "<td>" . $row['license_plate'] . "</td>";
        echo "<td>" . $row['violation_type'] . "</td>";
        echo "<td>" . $row['report_date'] . "</td>";
        echo "<td>" . $row['location'] . "</td>";
        echo "<td>";
        if ($row['is_payment_done'] == 1) {
            echo "Đã thanh toán";
        } else {
            echo "Chưa thanh toán";
        }
        echo "</td>";
        echo "</tr>";
    }
}
?>