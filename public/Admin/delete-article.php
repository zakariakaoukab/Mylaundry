<?php
session_start();
include('C:\xampp\htdocs\MyLaundry\public\includes\dbcon.php');

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Fetch data of the article being deleted
    $query = "SELECT * FROM articles WHERE id_article = $id";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);

    // Insert data into Event_Trace table
    $dateEvent = date("Y-m-d H:i:s");
    $ipAdmin = $_SERVER['REMOTE_ADDR'];
    $comment = "Article deleted: " . $row['article_name'];
    $typeEvent = "Article Deleted";
    $adminId =  $_SESSION['auth_user']['id_user']; // Assuming you have admin session
    $adminName = $_SESSION['auth_user']['fname'] . ' ' . $_SESSION['auth_user']['lname'];// Assuming you have admin session

    $query = "INSERT INTO Event_Trace ( DateEvent, IP_admin, Comment, TypeEvent, AdminId, AdminName) 
              VALUES ('$dateEvent', '$ipAdmin', '$comment', '$typeEvent', '$adminId', '$adminName')";
    $result = mysqli_query($con, $query);

    // Delete the row from the articles table
    $query = "DELETE FROM articles WHERE id_article = $id";
    $result = mysqli_query($con, $query);

    if ($result) {
         Header("Location: Articles.php");
    } else {
        echo "Error: " . mysqli_error($con);
    }
} else {
    echo "ID not provided";
}
?>
