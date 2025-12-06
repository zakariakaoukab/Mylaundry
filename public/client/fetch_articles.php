<?php
include('C:\xampp\htdocs\MyLaundry\public\includes\dbcon.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category = isset($_POST['category']) ? $_POST['category'] : '';

    $sql = "SELECT * FROM articles WHERE category = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $category);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            // Output HTML for each article
            echo '<div class="w-96 border-2 rounded-full py-2 flex items-center mb-4" style="border-color: #BAE2FA;">';
            echo '<button class="rounded-full mx-2 p-2 w-10" style="background-color: #BAE2FA;">';
            echo '<svg width="24px" height="24px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">';
            echo '<path d="M4 12H20M12 4V20" stroke="#4b8dd2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>';
            echo '</svg>';
            echo '</button>';
            echo '<div class="ml-2 w-40">';
            echo '<h3 class="text-sm font-bold" style="color:#4DA7EA;">' . $row["article_name"] . '</h3>';
            echo '<div class="text-blue-900 mt-1 text-xs">' . $row["description"] . '</div>';
            echo '</div>';
            echo '<div class="w-20 text-right">';
            echo '<span class="text-lg font-bold ">' . $row["price"] . 'DH</span>';
            echo '</div>';
            echo '<div class="ml-auto">';
            echo '<button class="rounded-full p-2 w-10 h-10 mr-3 border-2 border-red-600 hidden" style="background-color: white;">';
            echo '<svg width="24px" height="24px" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">';
            echo '<path d="M6 12L18 12" stroke="#ff0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>';
            echo '</svg>';
            echo '</button>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo "No results found for this category.";
    }

    $stmt->close();
    $con->close();
} else {
    echo "Invalid request method.";
}
?>
