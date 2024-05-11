<?php
// Include your database connection file
include_once '../db.php';

// Check if the necessary data is set
if (isset($_POST['id'], $_POST['license_number'], $_POST['driver_name'], $_POST['issuing_authority'], $_POST['date_of_issue'], $_POST['date_of_expiry'])) {
    // Get the data from the POST request
    $id = $_POST['id'];
    $license_number = $_POST['license_number'];
    $driver_name = $_POST['driver_name'];
    $issuing_authority = $_POST['issuing_authority'];
    $date_of_issue = $_POST['date_of_issue'];
    $date_of_expiry = $_POST['date_of_expiry'];

    // Clean the data to prevent SQL injection
    $id = mysqli_real_escape_string($con, $id);
    $license_number = mysqli_real_escape_string($con, $license_number);
    $driver_name = mysqli_real_escape_string($con, $driver_name);
    $issuing_authority = mysqli_real_escape_string($con, $issuing_authority);
    $date_of_issue = mysqli_real_escape_string($con, $date_of_issue);
    $date_of_expiry = mysqli_real_escape_string($con, $date_of_expiry);

    // Create the SQL query
    $sql = "UPDATE driving_licenses SET license_number = '$license_number', driver_name = '$driver_name', issuing_authority = '$issuing_authority', date_of_issue = '$date_of_issue', date_of_expiry = '$date_of_expiry' WHERE license_id = $id";

    // Execute the query
    if (mysqli_query($con, $sql)) {
        echo "Vehicle updated successfully";
    } else {
        echo "Error updating vehicle: " . mysqli_error($con);
    }
} else {
    echo "Missing data in POST request";
}
?>