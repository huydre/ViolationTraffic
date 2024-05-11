<?php 

    $con = mysqli_connect("localhost","root","","traffic_violation_db");

    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

?>