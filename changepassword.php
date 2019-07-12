<?php
require_once 'mainpageconnect.php';
session_start();
if(!isset($_SESSION["uid"])){
	header("location:LoginForm.php");
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Change Password</title>
	<?php
	
 
?>
<script type="text/javascript" src="jquery331.js"></script>
	<meta charset="UTF-8">
	<title>Change Password</title>
	<link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>
	<link rel="stylesheet" type="text/css" href="main.css">
	<script src="Script.js"></script>
	<script src="main.js"></script>
</head>
<body>
<div class="container">
	<div class="info">
    <h1>GIFT IT.COM</h1><span>Made with <i class="fa fa-heart"></i> by Rosanne and Thomas</span>
  </div>
  <div class="form">
  <div class="thumbnail"><img src="images/download.jpg"/></div>
 <form action="insertnewpass.php" class="login-form" id="login"  method="POST">
 		<input class="input100" type="password" name="currentpassword" placeholder="currentpassword" autocomplete="off">
		<span class="focus-input100" data-placeholder="&#xe82a;"></span>

		<input class="input100" type="password" name="password" autocomplete="off" placeholder="New Password">
		<span class="focus-input100" data-placeholder="&#xe82a;"></span>

		<input class="input100" type="password" name="confirmpassword" autocomplete="off" placeholder="Confirm Password">
		<span class="focus-input100" data-placeholder="&#xe82a;"></span>
    
       
                <button type="submit"  id="btn">Change Password</button><br>
            
                <button type="button" id="btn1"><a href="userprofile.php" style="color: #F7F9FA">Back</button></a>
            
</form>
<div class="panel-footer"><div id="e_msg"></div></div>
</div>
</div>
 
</body>

</html>
 	
 