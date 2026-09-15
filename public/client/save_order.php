<?php
session_start();
include('C:\xampp\htdocs\MyLaundry\public\includes\dbcon.php');
require_once 'C:\xampp\htdocs\MyLaundry\vendor\autoload.php';
use GuzzleHttp\Client;

if (!isset($_SESSION['authenticated'])) {
  $_SESSION['status'] = "Please login to access our services!";
  header("Location: ../signin.php");
  exit();
}

if (isset($_SESSION['auth_user']['role']) && $_SESSION['auth_user']['role'] === 'admin') {
  $_SESSION['status'] = "Not Allowed";
  header("Location: ../signin.php");
} else {
  // client is authenticated, allow access
  $role = $_SESSION['auth_user']['role'];
}

// Function to generate UUID
function generateUUID() {
  return sprintf('%04x%04x%04x-%04x%04x', mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff));
}

// Function to get conversion rate from MAD to USD
function getConversionRate($amount) {
  $client = new Client([
      'base_uri' => 'http://api.exchangeratesapi.io/v1/',
  ]);

  try {
      // Fetch EUR to MAD rate
      $response = $client->request('GET', 'latest', [
          'query' => [
              'access_key' => 'API_KEY', // Replace with your actual API key
              'symbols' => 'MAD',
          ]
      ]);

      if ($response->getStatusCode() != 200) {
          throw new Exception('Failed to fetch conversion rate.');
      }

      $body = $response->getBody();
      $arr_body = json_decode($body, true);
      $rateEURtoMAD = $arr_body['rates']['MAD'];

      // Fetch EUR to USD rate
      $response = $client->request('GET', 'latest', [
          'query' => [
              'access_key' => '9bc87331cac8edd88e1f6c3fb2b5a8a9',
              'symbols' => 'USD',
          ]
      ]);

      if ($response->getStatusCode() != 200) {
          throw new Exception('Failed to fetch conversion rate.');
      }

      $body = $response->getBody();
      $arr_body = json_decode($body, true);
      $rateEURtoUSD = $arr_body['rates']['USD'];

      // Calculate MAD to USD rate
      $rateMADtoUSD = $rateEURtoUSD / $rateEURtoMAD;

      return round($amount * $rateMADtoUSD,2);
  } catch (Exception $e) {
      error_log($e->getMessage());
      echo $e->getMessage();
      return false;
  }
}

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Decode the JSON data sent via form
  $cart = json_decode($_POST['cart'], true);
  $total = $_POST['total'];
  
  $userId = $_SESSION['auth_user']['id_user']; // Assuming user_id is stored in session after login
  $status = 'Pending'; // Default status
  $pickupDate = $_SESSION['pickupDate'];
  $deliveryDate = $_SESSION['deliveryDate'];
  $orderId = generateUUID();
  $totalUSD= getConversionRate($total);
  $_SESSION['totalUSD'] = $totalUSD;

  try {
      // Begin a database transaction
      $con->begin_transaction();

      // Insert order into orders table
      $stmt = $con->prepare("INSERT INTO orders (order_id, id_user, total, status, order_date, pickupDate, deliveryDate) VALUES (?, ?, ?, ?, NOW(), ?, ?)");
      $stmt->bind_param("ssssss", $orderId, $userId, $total, $status, $pickupDate, $deliveryDate);
      $stmt->execute();

      // Insert each cart item into order_details table
      $stmt = $con->prepare("INSERT INTO order_details (order_id, article_id, quantity, price) VALUES (?, ?, ?, ?)");
      foreach ($cart as $item) {
          $stmt->bind_param("ssii", $orderId, $item['article']['id_article'], $item['quantity'], $item['article']['price']);
          $stmt->execute();
      }

      // Commit the transaction
      $con->commit();
      $_SESSION['order_id'] = $orderId; // Store order ID in session
      $_SESSION['total'] = $total;

      header("Location: finish.php"); // Redirect to payment page

  } catch (Exception $e) {
      // Rollback the transaction in case of error
      $con->rollback();

      // Log and send error response
      error_log('Error placing order: ' . $e->getMessage());
      echo json_encode(['success' => false, 'message' => 'Error placing order: ' . $e->getMessage()]);
  }
} else {
  // Invalid request method
  echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}

$con->close();
?>