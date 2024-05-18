<?php
require_once '../db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["id"])) {
        echo "No id provided.";
    } else {
        $id = $_POST["id"];
      
        $sql = "DELETE FROM traffic_reports WHERE report_id = $id";
      
        if ($con->query($sql) === TRUE) {
            echo "Xoá lỗi vi phạm thành công!";
        } else {
            echo "Error: " . $sql . "<br>" . $con->error;
        }
    }
} else {
    echo "No POST data received.";
}
?>