<?php
// Admin side
session_start();
include('C:\xampp\htdocs\MyLaundry\public\includes\dbcon.php');
if (!isset($_SESSION['authenticated'])) {
  $_SESSION['status'] = "Please login to access our services!";
  header("Location: ../signin.php");
  exit();
}

if (isset($_SESSION['auth_user']['role']) && $_SESSION['auth_user']['role'] === 'client') {
  $_SESSION['status'] = "Not Allowed";
  header("Location: ../signin.php");
} else {
  // Admin is authenticated, allow access
  $role = $_SESSION['auth_user']['role'];
}





?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Users Management</title>
  <!-- Boxicons -->
  <link href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet" />


  <!-- My CSS -->
  <link rel="stylesheet" href="DashboardStyle.css" />
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css" />

  <style>
    /* Tooltip container */
    .tooltip {
      position: relative;
      display: inline-block;
      cursor: pointer;
    }

    /* Tooltip text */
    .tooltip .tooltiptext {
      visibility: hidden;
      width: 120px;
      background-color: black;
      color: white;
      text-align: center;
      border-radius: 6px;
      padding: 5px;
      position: absolute;
      z-index: 1;
      top: -30px;
      /* Adjust this value to position the tooltip above the row */
      left: 50%;
      transform: translateX(-50%);
      opacity: 0;
      transition: opacity 0.3s;
    }

    /* Tooltip text arrow */
    .tooltip .tooltiptext::after {
      content: "";
      position: absolute;
      bottom: 100%;
      left: 50%;
      margin-left: -5px;
      border-width: 5px;
      border-style: solid;
      border-color: black transparent transparent transparent;
    }

    /* Show the tooltip text on hover */
    .tooltip:hover .tooltiptext {
      visibility: visible;
      opacity: 1;
    }

    /*add full-width input fields*/
    input[type=text],
    input[type=password] {
      width: 100%;
      padding: 12px 20px;
      margin: 8px 0;
      display: block;
      /* Change from inline-block to block */
      border: 2px solid #ccc;
      box-sizing: border-box;
    }

    button {
      border-radius: 50px;
      background-color: black;
      color: white;
      padding: 14px 20px;
      margin: 5px 0;
      cursor: pointer;
      width: 100%;
    }

    /*set styles for the cancel button*/
    .cancelbtn {
      padding: 14px 20px;
      background-color: #FF2E00;
    }

    /* Center the cancel and signup buttons */
    .clearfix {
      content: "";
      clear: both;
      display: flex;
      justify-content: space-between;
    }

    .cancelbtn {
      float: left;
      width: 45%;
      /* Adjusted width */
      margin-right: 5px;
      /* Added margin for spacing */
    }

    .signupbtn {
      float: right;
      /* Move sign-up button to the right */
      width: 45%;
      /* Adjusted width */
      margin-left: 5px;
      /* Added margin for spacing */
    }

    /* Define the modal content background */
    .modal-content {
      background-color: #fefefe;
      margin: 5% auto 15% auto;
      border: 1px solid #888;
      width: 60%;
      /* Adjusted width */
      border-radius: 30px;
      animation: slideIn 0.5s ease;

    }

    /* Define the container for inputs */
    .container {
      padding: 16px;
      /* Removed flex properties */
    }

    select {
      width: 100%;
      padding: 12px 20px;
      margin: 8px 0;
      display: inline-block;
      border: 2px solid #ccc;
      border-radius: 5px;
      box-sizing: border-box;
    }


    /* Define the modal background */
    .modal {
      display: none;
      position: fixed;
      z-index: 1;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0, 0, 0, 0.4);
      padding-top: 60px;
      animation: fadeIn 0.5s ease;

    }

    /* Define the close button */
    .close {
      position: absolute;
      right: 35px;
      top: 15px;
      color: #000;
      font-size: 40px;
      font-weight: bold;
    }

    /* Define the close hover and focus effects */
    .close:hover,
    .close:focus {
      color: red;
      cursor: pointer;
    }

    /* Define clearfix */
    .clearfix::after {
      content: "";
      clear: both;
      display: table;
    }

    /* Define the animation for the modal closing */
    .modal.close-animation {
      animation: fadeOut 0.5s ease, slideOut 0.5s ease;
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

    /* Add transition to smooth out the closing animation */
    .modal-content {
      transition: transform 0.5s ease, opacity 0.5s ease;
    }


    /* Define the modal content fade out animation */
    @keyframes fadeOut {
      from {
        opacity: 1;
      }

      to {
        opacity: 0;
      }
    }

    /* Define the modal content slide out animation */
    @keyframes slideOut {
      from {
        transform: translateY(0);
      }

      to {
        transform: translateY(-100px);
      }
    }

    /* Define the animation for the modal */
    @keyframes fadeIn {
      from {
        opacity: 0;
      }

      to {
        opacity: 1;
      }
    }

    /* Define the animation for the modal content */
    @keyframes slideIn {
      from {
        transform: translateY(-100px);
      }

      to {
        transform: translateY(0);
      }
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
      <li>
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
      <li class="active">
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
          <input type="search" id="searchInput" placeholder="Search..." />
          <button type="submit" class="search-btn">
            <i class="bx bx-search"></i>
          </button>
        </div>
      </form>
      <input type="checkbox" id="switch-mode" hidden />
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

          <ul class="breadcrumb">
            <li>
              <a href="adminHome.html">Dashboard</a>
            </li>
            <li><i class="bx bx-chevron-right"></i></li>
            <li>
              <a class="active" href="Orders.php">Orders</a>
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




      <div class="articleTableContainer">
        <table id="myTable" class="display" style="width:100%">
          <thead>
            <tr>
              <th>Order ID</th>
              <th>User ID</th>
              <th>Total</th>
              <th>Status</th>
              <th>Order Date</th>
              <th>Pickup Date</th>
              <th>Delivery Date</th>
              <th>Articles</th>
            </tr>
          </thead>
          <tbody>


          </tbody>
        </table>
      </div>
    </main>
    <!-- MAIN -->
  </section>
  <!-- CONTENT -->



  <!-- Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <!-- DataTables JS -->
  <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
  <script src="adminDashboard.js"></script>
  <script>
    $(document).ready(function() {
      var table = $('#myTable').DataTable({
        "ajax": "fetch_orders.php",
        "columns": [{
            "data": "order_id"
          },
          {
            "data": "id_user"
          },
          {
            "data": "total"
          },
          {
            "data": "status"
          },
          {
            "data": "order_date"
          },
          {
            "data": "pickupDate"
          },
          {
            "data": "deliveryDate"
          },
          {
            "data": "articles"
          }
        ],
        "searching": false // Disable the default search box
      });

      // Add click event listener to table rows
      $('#myTable tbody').on('click', 'tr', function() {
        var data = table.row(this).data();
        var orderId = data.order_id;
        var confirmChange = confirm("Are you sure you want to change the status of this order to 'Delivered'?");

        if (confirmChange) {
          // Send AJAX request to update the order status
          $.ajax({
            url: 'update_order_status.php',
            type: 'POST',
            data: {
              order_id: orderId
            },
            success: function(response) {
              var result = JSON.parse(response);
              if (result.success) {
                alert('Order status updated to Delivered');
                // Optionally, you can reload the table data to reflect the change
                table.ajax.reload();
              } else {
                alert('Failed to update order status: ' + result.message);
              }
            },
            error: function() {
              alert('Error updating order status');
            }
          });
        }
      });

      // Custom search box functionality
      $('#searchInput').on('keyup', function() {
        var searchText = $(this).val().toLowerCase();
        $('#myTable tbody tr').each(function() {
          var rowData = $(this).text().toLowerCase();
          if (rowData.includes(searchText)) {
            $(this).show();
          } else {
            $(this).hide();
          }
        });
      });
 
    });
  </script>
</body>

</html>