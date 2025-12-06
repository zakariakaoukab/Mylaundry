<?php
session_start();
include('C:\xampp\htdocs\MyLaundry\public\includes\dbcon.php');


// SQL query to get order details and article names
$sql = "
    SELECT 
        o.order_id, 
        o.id_user, 
        o.total, 
        o.status, 
        o.order_date, 
        o.pickupDate, 
        o.deliveryDate, 
        GROUP_CONCAT(a.article_name SEPARATOR ', ') AS articles
    FROM orders o
    JOIN order_details od ON o.order_id = od.order_id
    JOIN articles a ON od.article_id = a.id_article
    GROUP BY o.order_id
    ORDER BY o.order_date DESC
";

$result = $con->query($sql);

// Check for query errors
if (!$result) {
    echo json_encode(['error' => $con->error]);
    $con->close();
    exit();
}

// Fetch the results
$orders = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }
}

$con->close();

// Encode the result as JSON
header('Content-Type: application/json');
echo json_encode(['data' => $orders]);
?>
