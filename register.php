<?php
	$mysqli = new mysqli("localhost", "102600", "choco95*", "giftit");

	$fullname_err = $address_err = $paddress_err = $phone_err = $password_err = $email_err = $gender_err = "";

	if($_SERVER["REQUEST_METHOD"] == "POST"){

		
		//Validate Fullname
		if(empty(trim($_POST["fullname"]))){
			$fullname_err = "Please enter your fullname";
		}else if(str_word_count($_POST["fullname"])!==2){
			$fullname_err = "Please enter your full name";
		}else{
			$fullname = trim($_POST["fullname"]);
		}

		//validate address
		if (empty(trim($_POST["address"]))) {
			$address_err = "Please enter your address";
		}else{
			$address = trim($_POST["address"]);
		}

		//validate paddress
		if (empty(trim($_POST["paddress"]))) {
			$paddress_err = "Please enter your personal address";
		}else{
			$paddress = trim($_POST["paddress"]);
		}

		//validate phone number
		if (empty(trim($_POST["phone"]))) {
			$phone_err = "Please enter your phone number";
		}else if(strlen($_POST["phone"])!==9){
			$phone_err = "Please enter a valid phone number";
		}else{
			$phone = trim($_POST["phone"]);
		}

		//validate email
		if (empty(trim($_POST["email"]))) {
			$email_err = "Enter a valid email";
		}else{
			//Prepare a select statement
			$sql = "SELECT user_id FROM register WHERE email=?";

			if ($stmt = $mysqli->prepare($sql)) {
				//Bind the variables to the select statement as parameters
				$stmt->bind_param("s",$param_email);

				//Set the parameters
				$param_email = trim($_POST["email"]);

				//Attemt to execute the prepared statement
				if ($stmt->execute()) {
					$stmt->store_result();

					if ($stmt->num_rows == 1) {
						$email_err = "This email has already been taken";
					}else{
						$email = trim($_POST["email"]);
					}
				}else{
					echo "Oops! Something went wrong. Please try again later.";
				}
			}
			$stmt->close();
		}

		//validate password
		if(empty(trim($_POST["pass"]))){
			$password_err = "Please enter a password.";     
		}else{
			$password = trim($_POST["pass"]);
		}

		//validate gender
		if (empty(trim($_POST["gender"]))) {
			$gender_err = "Please chose your gender";
		}else{
			$gender = trim($_POST["gender"]);
		}
		//validation for recaptcha
		$secretkey="6LcawawUAAAAALAlavmAagmiC65pZyT7goiRL-0f";
		$responsekey=$_POST['g-recaptcha-response'];
		$userip=$_SERVER['REMOTE_ADDR']; 

		$url="https://www.google.com/recaptcha/api/siteverify?secret=$secretkey&response=$responsekey";
		$response=file_get_contents($url);
		$response=json_decode($response);
		if($response->success){
		

		// if (empty($email_err)) {
			//Prepare an inser statement
			$sql = "INSERT INTO register(email,password,gender,fullname,address,paddress,
			PhoneNumber) VALUES(?,?,?,?,?,?,?)";

			if ($stmt = $mysqli->prepare($sql)) {
				//Bind variables to the prepared statement as parameters
				$stmt->bind_param("sssssss", $param_email, $param_password,$param_gender,
					$param_fullname,$param_address,$param_paddress,$param_phone);
					//Set the parameters
					$param_email = $email;
					//Create a password hash
					$param_password = password_hash($password,PASSWORD_BCRYPT);
					$param_gender = $gender;
					$param_fullname = $fullname;
					$param_address = $address;
					$param_paddress = $paddress;
					$param_phone = $phone;

					//Attempt to execute the prepared statement
					if ($stmt->execute()) {
						# Redirect to login page
						header("Location: loginForm.php");
					}else{
						echo "Something went wrong";
					}
			}
			$stmt->close();
		}
	}
		$mysqli->close();
	
?>

<!DOCTYPE html>
<html>
<head>
	<title>Create Account</title>
	<script type="text/javascript" src="jquery331.js"></script>
	<meta charset="UTF-8">
	<link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>
	<link rel="stylesheet" type="text/css" href="main.css">
	<script src="main.js"></script>
	

</head>
<body>
	<div class="container">
		<div class="info">
        <h1>GIFT IT.COM</h1><span>Made with <i class="fa fa-heart"></i> by Rosanne and Thomas</span>
        </div>
        <div class="form">
        	<div class="thumbnail"><img src="images/download.jpg"/></div>
    	<form name="register" id="signup_form" class="register-form" action="insertregister.php" method="post" >
  		<input class="input100" type="text" name="fullname" placeholder="Full Name" required="fullname">
		<span class="focus-input100" data-placeholder="&#xe82a;"><?= $fullname_err;?></span>
		<input class="input100" type="text" name="address" placeholder="Mailing Address" required="address">
		<span class="focus-input100" data-placeholder="&#xe82a;"><?= $address_err;?></span>
		<input class="input100" type="text" name="paddress" placeholder="Physical Address" required="paddress">
		<span class="focus-input100" data-placeholder="&#xe82a;"><?= $paddress_err;?></span>
		<input class="input100" type="text" name="phone" placeholder="PhoneNumber" required="phone">
		<span class="focus-input100" data-placeholder="&#xe82a;"><?= $phone_err;?></span>
		<input class="input100" type="password" name="pass" placeholder="Password" required="pass">
		<span class="focus-input100" data-placeholder="&#xe80f;"><?= $password_err;?></span>
     	<input class="input100" type="password" name="pass1" placeholder="Re-Enter Password" required="pass1">
		<span class="focus-input100" data-placeholder="&#xe80f;"></span>
    	<input type="text" name="email" placeholder="email address" required="email"/>
		<span class="focus-input100" data-placeholder="&#xe80f;"><?= $email_err;?></span>

    	<div class="styled-select black rounded">
		<select name="gender">
			<option>Select Gender</option>
			<option>Male</option>
			<option>Female</option>
			<option>Other</option>
		</select>
		<span class="focus-input100" data-placeholder="&#xe80f;"><?= $gender_err;?></span>
		</div><br>
		<!-- <div class="g-recaptcha" data-sitekey="6LcawawUAAAAAB8tCZlBjs631uu_zrIVyhdCAneJ"></div>
      <br/> -->
		<input type="text" name="submit" value="signup" style="display: none;">
    	<button type="submit" id="btn2" value="Create Account">Create Account</button>
		<p class="message">Already registered? </p><button id="btn1"><a href="LoginForm.php" style="color: #F7F9FA" >Login</a></button>
  	</form>
        </div>
        <div class="col-md-8" id="signup_msg">
			</div>
</div>
<script type="text/javascript">
		function validate_form(){
			
			var password=document.Register.pass.value
			var retype=document.Register.pass1.value
			var email=document.Register.email.value
			var positionAt=email.indexOf("@")
			var positionDot=email.indexOf(".")
			if(document.Register.fullname.value==null||document.Register.fullname.value==""){
				alert("Full Name field cannot be Empty")
				return false;
			}
			if(document.Register.gender.value==null||document.Register.gender.value==""){
				alert("Pick a gender to continue")
				return false;
			}
			if(document.Register.address.value==null||document.Register.address.value==""){
				alert("Enter Mailing address to continue")
				return false;
			}
			if(document.Register.paddress.value==null||document.Register.paddress.value==""){
				alert("Enter Physical address to continue")
				return false;
			}
			if(document.Register.phone.value==null||document.Register.phone.value==""){
				alert("Enter PhoneNumber to continue")
				return false;
			}
			if(password.length<8){
				alert("Password cannot be less than 8 characters")
				return false
			}
			for(var i=0;i<password.length;i++){
                if(password.charAt(i)!=retype.charAt(i)){
                    alert("Passwords must match");
                    return false;
                }
            }
			if(positionAt<1||(positionAt+2)>positionDot||(positionDot+2)>=email.length){
				alert("Email is not of the correct syntax")
				return false;
			}
				alert("Success!!!")
				alert(document.Register.Units.value)
				return true;
		}
	</script>
	<!-- <script src="https://www.google.com/recaptcha/api.js" async defer></script> -->
</body>
</html>