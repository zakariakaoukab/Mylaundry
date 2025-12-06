<?php 
include('C:\xampp\htdocs\MyLaundry\public\includes\dbcon.php');
session_start();
// Check if the user is authenticated and has admin role
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
$query="SELECT * FROM users";
$result= mysqli_query($con,$query);



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Management</title>
       <!-- Boxicons -->
       <link
       href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet" />
     <!-- My CSS  -->
     <link rel="stylesheet" href="DashboardStyle.css" />
  <!--Bootstrap CSS
 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">--> 

          <!-- Tables -->
     <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css" />

     <style> 
    /*add full-width input fields*/ 
    input[type=email],
    input[type=text],
input[type=password] {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: block; /* Change from inline-block to block */
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
    width: 45%; /* Adjusted width */
    margin-right: 5px; /* Added margin for spacing */
}

.signupbtn {
    float: right; /* Move sign-up button to the right */
    width: 45%; /* Adjusted width */
    margin-left: 5px; /* Added margin for spacing */
}

/* Define the modal content background */
.modal-content {
    background-color: #fefefe;
    margin: 5% auto 15% auto;
    border: 1px solid #888;
    width: 50%; /* Adjusted width */
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

/* Add transition to smooth out the closing animation */
.modal-content {
    transition: transform 0.5s ease, opacity 0.5s ease;
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

@media screen and (max-width: 600px) {
    .cancelbtn,
    .signupbtn {
        width: 100%;
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
          <li >
            <a href="adminHome.php">
              <i class="bx bxs-dashboard bx-spin-hover"></i>
              <span class="text">Dashboard</span>
            </a>
          </li>
          <li class="active">
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
              <input type="search" id="searchInput" placeholder="Search..." />
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
              <ul class="breadcrumb">
                <li>
                  <a href="#">Dashboard</a>
                </li>
                <li><i class="bx bx-chevron-right"></i></li>
                <li>
                  <a class="active" href="#">Users Management</a>
                </li>
              </ul>
            </div>
           
                      
                  <a href="#" class="btn-download" onclick="document.getElementById('id01').style.display='block'">
                    <i class='bx bxs-user-plus'></i>
                    <span class="text">Create user</span>
                  </a>
  
                       
          </div>

<!--Modal for create user-->
        <div id="id01" class="modal"> 
        <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">×</span> 
        <form class="modal-content animate" action="create-user.php" method="POST"> 
         <h3 style="text-align: center; margin: 20px 20px; color:gray">
            Create New Account 
         </h3>
         <hr style="margin-bottom: 10px;"> 
            <div class="container"> 
            <label><b>First name</b></label> 
                <input type="text" placeholder="First name" name="fname" required> 
                <label><b>Last name</b></label> 
                <input type="text" placeholder="Last name" name="lname" required> 
               
                <label><b>Email</b></label> 
                <input type="text" placeholder="Enter Email" name="email" required> 
  
                <label><b>Password</b></label> 
                <input type="password" placeholder="Enter Password" name="psw" required> 
                <label><b>Adresse</b></label> 
                <input type="text" placeholder="Adresse of the client" name="Adresse" required> 
                <label><b> City</b></label> 
                <input type="text" placeholder="City" name="City" required> 
  
                <label><b>ZIP</b></label> 
                <input type="text" placeholder="ZIP" name="ZIP" required> 
                <label><b>phone</b></label> 
                <input type="text" placeholder="Phone" name="Phone" required> 
                <label><b>Role</b></label> 
                  <select name="role" required>
                  <option value="admin">admin</option>
                  <option value="client">client</option>
                  </select> 
               
  
                <div class="clearfix"> 
                    <button type="button" id="cancelCreateBtn" class="cancelbtn">Cancel</button> 
                    <button type="submit" class="signupbtn" name="save">Save</button> 
                </div> 
            </div> 
        </form> 
    </div> 

<!--Modal for edit user -->
<div id="editModal" class="modal"> 
    <span onclick="closeEditModal()" class="close" title="Close Modal">×</span> 
    <form class="modal-content animate" action="update-user.php" method="POST"> <!-- Change action to point to the script for updating users -->
        <h3 style="text-align: center; margin: 20px 20px; color: gray">Edit User Details</h3> <!-- Modify the title -->
        <hr style="margin-bottom: 10px;"> 
        <div class="container"> 
        <label><b>First name</b></label> 
                <input type="text" placeholder="First name" name="fname"  id="editFirstName" required> 
                <label><b>Last name</b></label> 
                <input type="text" placeholder="Last name" name="lname" id="editLastName" required> 
               
                <label><b>Email</b></label> 
                <input type="email" placeholder="Enter Email" name="email" id="editEmail" required> 
  
                <label><b>Password</b></label> 
                <input type="password" placeholder="Enter Password" name="psw" id="editPassword" required> 
                <label><b>Adresse</b></label> 
                <input type="text" placeholder="Adresse of the client" name="Adresse" id="editAdresse" required> 
                <label><b> City</b></label> 
                <input type="text" placeholder="City" name="City" id="editCity" required> 
  
                <label><b>ZIP</b></label> 
                <input type="text" placeholder="ZIP" name="ZIP" id="editZIP" required> 
                <label><b>phone</b></label> 
                <input type="text" placeholder="Phone" name="Phone" id="editPhone" required> 
                <label><b>Role</b></label> 
                  <select name="role"  id="editRole" required>
                  <option value="client">client</option>
                  <option value="admin">admin</option>
                  </select> 
            <input type="hidden" name="userId" id="editUserId">
            <!-- Add a button to submit the form and save changes -->
            <div class="clearfix"> 
                <button type="button" id="cancelEditBtn" class="cancelbtn">Cancel</button> 
                <button type="submit" class="signupbtn" name="save">Save Changes</button> <!-- Change button text -->
            </div> 
        </div> 
    </form> 
</div> 





              <!-- Table -->
    <table id="myTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>phone</th>
                <th>city</th>
                <th>Adresse</th>
                <th>ZIP</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            while ($row = mysqli_fetch_assoc($result)) {
            ?>
                <tr id="userRow_<?php echo $row['id_user']; ?>">
                    <td><?php echo $row['id_user']; ?></td>
                    <td><?php echo $row['fname']; ?></td>
                    <td><?php echo $row['lname']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['phone']; ?></td>
                    <td><?php echo $row['city']; ?></td>
                    <td><?php echo $row['street']; ?></td>
                    <td><?php echo $row['zip']; ?></td>
                    <td><?php echo $row['role']; ?></td>
                    <td class="actions">
                        <!-- Buttons for actions -->
                        <button class="delete-btn" onclick="confirmDelete(<?php echo $row['id_user']; ?>)" title="Delete this user"><i class="bx bx-trash"></i></button>
                        <button class="update-btn" onclick="openEditModal(<?php echo $row['id_user']; ?>)" title="Update informations of this user"><i class="bx bx-edit"></i></button>
                        <button class="ban-btn" title="Ban this User" onclick="confirmBan(<?php echo $row['id_user']; ?>)"><i class="bx bx-error"></i></button>
                        <button class="permet-btn" title="Grant permission to this user" onclick="grantPermission(<?php echo $row['id_user']; ?>)" ><i class="bx bxs-medal"></i></button>

                    </td>
                </tr>
            <?php 
            }   
            ?>
        </tbody>
    </table>
        </main>
        
 <!-- MAIN -->
 
</section>
<!-- CONTENT -->

<script src="adminDashboard.js"></script>
  <!-- Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
 <!-- DataTables JS -->
 <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>




 <script>
 // JavaScript function to handle granting permission to a user
function grantPermission(userId) {
    if (confirm("Are you sure you want to grant permission Again to this user ?")) {
        // If the user confirms, redirect to permit-user.php with the user ID
        window.location.href = 'permit-user.php?userId=' + userId;
    }
}


  //ban user
function confirmBan(userId) {
    if (confirm("Are you sure you want to ban this user?")) {
        // If the user confirms, redirect to a script to handle the ban action
        window.location.href = 'ban-user.php?userId=' + userId;
    }
}


// delete user:
function confirmDelete(userId) {
        if (confirm("Are you sure you want to delete this user?")) {
            // User confirmed deletion, proceed with AJAX request
            deleteUser(userId);
        } else {
            // User canceled deletion
            return false;
        }
    }

    function deleteUser(userId) {
        // Perform AJAX request to delete user
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // If deletion was successful, remove the row from the table
                    var row = document.getElementById("userRow_" + userId);
                    row.parentNode.removeChild(row);
                } else {
                    // Handle deletion failure
                    console.error('Error deleting user:', xhr.responseText);
                }
            }
        };
        xhr.open('POST', 'delete-user.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send('userId=' + userId);
    }
// Edit user Modal
function openEditModal(userId) {
    
    // Send AJAX request to retrieve user information
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                // Parse JSON response
                var userData = JSON.parse(xhr.responseText);

                // Populate input fields with user information
                document.getElementById("editUserId").value = userData.id_user;
                document.getElementById("editFirstName").value = userData.fname;
                document.getElementById("editLastName").value = userData.lname;
                document.getElementById("editEmail").value = userData.email;
                document.getElementById("editPassword").value = userData.password;
                document.getElementById("editAdresse").value = userData.street;
                document.getElementById("editCity").value = userData.city;
                document.getElementById("editZIP").value = userData.zip;
                document.getElementById("editPhone").value = userData.phone;
                document.getElementById("editRole").value = userData.role;

               
            } else {
                // Handle failure to retrieve user information
                console.error('Error retrieving user information:', xhr.responseText);
            }
        }
    };
    xhr.open('GET', 'get-user.php?id=' + userId, true);
    xhr.send();

    // Show the edit modal
    document.getElementById("editModal").style.display = "block";

}





  //Modal animation 
  // Function to apply animation and close modal
function closeModal(modal) {
    modal.classList.add('close-animation'); // Add close animation class
    setTimeout(function() {
        modal.style.display = "none"; 
        modal.classList.remove('close-animation'); // Remove animation class after animation ends
    }, 500); // Adjust the time to match the animation duration
}

window.onclick = function(event) { 
    var modalCreate = document.getElementById('id01');
    var modalEdit = document.getElementById('editModal');

    // Check if click is outside of create modal
    if (event.target == modalCreate) { 
        closeModal(modalCreate);
    } 
    
    // Check if click is outside of edit modal
    if (event.target == modalEdit) { 
        closeModal(modalEdit);
    } 

    // Apply animation when Cancel button is clicked on the create modal
    var cancelCreateBtn = document.getElementById('cancelCreateBtn');
    if (cancelCreateBtn && event.target == cancelCreateBtn) {
        closeModal(modalCreate);
    }

    // Apply animation when Cancel button is clicked on the edit modal
    var cancelEditBtn = document.getElementById('cancelEditBtn');
    if (cancelEditBtn && event.target == cancelEditBtn) {
        closeModal(modalEdit);
    }
}



     $(document).ready(function () {
         $('#myTable').DataTable();
     });
 </script>
 <script>
  // remove default search provided by jquery datatable
  $('#myTable').DataTable({
       "dom":"lrtip"
         });
    // customize search      
    $(document).ready(function () {
      
        // Capture input value when it changes
        $('#searchInput').on('keyup', function () {
            var searchText = $(this).val().toLowerCase(); // Convert input to lowercase for case-insensitive search

            // Loop through all table rows
            $('#myTable tbody tr').each(function () {
                var rowData = $(this).text().toLowerCase(); // Convert row data to lowercase for case-insensitive search
                if (rowData.includes(searchText)) {
                    $(this).show(); // Show row if it contains the search text
                } else {
                    $(this).hide(); // Hide row if it does not contain the search text
                }
            });
        });
    });
</script>

</body>
</html>