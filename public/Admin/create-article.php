<?php
session_start();
include('C:\xampp\htdocs\MyLaundry\public\includes\dbcon.php');

if (!isset($_SESSION['authenticated']) || !isset($_SESSION['auth_user']) || $_SESSION['auth_user']['role'] !== 'admin') {
    // Redirect unauthorized users to the login page or any other appropriate page
    $_SESSION['status'] = "Access Denied";
    header("Location: ../signin.php");
    exit();
}

if (isset($_POST['save'])) {
    $article_name = $_POST['name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    // Insert data into the database
    $query = "INSERT INTO articles (article_name, category, price, description) VALUES (?, ?, ?, ?)";
    $stmt = $con->prepare($query);
    $stmt->bind_param("ssss", $article_name, $category, $price, $description);

    if ($stmt->execute()) {
        // Data inserted successfully
        echo "<script>alert('Article added successfully');</script>";

        // Log event in Event_Trace table
        $dateEvent = date('Y-m-d H:i:s');
        $ipEvent = $_SERVER['REMOTE_ADDR'];
        $comment = "Admin added a new Article: $article_name";
        $typeEvent = "Add article";
        $adminId = $_SESSION['auth_user']['id_user'];
        $adminName = $_SESSION['auth_user']['fname'] . ' ' . $_SESSION['auth_user']['lname'];

        $insert_event_query = "INSERT INTO event_trace (DateEvent, IP_admin, Comment, TypeEvent, AdminId, AdminName) 
                               VALUES (?, ?, ?, ?, ?, ?)";
        $stmt_event = $con->prepare($insert_event_query);

        if ($stmt_event) {
            $stmt_event->bind_param("ssssss", $dateEvent, $ipEvent, $comment, $typeEvent, $adminId, $adminName);
            if ($stmt_event->execute()) {
                // Event logged successfully
                echo "<script>window.location.href = 'Articles.php';</script>"; // Redirect to the articles page
            } else {
                // Error occurred while logging event
                echo "<script>alert('Error logging event');</script>";
            }
            $stmt_event->close();
        } else {
            // Error occurred while preparing event logging statement
            echo "<script>alert('Error preparing event logging statement');</script>";
        }
    } else {
        // Error occurred while inserting data into the articles table
        echo "<script>alert('Error adding article');</script>";
    }

    // Close statement
    $stmt->close();
}

// Close connection
$con->close();
?>
