<?php include('app_logic.php'); ?>
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

	<form class="login-form" action="login.php" method="post" style="text-align: center;">
		<p>
			We sent an email to  <b><?php echo $_GET['email'] ?></b> to help you recover your account. 
		</p>
	    <p>Please login into your email account and click on the link we sent to reset your password</p>
	</form>
		
</body>
</html>