<?php
session_start();
include('C:\xampp\htdocs\MyLaundry\public\includes\dbcon.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Get the JSON input
  $input = json_decode(file_get_contents('php://input'), true);

  $orderId = $input['orderId'];
  $details = $input['details'];

  // Extract necessary payment details
  $transactionId = $details['id'];
  $status = $details['status'];
  $payerName = $details['payer']['name']['given_name'] . ' ' . $details['payer']['name']['surname'];
  $payerEmail = $details['payer']['email_address'];
  $amount = $details['purchase_units'][0]['amount']['value'];

  // Verify the transaction details (e.g., check the payment status)
  if ($status === 'COMPLETED') {
    // Update the order status in the database
    $stmt = $con->prepare("UPDATE orders SET status = 'Paid', transaction_id = ?, payer_name = ?, payer_email = ? WHERE order_id = ?");
    $stmt->bind_param("ssss", $transactionId, $payerName, $payerEmail, $orderId);
    if ($stmt->execute()) {
      echo json_encode(['success' => true, 'message' => 'Payment verified and order updated successfully.']);
    } else {
      echo json_encode(['success' => false, 'message' => 'Failed to update order.']);
    }
    $stmt->close();
  } else {
    echo json_encode(['success' => false, 'message' => 'Payment verification failed.']);
  }
} else {
  echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}

$con->close();
?>
