<?php
    use PHPMailer\PHPMailer\PHPMailer;
    //require_once "functions.php";

    if (isset($_POST['submitform'])) {
        $conn = new mysqli('localhost', '102600', 'choco95*', 'giftit');

        $email = $conn->real_escape_string($_POST['email']);

        $sql = $conn->query("SELECT id FROM register WHERE email='$email'");
        if ($sql->num_rows > 0) {

            $token = generateNewString();

	        $conn->query("UPDATE register SET token='$token', 
                      tokenExpire=DATE_ADD(NOW(), INTERVAL 5 MINUTE)
                      WHERE email='$email'
            ");

	        require_once "PHPMailer/PHPMailer.php";
	        require_once "PHPMailer/Exception.php";

	        $mail = new PHPMailer();
	        $mail->addAddress($email);
	       $mail ->SetFrom("admin@giftit.com","GIFT-IT");
	        $mail->Subject = "Reset Password";
	        $mail->isHTML(true);
	        $mail->Body = "
	            Hi,<br><br>
	            
	            In order to reset your password, please click on the link below:<br>
	            <a href='
	            http://domain.com/resetPassword.php?email=$email&token=$token
	            '>http://domain.com/resetPassword.php?email=$email&token=$token</a><br><br>
	            
	            Kind Regards,<br>
	            My Name
	        ";

	        if ($mail->send())
    	        exit(json_encode(array("status" => 1, "msg" => 'Please Check Your Email Inbox!')));
    	    else
    	        exit(json_encode(array("status" => 0, "msg" => 'Something Wrong Just Happened! Please try again!')));
        } else
            exit(json_encode(array("status" => 0, "msg" => 'Please Check Your Inputs!')));
    }
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Forgot Password System</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    <div class="container" style="margin-top: 100px;">
        <div class="row justify-content-center">
            <div class="col-md-6 col-md-offset-3" align="center">
                
                <input class="form-control" id="email" placeholder="Your Email Address"><br>
                <input type="submit" class="btn btn-primary" id="butto" name="submitform" value="Reset Password">
                <br><br>
                <p id="response"></p>
            </div>
        </div>
    </div>
    <script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script
  src="http://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
    <script type="text/javascript">
        var email = $("#email");

        $(document).ready(function () {
            $("#butto").click( function () {
                if (email.val() != "") {
                    email.css('border', '1px solid green');

                    $.ajax({
                       url: 'forgotPassword.php',
                       method: 'POST',
                       dataType: 'json',
                       data: {
                           email: email.val()
                       }, success: function (response) {
                            if (!response.success)
                                $("#response").html(response.msg).css('color', "red");
                            else
                                $("#response").html(response.msg).css('color', "green");
                        }
                    });
                } else
                    email.css('border', '1px solid red');
            });
        });
    </script>
</body>
</html>
