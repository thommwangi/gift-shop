<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <title>Password Reset PHP</title>
    <style>
        body {
	background: #3b5998;
	font-size: 1.1em;
	font-family: sans-serif;
}
a {
	text-decoration: none;
}
form {
	width: 25%;
	margin: 70px auto;
	background: white;
	padding: 10px;
	border-radius: 3px;
}
h2.form-title {
	text-align: center;
}
input {
	display: block;
	box-sizing: border-box;
	width: 100%;
	padding: 8px;
}
form .form-group {
	margin: 10px auto;
}
form button {
	width: 100%;
	border: none;
	color: white;
	background: #3b5998;
	padding: 15px;
	border-radius: 5px;
}
.msg {
	margin: 5px auto;
	border-radius: 5px;
	border: 1px solid red;
	background: pink;
	text-align: left;
	color: brown;
	padding: 10px;
}
    </style>
	<!-- <link rel="stylesheet" href="main.css"> -->
</head>
<body>
	<form class="login-form" action="app_logic.php" method="post">
		<h2 class="form-title">New password</h2>
		<!-- form validation messages -->
		//<?php
		 //include('messages.php'); 
		 ?>
		<div class="form-group">
			<label>New password</label>
			<input type="password" name="new_pass">
		</div>
		<div class="form-group">
			<label>Confirm new password</label>
			<input type="password" name="new_pass_c">
		</div>
		<div class="form-group">
			<button type="submit" name="new_password" class="login-btn">Submit</button>
		</div>
	</form>
</body>
</html>