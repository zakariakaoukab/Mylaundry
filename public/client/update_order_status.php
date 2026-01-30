<?php
session_start();
include('C:\xampp\htdocs\MyLaundry\public\includes\dbcon.php');

// Check if user is authenticated
if (!isset($_SESSION['authenticated'])) {
    echo json_encode(['success' => false, 'message' => 'Not authenticated']);
    exit();
}

// Check if this is a POST request with JSON content
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['CONTENT_TYPE'] === 'application/json') {
    $input = json_decode(file_get_contents('php://input'), true);
    
    $order_id = isset($input['order_id']) ? intval($input['order_id']) : null;
    $status = isset($input['status']) ? $input['status'] : 'Confirmed';
    $phone = isset($input['phone']) ? $input['phone'] : null;
    $address = isset($input['address']) ? $input['address'] : null;
    $user_id = isset($input['user_id']) ? intval($input['user_id']) : $_SESSION['auth_user']['id_user'];
    
    if (!$order_id) {
        echo json_encode(['success' => false, 'message' => 'Invalid order ID']);
        exit();
    }
    
    // Verify that the order belongs to the current user
    $verify_query = "SELECT order_id FROM orders WHERE order_id = ? AND id_user = ?";
    $verify_stmt = $con->prepare($verify_query);
    $verify_stmt->bind_param("ii", $order_id, $user_id);
    $verify_stmt->execute();
    $verify_result = $verify_stmt->get_result();
    
    if ($verify_result->num_rows === 0) {
        echo json_encode(['success' => false, 'message' => 'Order not found or unauthorized']);
        $verify_stmt->close();
        exit();
    }
    $verify_stmt->close();
    
    // Update order status
    $update_query = "UPDATE orders SET status = ? WHERE order_id = ?";
    $update_stmt = $con->prepare($update_query);
    $update_stmt->bind_param("si", $status, $order_id);
    
    if (!$update_stmt->execute()) {
        echo json_encode(['success' => false, 'message' => 'Failed to update order status: ' . $con->error]);
        $update_stmt->close();
        exit();
    }
    $update_stmt->close();
    
    // Update user phone if provided
    if ($phone) {
        $phone_query = "UPDATE users SET phone = ? WHERE id_user = ?";
        $phone_stmt = $con->prepare($phone_query);
        $phone_stmt->bind_param("si", $phone, $user_id);
        if (!$phone_stmt->execute()) {
            echo json_encode(['success' => false, 'message' => 'Failed to update phone: ' . $con->error]);
            $phone_stmt->close();
            exit();
        }
        $phone_stmt->close();
    }
    
    // Update user address (street) if provided
    if ($address) {
        $address_query = "UPDATE users SET street = ? WHERE id_user = ?";
        $address_stmt = $con->prepare($address_query);
        $address_stmt->bind_param("si", $address, $user_id);
        if (!$address_stmt->execute()) {
            echo json_encode(['success' => false, 'message' => 'Failed to update address: ' . $con->error]);
            $address_stmt->close();
            exit();
        }
        $address_stmt->close();
    }
    
    echo json_encode(['success' => true, 'message' => 'Order and delivery information updated successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

$con->close();
?>
