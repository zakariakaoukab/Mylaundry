<?php 
include('C:\xampp\htdocs\MyLaundry\public\includes\dbcon.php');

 // Get today's date
 $today = date('Y-m-d');

 // SQL query to count orders where order_date is today
 $sqll = "SELECT COUNT(*) as total_orders FROM orders WHERE DATE(order_date) = '$today'";
 $resultt = $con->query($sqll);
 
 // Fetch the result
 $total_orders = 0;
 if ($resultt->num_rows > 0) {
     $row = $resultt->fetch_assoc();
     $total_orders = $row['total_orders'];
 }

 $sqlll = "SELECT SUM(total) as total_income FROM orders";
$resulttt = $con->query($sqlll);

// Fetch the result
$total_income = 0;
if ($resulttt->num_rows > 0) {
    $row = $resulttt->fetch_assoc();
    $total_income = $row['total_income'];
}
 echo $total_income;
 
  $con->close();