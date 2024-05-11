<?php
// Include your database connection file
include_once '../db.php';

// Check if the necessary data is set
if (isset($_POST['id'], $_POST['license_plate'], $_POST['vehicle_type'], $_POST['color'], $_POST['owner_name'], $_POST['registration_date'])) {
    // Get the data from the POST request
    $id = $_POST['id'];
    $license_plate = $_POST['license_plate'];
    $vehicle_type = $_POST['vehicle_type'];
    $color = $_POST['color'];
    $owner_name = $_POST['owner_name'];
    $registration_date = $_POST['registration_date'];

    // Clean the data to prevent SQL injection
    $id = mysqli_real_escape_string($con, $id);
    $license_plate = mysqli_real_escape_string($con, $license_plate);
    $vehicle_type = mysqli_real_escape_string($con, $vehicle_type);
    $color = mysqli_real_escape_string($con, $color);
    $owner_name = mysqli_real_escape_string($con, $owner_name);
    $registration_date = mysqli_real_escape_string($con, $registration_date);

    // Create the SQL query
    $sql = "UPDATE vehicles SET license_plate = '$license_plate', vehicle_type = '$vehicle_type', color = '$color', owner_name = '$owner_name', registration_date = '$registration_date' WHERE vehicle_id = $id";

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