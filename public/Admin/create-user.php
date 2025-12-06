<?php 
session_start();
include('C:\xampp\htdocs\MyLaundry\public\includes\dbcon.php');

if (!isset($_SESSION['authenticated']) || !isset($_SESSION['auth_user']) || $_SESSION['auth_user']['role'] !== 'admin') {
    // Redirect unauthorized users to login page or any other appropriate page
    $_SESSION['status']="Access Denied";
    header("Location: ../signin.php");
    exit();
}


if (isset($_POST['save'])) {
    $lastname = $_POST['lname'];
    $firstname = $_POST['fname'];
    $email = $_POST['email'];
    $phone = $_POST['Phone'];
    $password = $_POST['psw'];
    $street = $_POST['Adresse'];
    $city = $_POST['City'];
    $zip = $_POST['ZIP'];
    $role = $_POST['role'];
    $verify_status = "1";


    $check_query = "SELECT * FROM users WHERE email = ?";
    $check_stmt = $con->prepare($check_query);
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $result = $check_stmt->get_result();
    
    if ($result->num_rows > 0) {
        // Email is already taken, display error message
        echo "<script>alert('Email is already taken');</script>";
        echo "<script>window.location.href = 'UsersManagement.php';</script>"; // Redirect to the users management page
        exit(); // Stop further execution
    }

     // Insert data into the database
     $query = "INSERT INTO users (fname, lname, email, phone, password, street, city, zip, role,verify_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?,?)";
     $stmt = $con->prepare($query);
     $stmt->bind_param("ssssssssss", $firstname, $lastname, $email, $phone, $password, $street, $city, $zip, $role,$verify_status);
     
     if ($stmt->execute()) {
         // Data inserted successfully
         echo "<script>alert('User created successfully');</script>";
         // Log event in Event_Trace table
         $dateEvent = date('Y-m-d H:i:s');
         $ipEvent = $_SERVER['REMOTE_ADDR'];
         $comment = "Admin created a new user: $firstname $lastname ($email)";
         $typeEvent = "Create User";
         $adminId = $_SESSION['auth_user']['id_user']; // Assuming you have admin's ID in the session
         $adminName = $_SESSION['auth_user']['fname'] . ' ' . $_SESSION['auth_user']['lname'];
         $insert_event_query = "INSERT INTO Event_Trace (idEvent, DateEvent, IP_admin, Comment, TypeEvent, AdminId, AdminName) 
                                VALUES (NULL, ?, ?, ?, ?, ?, ?)";
         $stmt_event = $con->prepare($insert_event_query);
         $stmt_event->bind_param("ssssss", $dateEvent, $ipEvent, $comment, $typeEvent, $adminId, $adminName);
         $stmt_event->execute();
         $stmt_event->close();
         echo "<script>window.location.href = 'UsersManagement.php';</script>"; // Redirect to the users management page
     } else {
         // Error occurred
         echo "<script>alert('Error creating user');</script>";
     }
 
     // Close statement
     $stmt->close();
 }
 
 // Close connection
 $con->close();









?>