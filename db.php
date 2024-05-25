<?php 
    $con = mysqli_connect("localhost","root","","traffic_violation_db", "3308");


    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

?>