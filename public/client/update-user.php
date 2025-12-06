<?php


session_start(); // Start the session if not already started
include('C:\xampp\htdocs\MyLaundry\public\includes\dbcon.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the updated data from the form
    $fname = $_POST['cycle'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $street = $_POST['street'];
    $city = $_POST['city'];
    $zip = $_POST['zip'];

    // Get the user ID from the session
    $user_id = $_SESSION['auth_user']['id_user'];

    // Query to fetch current user information from the database
    $sql = "SELECT * FROM users WHERE id_user = $user_id";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        // User found, fetch user data
        $user = $result->fetch_assoc();

        // Check if email has been changed
        if ($email != $user['email']) {
            // Email has been changed, check if the new email already exists
            $check_email_sql = "SELECT * FROM users WHERE email = '$email'";
            $check_email_result = $con->query($check_email_sql);

            if ($check_email_result->num_rows > 0) {
                // New email already exists, display alert
                echo "<script>alert('Email already in use');window.location.href = 'profile.php';</script>";
            } else {
                // Update user information in the database
                $update_sql = "UPDATE users SET fname = '$fname', lname = '$lname', email = '$email', phone = '$phone', street = '$street', city = '$city', zip = '$zip' WHERE id_user = $user_id";

                if ($con->query($update_sql) === TRUE) {
                    echo "<script>alert('User information updated successfully');window.location.href = 'profile.php';</script>";
                } else {
                    echo "<script>alert('Error updating user information: " . $con->error . "');window.location.href = 'profile.php';</script>";
                }
            }
        } else {
            if ($fname == $user['fname'] && $lname == $user['lname'] && $email == $user['email'] &&
            $phone == $user['phone'] && $street == $user['street'] && $city == $user['city'] &&
            $zip == $user['zip']) {
            // No changes detected, display alert
            echo "<script>alert('No changes detected');window.location.href = 'profile.php';</script>";}
            else{
            // Email has not been changed, proceed with the update
            $update_sql = "UPDATE users SET fname = '$fname', lname = '$lname', email = '$email', phone = '$phone', street = '$street', city = '$city', zip = '$zip' WHERE id_user = $user_id";

            if ($con->query($update_sql) === TRUE) {
                echo "<script>alert('User information updated successfully');window.location.href = 'profile.php';</script>";
            } else {
                echo "<script>alert('Error updating user information: " . $con->error . "');window.location.href = 'profile.php';</script>";
            }
         }
        }
    } else {
        // User not found
        echo "<script>alert('User not found');window.location.href = 'profile.php';</script>";
    }
}

// Close the database connection
$con->close();

