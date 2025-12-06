<?php
// Include the database connection file
session_start();
include('C:\xampp\htdocs\MyLaundry\public\includes\dbcon.php');

// Check if the form data is submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $dateEvent = date('Y-m-d H:i:s');
    $ipEvent = $_SERVER['REMOTE_ADDR'];
    $comment = "Admin Updated the Article";
    $typeEvent = "Update Article";
    $adminId = $_SESSION['auth_user']['id_user']; // Assuming you have admin's ID in the session
    $adminName = $_SESSION['auth_user']['fname'] . ' ' . $_SESSION['auth_user']['lname'];
    $insertEventQuery = "INSERT INTO Event_Trace (idEvent, DateEvent, IP_admin, Comment, TypeEvent, AdminId, AdminName) 
                         VALUES (NULL, ?, ?, ?, ?, ?, ?)";
    $stmtEvent = $con->prepare($insertEventQuery);
    $stmtEvent->bind_param("ssssss", $dateEvent, $ipEvent, $comment, $typeEvent, $adminId, $adminName);
    $stmtEvent->execute();
    $stmtEvent->close();



    // Retrieve the form data
    $id = $_POST['id'];
    $name = $_POST['name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    // Perform validation if needed

    // Query to update the article
    $query = "UPDATE articles SET article_name = '$name', category = '$category', price = '$price', description = '$description' WHERE id_article = $id";

    // Execute the query
    if (mysqli_query($con, $query)) {
      Header("Location: Articles.php");
    } else {
        echo 'error'; // Return 'error' if there was an error updating the article
    }

    // Close the database connection
    mysqli_close($con);
}
?>