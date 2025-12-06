<?php
include('C:\xampp\htdocs\MyLaundry\public\includes\dbcon.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $orderId = $_POST['order_id'];

    // Update the status of the order to "Delivered"
    $sql = "UPDATE orders SET status = 'Delivered' WHERE order_id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param('i', $orderId);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update order status']);
    }

    $stmt->close();
    $con->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
