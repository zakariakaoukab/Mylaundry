<?php
session_start();
include ('C:\xampp\htdocs\MyLaundry\public\includes\dbcon.php');

if(isset($_GET['token'])){
$token=$_GET['token'];
$verify_query="SELECT verify_token,verify_status FROM users WHERE verify_token='$token' LIMIT 1";
$verify_query_run=mysqli_query($con,$verify_query);
   if(mysqli_num_rows($verify_query_run)> 0){
    $row =mysqli_fetch_array($verify_query_run);
    if($row['verify_status'] == "0"){
        $clicked_token=$row['verify_token'];
        $update_query="UPDATE users SET verify_status='1' WHERE verify_token='$clicked_token' LIMIT 1";
        $update_query_run= mysqli_query($con,$update_query);
        if($update_query_run){
            $_SESSION['status']="Your Account has been verified Successfully !";
            header("Location: signin.php");

        }
        else{
            $_SESSION['status']="verification failed";
            header("Location: signup.php");
        }
    }
    else{
        $status_message = "Email Already verified.";
        $_SESSION['status']=$status_message;
        header("Location: signin.php");

    exit(0) ;

    }
   }
   else{
    $_SESSION['status']="This Token does not Exists";
    header("Location: signin.php");

    
   }
}
else{
$_SESSION['status'] = "Not Allowed";
header("Location: signup.php");
}


?>