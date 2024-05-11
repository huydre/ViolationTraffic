<?php
require_once '../db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["id"])) {
        echo "No id provided.";
    } else {
        $id = $_POST["id"];
      
        $sql = "DELETE FROM vehicles WHERE vehicle_id = $id";
      
        if ($con->query($sql) === TRUE) {
            echo "Record deleted successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $con->error;
        }
    }
} else {
    echo "No POST data received.";
}
?>