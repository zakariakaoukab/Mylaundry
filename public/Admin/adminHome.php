<?php
// Admin side
session_start();
include('C:\xampp\htdocs\MyLaundry\public\includes\dbcon.php');
if(!isset($_SESSION['authenticated'])){
  $_SESSION['status'] = "Please login to access our services!";
  header("Location: ../signin.php");
  exit();
}

if(isset($_SESSION['auth_user']['role']) && $_SESSION['auth_user']['role'] === 'client') {
  $_SESSION['status'] = "Not Allowed";
  header("Location: ../signin.php");
}else {
 // Admin is authenticated, allow access
 $role = $_SESSION['auth_user']['role'];

}
 // SQL query to count clients with verify_status = 1 and role = 'client'
 $sql = "SELECT COUNT(*) as total_clients FROM users WHERE verify_status = 1 AND role = 'client'";
 $result = $con->query($sql);
 // Fetch the result
 $total_clients = 0;
 if ($result->num_rows > 0) {
     $row = $result->fetch_assoc();
     $total_clients = $row['total_clients'];
 }

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

// SQL query to sum the total column for all orders
$sqlll = "SELECT SUM(total) as total_income FROM orders";
$resulttt = $con->query($sqlll);

// Fetch the result
$total_income = 0;
if ($resulttt->num_rows > 0) {
    $row = $resulttt->fetch_assoc();
    $total_income = $row['total_income'];
}

// SQL query to get the last 5 orders along with the user's fname
$sqlorder = "
    SELECT o.order_id, o.order_date, o.status, u.fname
    FROM orders o
    JOIN users u ON o.id_user = u.id_user
    ORDER BY o.order_date DESC
    LIMIT 5
";

$resultorder = $con->query($sqlorder);

// Fetch the results
$orders = [];
if ($resultorder->num_rows > 0) {
    while($row = $resultorder->fetch_assoc()) {
      $row['status'] = strtolower($row['status']);
        $orders[] = $row;
    }
}

 $con->close();
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Boxicons -->
    <link
      href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css"
      rel="stylesheet"
    />
    <!-- My CSS -->
    <link rel="stylesheet" href="DashboardStyle.css" />

    <title>Admin Dashboard</title>
    <style>
     

     .status.paid {
            background: #FFCE26;
        }
        .status.delivered
        {
            background: #2ECC71;
        }
        #style-4::-webkit-scrollbar-track {
      -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
      background-color: #F5F5F5;
    }

    #style-4::-webkit-scrollbar {
      width: 5px;
      background-color: #000829;
    }

    #style-4::-webkit-scrollbar-thumb {
      background-color: #000829;
    }

    </style>
  </head>
  <body>
    <!-- SIDEBAR -->
    <section id="sidebar">
      <a href="#" class="brand">
        <i class="bx bxs-smile bx-tada-hover"></i>
        <span class="text">MyAdmin </span>
      </a>
      <ul class="side-menu top">
        <li class="active">
          <a href="adminHome.php">
            <i class="bx bxs-dashboard bx-spin-hover"></i>
            <span class="text">Dashboard</span>
          </a>
        </li>
        <li>
          <a href="UsersManagement.php">
            <i class="bx bxs-group"></i>
            <span class="text">Users Management</span>
          </a>
        </li>
        <li>
          <a href="Orders.php">
            <i class="bx bxs-cart"></i>
            <span class="text">Orders</span>
          </a>
        </li>
        <li>
          <a href="Message.html">
            <i class="bx bxs-message-dots"></i>
            <span class="text">Message</span>
          </a>
        </li>
        <li>
          <a href="Articles.php">
            <i class="bx bx-closet"></i>
            <span class="text">Articles</span>
          </a>
        </li>
      </ul>
      <ul class="side-menu">
       
        <li>
          <a href="../logout.php" class="logout">
            <i class="bx bxs-log-out-circle"></i>
            <span class="text">Logout</span>
          </a>
        </li>
      </ul>
    </section>
    <!-- SIDEBAR -->

    <!-- CONTENT -->
    <section id="content">
      <!-- NAVBAR -->
      <nav>
        <i class="bx bx-menu"></i>
        <form action="#">
          <div class="form-input">
            <input type="search" placeholder="Search..." />
            <button type="submit" class="search-btn">
              <i class="bx bx-search"></i>
            </button>
            
          </div>
          
        </form>
        <input type="checkbox" id="switch-mode"  hidden />
        <label for="switch-mode" class="switch-mode"></label>
        <a href="#" class="notification">
          <i class="bx bxs-bell"></i>
          <span class="num">8</span>
        </a>

        <!-- Notification Container -->
        <div class="notification-container">
          <!-- Notification Items -->
          <div class="notification-item">
            <p>This is a notification message.</p>
          </div>
          <div class="notification-item">
            <p>This is another notification message.</p>
          </div>
          <!-- Add more notification items as needed -->
        </div>
      </nav>
      <!-- NAVBAR -->

      <!-- MAIN -->
      <main id="style-4">
        <div class="head-title">
          <div class="left">
            <h1>Welcome <?php echo $_SESSION['auth_user']['fname']; ?></h1>
            <ul class="breadcrumb">
              <li>
                <a href="#">Dashboard</a>
              </li>
              <li><i class="bx bx-chevron-right"></i></li>
              <li>
                <a class="active" href="#">Home</a>
              </li>
            </ul>
          </div>
          <!--
					
				<a href="#" class="btn-download">
					<i class='bx bxs-cloud-download' ></i>
					<span class="text">Download PDF</span>
				</a>

				-->
        </div>

        <ul class="box-info">
          <li>
            <i class="bx bxs-calendar-check"></i>
            <span class="text">
              <h3><?php echo $total_orders; ?></h3>
              <p>New Orders</p>
            </span>
          </li>
          <li>
            <i class="bx bxs-group"></i>
            <span class="text">
              <h3><?php echo $total_clients; ?></h3>
              <p>Users</p>
            </span>
          </li>
          <li>
            <i class="bx bxs-dollar-circle"></i>
            <span class="text">
              <h3><?php echo $total_income." DH"; ?></h3>
              <p>Total income</p>
            </span>
          </li>
        </ul>

        <div class="table-data">
          <div class="order">
            <div class="head">
              <h3>Recent Orders</h3>
              <i class="bx bx-search"></i>
              <i class="bx bx-filter"></i>
            </div>
            <table>
              <thead>
                <tr>
                  <th>User</th>
                  <th>Date Order</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                  <?php
                  

                  // Loop through the orders and generate table rows
                  foreach ($orders as $order) {
                      echo "<tr>
                              <td>
                                  <img src='../img/people.png' />
                                  <p>{$order['fname']}</p>
                              </td>
                              <td>" . date('Y-m-d - H:i:s', strtotime($order['order_date'])) . "</td>
                              <td><span class='status {$order['status']}'>{$order['status']}</span></td>
                            </tr>";
                  }
                  ?>
              </tbody>
            </table>
          </div>
        </div>
          
      </main>
      <!-- MAIN -->
    </section>
    <!-- CONTENT -->

    <script src="adminDashboard.js"></script>
  </body>
</html>
