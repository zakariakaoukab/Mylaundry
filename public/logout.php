<?php
session_start();
unset($_SESSION['auth_user']);
unset($_SESSION['authenticated']);
$_SESSION['status']="Logged out ";
header("Location: signin.php");

?>