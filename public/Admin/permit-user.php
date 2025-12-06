<?php
include('C:\xampp\htdocs\MyLaundry\public\includes\dbcon.php');
session_start();
// Check if the user is authenticated and has admin role
if (!isset($_SESSION['authenticated']) || !isset($_SESSION['auth_user']) || $_SESSION['auth_user']['role'] !== 'admin') {
    // Redirect unauthorized users to login page or any other appropriate page
    $_SESSION['status']="Access Denied";
    header("Location: ../signin.php");
    exit();
}
else{

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['userId'])) {
    $userId = $_GET['userId'];
    $dateEvent = date('Y-m-d H:i:s');
    $ipEvent = $_SERVER['REMOTE_ADDR'];
    $comment = "Admin grant permission to user with the ID: $userId";
    $typeEvent = "Grant Permission to a banned user";
    $adminId = $_SESSION['auth_user']['id_user']; // Assuming you have admin's ID in the session
    $adminName = $_SESSION['auth_user']['fname'] . ' ' . $_SESSION['auth_user']['lname'];
    $insertEventQuery = "INSERT INTO Event_Trace (idEvent, DateEvent, IP_admin, Comment, TypeEvent, AdminId, AdminName) 
                         VALUES (NULL, ?, ?, ?, ?, ?, ?)";
    $stmtEvent = $con->prepare($insertEventQuery);
    $stmtEvent->bind_param("ssssss", $dateEvent, $ipEvent, $comment, $typeEvent, $adminId, $adminName);
    $stmtEvent->execute();
    $stmtEvent->close();

    // Prepare a statement to update the user's permission status
    $query = "UPDATE users SET verify_status = '1' WHERE id_user = ?";
    $statement = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($statement, "i", $userId);

    // Execute the statement
    if (mysqli_stmt_execute($statement)) {
        // Permission granted successfully
        header("Location: UsersManagement.php");
        exit();
    } else {
        // Permission granting failed
        echo "Error granting permission to user.";
    }

    // Close the statement
    mysqli_stmt_close($statement);
} else {
    // Invalid request method or missing user ID
    echo "Invalid request.";
}
}
?>
