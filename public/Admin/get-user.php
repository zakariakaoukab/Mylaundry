<?php
include('C:\xampp\htdocs\MyLaundry\public\includes\dbcon.php');
// Check if the user ID is provided in the request
if (isset($_GET['id'])) {
    // Sanitize and retrieve the user ID from the request
    $userId = mysqli_real_escape_string($con, $_GET['id']);

    // Query to fetch user information based on the provided ID
    $query = "SELECT * FROM users WHERE id_user = '$userId'";
    $result = mysqli_query($con, $query);

    // Check if the query was successful
    if ($result) {
        // Fetch user data as an associative array
        $userData = mysqli_fetch_assoc($result);

        // Return user data as JSON response
        echo json_encode($userData);
    } else {
        // Handle query error
        echo "Error: " . mysqli_error($con);
    }
} else {
    // Handle missing user ID in the request
    echo "Error: User ID is missing.";
}
?>