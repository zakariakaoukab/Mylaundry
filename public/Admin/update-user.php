<?php
include('C:\xampp\htdocs\MyLaundry\public\includes\dbcon.php');
session_start();

if (!isset($_SESSION['authenticated']) || !isset($_SESSION['auth_user']) || $_SESSION['auth_user']['role'] !== 'admin') {
    // Redirect unauthorized users to login page or any other appropriate page
    $_SESSION['status']="Access Denied";
    header("Location: ../signin.php");
    exit();
}

// Check if the form data is submitted and not empty
if (isset($_POST['save'])) {
    // Retrieve form data
    $userId = $_POST['userId'];
    $firstName = $_POST['fname'];
    $lastName = $_POST['lname'];
    $email = $_POST['email'];
    $password = $_POST['psw'];
    $adresse = $_POST['Adresse'];
    $city = $_POST['City'];
    $zip = $_POST['ZIP'];
    $phone = $_POST['Phone'];
    $role = $_POST['role'];

    // Retrieve existing user data from the database
    $query = "SELECT * FROM users WHERE id_user='$userId'";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $userData = mysqli_fetch_assoc($result);

        // Compare the form data with the existing data
        $changes = []; // Array to store the changes made by the admin
        if ($firstName != $userData['fname']) {
            $changes[] = "First Name: {$userData['fname']} => $firstName";
        }
        if ($lastName != $userData['lname']) {
            $changes[] = "Last Name: {$userData['lname']} => $lastName";
        }
        if ($email != $userData['email']) {
            $changes[] = "Email: {$userData['email']} => $email";
        }
        if ($password != $userData['password']) {
    $changes[] = "Password: [REDACTED] => [REDACTED]"; // For security reasons, avoid storing passwords in logs
         }
      if ($adresse != $userData['street']) {
    $changes[] = "Street: {$userData['street']} => $adresse";
}
       if ($city != $userData['city']) {
    $changes[] = "City: {$userData['city']} => $city";
}
     if ($zip != $userData['zip']) {
    $changes[] = "ZIP: {$userData['zip']} => $zip";
}
    if ($phone != $userData['phone']) {
    $changes[] = "Phone: {$userData['phone']} => $phone";
}
    if ($role != $userData['role']) {
    $changes[] = "Role: {$userData['role']} => $role";
}

        if (!empty($changes)) {
            // If any data has changed, perform the update
            $updateQuery = "UPDATE users SET fname='$firstName', lname='$lastName', email='$email', password='$password',
                            street='$adresse', city='$city', zip='$zip', phone='$phone', role='$role' WHERE id_user='$userId'";
            $updateResult = mysqli_query($con, $updateQuery);

            if ($updateResult) {
                // If update is successful, log the event in Event_Trace table
                $dateEvent = date('Y-m-d H:i:s');
                $ipEvent = $_SERVER['REMOTE_ADDR'];
                $comment = "Admin updated user information for user ID: $userId. Changes: " . implode(", ", $changes);
                $typeEvent = "Update User Information";
                $adminId = $_SESSION['auth_user']['id_user']; // Assuming you have admin's ID in the session
                $adminName = $_SESSION['auth_user']['fname'] . ' ' . $_SESSION['auth_user']['lname'];
                $insertEventQuery = "INSERT INTO Event_Trace (idEvent, DateEvent, IP_admin, Comment, TypeEvent, AdminId, AdminName) 
                                     VALUES (NULL, ?, ?, ?, ?, ?, ?)";
                $stmtEvent = $con->prepare($insertEventQuery);
                $stmtEvent->bind_param("ssssss", $dateEvent, $ipEvent, $comment, $typeEvent, $adminId, $adminName);
                $stmtEvent->execute();
                $stmtEvent->close();

                // Redirect back to the page where the form was submitted from
                echo "<script>alert('User information updated successfully');</script>";
                echo "<script>window.location.href = 'UsersManagement.php';</script>";
                exit();
            } else {
                // If update fails, display an error message
                echo "Error updating user information: " . mysqli_error($con);
            }
        } else {
            // If no data has changed, redirect back to the page where the form was submitted from
            echo "<script>alert('No changes detected');</script>";
            echo "<script>window.location.href = 'UsersManagement.php';</script>";
            exit();
        }
    } else {
        // If user data cannot be retrieved, display an error message
        echo "Error retrieving user information: " . mysqli_error($con);
    }
} else {
    // If form data is not submitted, redirect back to the page where the form was submitted from
    header('Location: .php'); // Change 'previous_page.php' to the appropriate page
    exit();
}
?>
