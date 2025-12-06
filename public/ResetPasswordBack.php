<?php
session_start();
include('C:\xampp\htdocs\MyLaundry\public\includes\dbcon.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
//Load Composer's autoloader
require 'C:\xampp\htdocs\MyLaundry\vendor\autoload.php';

function send_password_reset($getname,$getemail,$token){
    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);
    
    try {
        //Server settings
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'mylaundry.rabat@gmail.com';                     //SMTP username
        $mail->Password   = 'epny zxsk zwoa peki';                               //SMTP password
        $mail->SMTPSecure = 'tls';                                   //Enable implicit TLS encryption
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    
        //Recipients
        $mail->setFrom('mylaundry.rabat@gmail.com', 'MyLaundry');
        $mail->addAddress($getemail,$getname);     //Add a recipient
                                                  //Name is optional
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Password Reset for Mylaundry website';
        $email_body="<h2>Want to reset your Password ?</h2>
        <h3>Click on link so you can change your Password. </h3>
        <br><br>
        <a href='http://localhost/MyLaundry/public/password-change.php?token=$token&email=$getemail'>Change my Password.</a>
            <h6>if you did not request to reset your password on mylaundry website, Please ignore this message.  </h6>
            ";
        $mail->Body = $email_body ;
    
        $mail->send();
        // echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
    
    }
if(isset($_POST['password_reset_link'])){
    $email=mysqli_real_escape_string($con, $_POST['email']);
    $token =md5(rand());
    $check_email ="SELECT email FROM users WHERE email='$email' LIMIT 1";
    $check_email_run= mysqli_query($con,$check_email);
    if(mysqli_num_rows($check_email_run)> 0){
        $row =mysqli_fetch_array($check_email_run);
        $getname= $row['fname'];
        $getemail= $row['email'];
        $update_token = "UPDATE users SET verify_token='$token' WHERE email='$getemail' LIMIT 1";
        $update_token_run = mysqli_query($con, $update_token);

        if($update_token_run){
            send_password_reset($getname,$getemail,$token);
            $_SESSION['status']="We sent you an email with a reset password link";
            header("Location: reset-password.php");
            exit(0);
        }
        else{
            $_SESSION['status']="Something went wrong";
            header("Location: reset-password.php");
            exit(0);
        }


    }else{
        $_SESSION['status']="No Email Found.";
        header("Location: reset-password.php");
        exit(0);
    }

}


//update the password
if(isset($_POST['password_update'])){
    $email=mysqli_real_escape_string($con, $_POST['email']);
    $new_password=mysqli_real_escape_string($con, $_POST['new_password']);
    $confirm_password=mysqli_real_escape_string($con, $_POST['confirmn_new_password']);
    $token=mysqli_real_escape_string($con, $_POST['password_token']);


    if(!empty($token)){
        if(!empty($email) && !empty($new_password) && !empty($confirm_password)){
           //check token is valid 
           $check_token="SELECT verify_token FROM users WHERE verify_token='$token' LIMIT 1";
           $check_token_run=mysqli_query($con,$check_token);
           if(mysqli_num_rows($check_token_run)>0){
            if($new_password== $confirm_password){
                $update_password="UPDATE users SET password='$new_password' WHERE verify_token='$token' LIMIT 1";
                $update_password_run=mysqli_query($con,$update_password);

                if($update_password_run){
                    $updated_token = md5(rand());
                    $update_token="UPDATE users SET verify_token='$updated_token' WHERE verify_token='$token' LIMIT 1";
                    $update_token_run=mysqli_query($con,$update_token);

                    $_SESSION['status']="Password updated successfully";
                    $show_success_div= true;
                    header("Location: client\profile.php");
                    exit(0);
                }
                else{
                    $_SESSION['status']="did not Update Password.Something went wrong";
                    header("Location: signin.php");
                    exit(0); 
                }

            }
            else{
                $_SESSION['status']="New Password and Confirm Password does not match !";
                header("Location: password-change.php?token=$token&email=$email");
                exit(0); 
            }
           }else{
            $_SESSION['status']="Token expired.Try Again and be sure to click on the latest message we sent you";
            header("Location: reset-password.php");
            exit(0);

           }


        }
        else{
            $_SESSION['status']="All Fields are necessary.";
            header("Location: password-change.php?token=$token&email=$email");
            exit(0);
        }

    }
    else{
        $_SESSION['status']="No Token found. Please enter your Email to sent you a verification link";
        header("Location: reset-password.php");
        exit(0);

    }

}



?>