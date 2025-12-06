<?php
session_start();
include('C:\xampp\htdocs\MyLaundry\public\includes\dbcon.php');

if(isset($_POST['login'])) {
    if(trim($_POST['email']) && trim($_POST['password'])) {
        $email=mysqli_real_escape_string($con,$_POST['email']);
        $password=mysqli_real_escape_string($con,$_POST['password']);
        $login_query= "SELECT * FROM users WHERE email='$email' AND password='$password' LIMIT 1";
        $login_query_run= mysqli_query($con,$login_query);

        if(mysqli_num_rows($login_query_run) > 0) {
            $row= mysqli_fetch_array($login_query_run);
            if ($row['verify_status'] == "banned") {
                $_SESSION['status'] = "Your account has been banned. Please contact support for more information.";
                header("Location: signin.php");
                exit();
            }

            if($row['verify_status'] == "1") {
                $_SESSION['authenticated']=TRUE ;

                $_SESSION['auth_user']=[
                    'id_user' => $row['id_user'],
                    'fname' => $row['fname'],
                    'lname' => $row['lname'],
                    'email' => $row['email'],
                    'phone' => $row['phone'],
                    'role' => $row['role'],
                ];
               
                if ($row['role'] == 'admin') {
                         // Store admin login event
                        $adminId = $row['id_user'];
                        $adminName = $row['fname'] . ' ' . $row['lname'];
                        $dateEvent = date('Y-m-d H:i:s');
                        $ipAdmin = $_SERVER['REMOTE_ADDR']; // Use $_SERVER['REMOTE_ADDR'] to get the admin's IP address
                        $comment = "Admin logged in";
                        $typeEvent = "Login";
    
                       // Insert the event into the Event_Trace table
                        $insert_event_query = "INSERT INTO Event_Trace (idEvent, DateEvent, IP_admin, Comment, TypeEvent, AdminId, AdminName) 
                           VALUES (NULL, '$dateEvent', '$ipAdmin', '$comment', '$typeEvent', '$adminId', '$adminName')";
                          mysqli_query($con, $insert_event_query);
                        


                    // Redirect to admin interface
                    header("Location: admin/adminHome.php");
                    exit();
                } else {
                    // Redirect to client interface
                    header("Location: client/hours.php");
                    exit();
                }
                } else {
                $_SESSION['status'] = "Your account is not verified yet.";
                header("Location: signin.php");
                exit();
            }
        } else {
            $_SESSION['status']="Invalid email or Password";
            header("Location: signin.php");
            exit();
        }
    } else {
        $_SESSION['status']="Invalid email or Password";
        header("Location: signin.php");
        exit();
    }
}
?>
