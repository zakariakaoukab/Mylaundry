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
$query="SELECT * FROM articles";
$result= mysqli_query($con,$query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Articles</title>
       <!-- Boxicons -->
       <link
       href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css"
       rel="stylesheet"
     />
     <!-- My CSS -->
     <link rel="stylesheet" href="DashboardStyle.css" />
     <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css" />
<style> 
    /*add full-width input fields*/ 
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
    width: 60%; /* Adjusted width */
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
          <li >
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
          <li class="active">
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
                  <a href="adminHome.html">Dashboard</a>
                </li>
                <li><i class="bx bx-chevron-right"></i></li>
                <li>
                  <a class="active" href="#">Articles</a>
                </li>
              </ul>
            </div>
            <a href="#" class="btn-download" onclick="document.getElementById('id01').style.display='block'">
                    <i class='bx bxs-user-plus'></i>
                    <span class="text">Add Article</span>
                  </a>
          </div>
<!--Modal for create articles-->
<div id="id01" class="modal"> 
        <form class="modal-content animate" action="create-article.php" method="POST"> 
         <h3 style="text-align: center; margin: 20px 20px; color:gray">
            Add New Article
         </h3>
         <hr style="margin-bottom: 10px;"> 
            <div class="container"> 
            <label><b>Article name :</b></label> 
                <input type="text" placeholder="Article name " name="name" required> 
                <label><b>Category</b></label> 
                <input type="text" placeholder="Category" name="category" required> 
               
                <label><b>Price</b></label> 
                <input type="text" placeholder="Price" name="price" required> 
  
                <label><b>Description</b></label> 
                <input type="text" placeholder="Description" name="description"> 
               
               
  
                <div class="clearfix"> 
                    <button type="button" id="cancelBtn" class="cancelbtn">Cancel</button> 
                    <button type="submit" class="signupbtn" name="save">Save</button> 
                </div> 
            </div> 
        </form> 
    </div> 


<!--Modal for Edit Articles-->
<div id="editModal" class="modal"> 
    <form class="modal-content animate" action="update-article.php" method="POST"> 
        <h3 style="text-align: center; margin: 20px 20px; color:gray">Edit Article</h3>
        <hr style="margin-bottom: 10px;"> 
        <div class="container"> 
            <input type="hidden" id="editId" name="id"> <!-- Hidden input field to store the article ID -->
            <label><b>Article name :</b></label> 
            <input type="text" placeholder="Article name " id="editName" name="name" required> 
            <label><b>Category</b></label> 
            <input type="text" placeholder="Category" id="editCategory" name="category" required> 
            <label><b>Price</b></label> 
            <input type="text" placeholder="Price" id="editPrice" name="price" required> 
            <label><b>Description</b></label> 
            <input type="text" placeholder="Description" id="editDescription" name="description"> 
            <div class="clearfix"> 
                <button type="button" id="cancelEditBtn" class="cancelbtn">Cancel</button> 
                <button type="submit" class="signupbtn" name="save">Save</button> 
            </div> 
        </div> 
    </form> 
</div> 

<div id="articleTableContainer">
          <!-- Table -->
          <table id="myTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Article name</th>
                <th>Description</th>
                <th>Category</th>
                <th>Price</th>
                <th>Actions</th>
                
            </tr>
        </thead>
        <tbody>
        <?php 
            while ($row = mysqli_fetch_assoc($result)) {
            ?>
                <tr>
                    <td><?php echo $row['id_article']; ?></td>
                    <td><?php echo $row['article_name']; ?></td>
                    <td><?php echo $row['description']; ?></td>
                    <td><?php echo $row['category']; ?></td>
                    <td><?php echo $row['price']; ?></td>                  
                    <td class="actions">
                        <!-- Buttons for actions -->
        <form action="delete-article.php" method="POST" class="delete-form" onsubmit="return confirmDelete()">
            <input type="hidden" name="id" value="<?php echo $row['id_article']; ?>">
            <button type="submit" class="delete-btn" title="Delete this Article"><i class="bx bx-trash"></i></button>
        </form>                      
          <button class="update-btn"  title="Update this Article"><i class="bx bx-edit"></i></button>
                       

                    </td>
                </tr>
            <?php 
            }   
            ?>
        </tbody>
    </table>
</div>
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
  $(document).ready(function() {
    // Function to populate edit modal with article information
    $('.update-btn').click(function() {
        var row = $(this).closest('tr'); // Get the parent row of the clicked button
        var id = row.find('td:eq(0)').text(); // Get the article ID from the first column
        var name = row.find('td:eq(1)').text(); // Get the article name from the second column
        var category = row.find('td:eq(3)').text(); // Get the category from the fourth column
        var price = row.find('td:eq(4)').text(); // Get the price from the fifth column
        var description = row.find('td:eq(2)').text(); // Get the description from the third column

        // Set values in the edit modal
        $('#editId').val(id);
        $('#editName').val(name);
        $('#editCategory').val(category);
        $('#editPrice').val(price);
        $('#editDescription').val(description);

         // Display the edit modal
         $('#editModal').css('display', 'block');
    });

    // Close edit modal when cancel button is clicked
      // Close edit modal when cancel button is clicked
      $('#cancelEditBtn').click(function() {
            $('#editModal').css('display', 'none');
        });

    // Function to handle form submission for updating articles
    $('#editForm').submit(function(e) {
        e.preventDefault(); // Prevent the default form submission

        // Get the form data
        var formData = $(this).serialize();

        // Perform an AJAX request to update the article
        $.ajax({
            url: 'update-article.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.trim() === 'success') {
                    alert('Article updated successfully!');
                } else if (response.trim() === 'nochange') {
                    alert('No changes were made.');
                } else {
                    alert('Failed to update article. Please try again.');
                }
            },
            error: function() {
                alert('Failed to update article. Please try again.');
            }
        });
    });
});


    // Function to confirm article deletion
    function confirmDelete() {
        // Display confirmation message
        var confirmed = confirm("Are you sure you want to delete this article?");
        // Return true if confirmed, false otherwise
        return confirmed;
    }

  

//Modal animation 
window.onclick = function(event) { 
    var modalCreate = document.getElementById('id01');
    var modalEdit = document.getElementById('editModal');

    // Function to apply animation and close modal
    function closeModal(modal) {
        modal.classList.add('close-animation'); // Add close animation class
        setTimeout(function() {
            modal.style.display = "none"; 
            modal.classList.remove('close-animation'); // Remove animation class after animation ends
        }, 500); // Adjust the time to match the animation duration
    }

    // Check if click is outside of create modal
    if (event.target == modalCreate) { 
        closeModal(modalCreate);
    } 
  
    // Check if click is outside of edit modal
    if (event.target == modalEdit) { 
        closeModal(modalEdit);
    }

    // Apply animation when Cancel button is clicked
    var cancelBtn = document.getElementById('cancelBtn');
    if (cancelBtn && event.target == cancelBtn) {
        closeModal(modalCreate); // Assuming 'id01' is the modal to be closed
    }
}



  $(document).ready(function () {
         $('#myTable').DataTable();
     });
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