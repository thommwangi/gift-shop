<?php
$sqli=$mysqli = new mysqli("localhost", "102600", "choco95*", "giftit");
session_start();
 //require_once $_SERVER['DOCUMENT_ROOT'].'/GIFT-SHOP/config.php';
 require_once '../helper/helper.php';
 //include '../helper/helper.php';


if(isset($_SESSION['SBUser'])){
    $user_id=$_SESSION['SBUser'];
    $query = $mysqli->query("SELECT * FROM users WHERE id='$user_id'");
    $user_data = mysqli_fetch_assoc($query);
    $fn = explode(' ', $user_data['full_name']);
    $user_data['first'] = $fn[0];
    $user_data['last'] = $fn[1];
}
if(isset($_SESSION['success_flash'])){
    echo '<div class="bg-success"><p class="text-success text-center">'.$_SESSION['success_flash'].'</p></div>';
    unset($_SESSION['success_flash']);
}

if(isset($_SESSION['error_flash'])){
    echo '<div class="bg-danger"><p class="text-danger text-center">'.$_SESSION['error_flash'].'</p></div>';
    unset($_SESSION['error_flash']);
}
//session_destroy();

?>

