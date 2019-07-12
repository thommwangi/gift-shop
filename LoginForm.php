<?php

include 'cart_man.php';
if (isset($_SESSION["uid"])) {
	header("location:userprofile.php");
}
if (isset($_POST["login_user_with_product"])) {
	$product_list = $_POST["product_id"];
	$json_e = json_encode($product_list);
	setcookie("product_list",$json_e,strtotime("+1 day"),"/","","",TRUE);
}
// $mysqli = new mysqli("localhost", "root", "", "giftit");

// $login_err = $password_err = $email_err = "";

// if($_SERVER["REQUEST_METHOD"] == "POST"){
// 	//validate email
// 	if (empty(trim($_POST["email"]))) {
// 		$email_err = "Enter a valid email";
// 	}else{
// 		$email = trim($_POST["email"]);		
// 	}
// 	//validate password
// 	if(empty(trim($_POST["pass"]))){
// 		$password_err = "Please enter a password.";     
// 	}else{
// 		$password = trim($_POST["pass"]);
// 	}

// 	if(empty($email_err) && empty($password_err)){
// 		//Prepare a select statement
// 		$sql = "SELECT user_id,email,password,fullname FROM register WHERE email=?";

// 		if ($stmt = $mysqli->prepare($sql)) {
// 			# Bind variables to the prepared statement as parameters
// 			$stmt->bind_param("s",$param_email);

// 			//Set the parameters
// 			$param_email = $email;

// 			//Attempt to execute the prepared statement
// 			if ($stmt->execute()) {
// 				# Store result
// 				$stmt->store_result();

// 				#Check if username exists then verify password
// 				if ($stmt->num_rows == 1) {
// 					# Bind results to variables
// 					$stmt->bind_result($user_id,$email,$hashed_password,$fullname);
// 					if ($stmt->fetch()) {
// 						# Check password
// 						if (password_verify($password,$hashed_password)) {
// 							# Password is correct so start a new session
// 							session_start();
// 							#Store session variables
							
//                             $_SESSION["loggedin"] = true;
//                             $_SESSION["uid"] = $user_id;
// 							$_SESSION["name"] = $fullname; 
// 							$_SESSION["email"] = $email; 
// 							header("Location: userprofile.php"); 
// 						}else{
// 							$password_err = "The password you entered was not valid";
// 							$login_err = "Login Failed. Please Try Again";
// 						}
// 					}
// 				}else{
// 					$email_err = "No account found with that email";
// 					$login_err = "Login Failed. Please Try Again";
// 				}
// 			}else{
// 				echo "Oops! Something went wrong. Please try again later.";
// 			}
// 		}
// 		$stmt->close();
// 	}
// 	$mysqli->close();
// }


?>

<!DOCTYPE html>
<html>
<head>
	<script type="text/javascript" src="jquery331.js"></script>
	<meta charset="UTF-8">
	<title>Login Form</title>
	<link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>
	<link rel="stylesheet" type="text/css" href="main.css">
	<script src="Script.js"></script>
	<script src="main.js"></script>
	

</head>
<body>
	<!-- CONTAINER CLASS -->
<div class="container">
	<div class="info">
    <h1>GIFT IT.COM</h1><span>Made with <i class="fa fa-heart"></i> by Rosanne and Thomas</span>
  </div>
  <div class="form">
  <span class="focus-input100" data-placeholder="&#xe80f;"></span>

  <div class="thumbnail"><img src="images/download.jpg"/></div>
  <form name="Login" class="login-form" id="login" action="insertlogin.php" method="post" >
   		<input class="input100" type="email" name="email" placeholder="Enter your email">
		<span class="focus-input100" data-placeholder="&#xe82a;"></span>
    	<input class="input100" type="password" name="password" placeholder="Password">
		<span class="focus-input100" data-placeholder="&#xe80f;"></span>

		<!-- <?php 
			// if(isset($_GET['newpwd'])){
			// 	if($_GET['newpwd'] == "passwordupdated"){
			// 		echo '<p class="signupsuccess">Your Password has been reset!</p>';
			// 	}
			// }
		?> -->
		
		<div class="g-recaptcha" data-sitekey="6LcawawUAAAAAB8tCZlBjs631uu_zrIVyhdCAneJ"></div>
      
		<p> <a href="enter_email.php">Forgot Password</a></p>
		<input type="text" name="submit" value="signup" style="display: none;">
    	<button type="submit" id="btn" style="text-decoration: underline"><!-- <a href="mainpage.html" style="color: #F7F9FA" > -->Login</button>
    <p class="message">Not registered? </p><button id="btn1"><a href="register.php" style="color: #F7F9FA" >Register</a></button>

  </form>
  <div class="panel-footer"><div id="e_msg"></div></div>
</div>
</div>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
</body>
</html>