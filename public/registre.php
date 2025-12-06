<?php
session_start();
include ('C:\xampp\htdocs\MyLaundry\public\includes\dbcon.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
//Load Composer's autoloader
require 'C:\xampp\htdocs\MyLaundry\vendor\autoload.php';


function sendemail_verify($firstname,$email,$verify_token){
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
    $mail->addAddress($email,$firstname);     //Add a recipient
                                              //Name is optional
    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Email verification from MyLaundry web site';
    $email_body="<h2>You have Registered with MyLaundry web site</h2>
    <h3>Verify your email adress to login with the below link  </h3>
    <br><br>
    <a href='http://localhost/MyLaundry/public/verify-email.php?token=$verify_token'>http://localhost/MyLaundry/public/verify-email.php?token=$verify_token</a>
    ";
    $mail->Body = $email_body ;

    $mail->send();
    // echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

}

if (isset($_POST['signup'])) {
    $lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $street = $_POST['street'];
    $city = $_POST['city'];
    $zip = $_POST['zip'];
    $verify_token = md5(rand());


//email already exist
$check_email_query = "SELECT email from users WHERE email='$email' LIMIT 1";
$check_email_query_run = mysqli_query($con,$check_email_query);
if(mysqli_num_rows($check_email_query_run) > 0)
{
    $_SESSION['status']="Email Id already Exists. Please login to Access Your Account !";
    header("Location: signin.php");
   
}
else
{
   $query="INSERT INTO users(fname,lname,email,street,phone,password,city,zip,verify_token) Values('$firstname','$lastname','$email','$street','$phone','$password','$city','$zip','$verify_token')"; 
   $query_run= mysqli_query($con,$query);

   if($query_run){
    sendemail_verify("$firstname","$email","$verify_token");
    $_SESSION['status']="Registration Successfull ! Please verify your Email Adress .";
    header("Location: signup.php");

   
   }
   else{
    $_SESSION['status'] = "Registration Failed, Try Again " ;
    header("Location: signup.php");

   }
}

}


?>