<?php
session_start();
if(!isset($_SESSION['authenticated'])){
    $_SESSION['status']="Please Login to Access Our Services !";
    header("Location: signin.php");
}
?>
