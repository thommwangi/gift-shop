<?php
if(isset($_POST['submit'])){
$mysqli = new mysqli("localhost", "102600", "choco95*", "giftit");
 

if($mysqli === false){
    die("ERROR: Could not connect. " . $mysqli->connect_error);
}

$FullName = $mysqli->real_escape_string($_REQUEST['fullname']);
$address = $mysqli->real_escape_string($_REQUEST['address']);
$paddress = $mysqli->real_escape_string($_REQUEST['paddress']);
$phone = $mysqli->real_escape_string($_REQUEST['phone']);
$password = $mysqli->real_escape_string($_REQUEST['pass']);
$email = $mysqli->real_escape_string($_REQUEST['email']);
$Gender = $mysqli->real_escape_string($_REQUEST['gender']);

 
// attempt insert query execution
 $hashed = password_hash($password,PASSWORD_DEFAULT);
$sql = "INSERT INTO register (FullName, password, email, Gender, address, paddress, PhoneNumber) VALUES ('$FullName','$hashed', '$email','$Gender','$address','$paddress','$phone')";
if($mysqli->query($sql) === true){
    header("Location: loginForm.php");
} else{
    echo "ERROR: Could not able to execute $sql. " . $mysqli->error;
}
 
// Close connection
$mysqli->close();
}
?>