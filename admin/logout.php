<?php 
$mysqli = new mysqli("localhost", "102600", "choco95*", "giftit");
include '../core/init.php'; 
unset($_SESSION['SBUser']);
header('Location: login.php');

?>