<?php
include('C:\xampp\htdocs\MyLaundry\public\includes\dbcon.php');
session_start();
if (!isset($_SESSION['authenticated']) || !isset($_SESSION['auth_user']) || $_SESSION['auth_user']['role'] !== 'admin') {
    // Redirect unauthorized users to login page or any other appropriate page
    $_SESSION['status']="Access Denied";
    header("Location: ../signin.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['userId'])) {
    $userId = $_POST['userId'];

    $adminId = $_SESSION['auth_user']['id_user']; // Assuming you have admin's ID in the session
    $adminName = $_SESSION['auth_user']['fname'] . ' ' . $_SESSION['auth_user']['lname'];
    $dateEvent = date('Y-m-d H:i:s');
    $ipAdmin = $_SERVER['REMOTE_ADDR']; // Use $_SERVER['REMOTE_ADDR'] to get the admin's IP address
    $comment = "Admin delete a User";
    $typeEvent = "Delete user";

   // Insert the event into the Event_Trace table
    $insert_event_query = "INSERT INTO Event_Trace (idEvent, DateEvent, IP_admin, Comment, TypeEvent, AdminId, AdminName) 
       VALUES (NULL, '$dateEvent', '$ipAdmin', '$comment', '$typeEvent', '$adminId', '$adminName')";
      mysqli_query($con, $insert_event_query);

    // Prepare a statement to delete the user
    $query = "DELETE FROM users WHERE id_user = ?";
    $statement = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($statement, "i", $userId);

    // Execute the statement
    if (mysqli_stmt_execute($statement)) {
        // Deletion successful
      
    } else {
        // Deletion failed
        echo "Error deleting user.";
    }

    // Close the delete statement
    mysqli_stmt_close($statement);
} else {
    // Invalid request method or missing user ID
    echo "Invalid request.";
}
?>