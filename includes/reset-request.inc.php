<!-- used to send email to user and create a token -->
<?php 
    require_once('../PHPMailer/PHPMailerAutoload.php');

     $useremail=$_POST["email"];

    // $mail=new PHPMailer();
    // $mail ->IsSmtp();
    // $mail ->SMTPDebug = 1;
    // $mail ->SMTPAuth = true;
    // $mail ->SMTPSecure = 'ssl';
    // $mail ->Host = "smtp.gmail.com";
    // $mail ->Port = 465; //or 587
    // $mail ->IsHTML(true);
    // $mail ->Username = "thomasmwangi96@gmail.com";
    // $mail ->Password = "froyo95*";
    // $mail ->SetFrom("thomasmwangi96@gmail.com");
    // $mail ->Subject = $subject;
    // $mail ->Body = $message;
    // $mail ->AddAddress($usermail);
    if(isset($_POST['reset-request-submit'])){
        $selector=bin2hex(random_bytes(8));
        $token=random_bytes(32);

        $url="http://localhost/GIFT-SHOP/create-new-password.php?selector=" .$selector . "&validator=" . bin2hex($token);

        //expiry date for the token
        $expires = date("U") + 1800;


        //connecting to db
        $mysqli = new mysqli("localhost", "102600", "choco95*", "giftit");
        if($mysqli === false){
            die("ERROR: Could not connect. " . $mysqli->connect_error);
        }

        $useremail=$_POST["email"];

        //accessing db to delete any existing token for the specified email address
        //$stmt=$mysqli->prepare("DELETE FROM pwdReset WHERE pwdResetEmail=?");
        $stmt=mysqli_stmt_init($mysqli);
        if(!mysqli_stmt_prepare($stmt,"DELETE FROM pwdReset WHERE pwdResetEmail=?")){
            echo"there was an error";
            exit();

        }else{
            mysqli_stmt_bind_param($stmt, "s", $useremail);
            mysqli_stmt_execute($stmt);
        }

        //$mysqli="INSERT INTO pwdReset (pwdResetEmail,pwdResetSelector,pwdResetToken,pwdResetExpires) VALUES (?,?,?,?)";

        $stmt=mysqli_stmt_init($mysqli);
        if(!mysqli_stmt_prepare($stmt,"INSERT INTO pwdReset (pwdResetEmail,pwdResetSelector,pwdResetToken,pwdResetExpires) VALUES (?,?,?,?)")){
            echo"there was an error";
            exit();

        }else{
            //hashing token before inserting to db
             $hashedtoken = password_hash($token, PASSWORD_DEFAULT);
            mysqli_stmt_bind_param($stmt, "ssss", $useremail, $selector, $hashedtoke,$expires);

            mysqli_stmt_execute($stmt);
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);


        //sending the email
        $to=$useremail;

        $subject="Reset your password for Gift Shop";

        $message='<p>We received your password reset request. The link
        to reset your password is down below. If you did not make this request you can ignore this email</p>';

        $message .='<p>Here is your password resent link: </br>';
        $message .='<a href="' . $url . '">' . $url . '</a>
        </p>';

        $headers ="From: Gift Shop <usegiftshop@gmail.com>\r\n";
        $headers .="Reply To: thomasmwangi96@gmail.com\r\n";

        //to allow html styling in email
        $headers .= "Content type: text/email\r\n";


        $useremail=$_POST["email"];

        $mail=new PHPMailer();
        $mail ->IsSmtp();
        $mail ->SMTPDebug = 1;
        $mail ->SMTPAuth = true;
        $mail ->SMTPSecure = 'ssl';
        $mail ->Host = "smtp.gmail.com";
        $mail ->Port = 465; //or 587
        $mail ->IsHTML(true);
        $mail ->Username = "thomasmwangi96@gmail.com";
        $mail ->Password = "froyo95*";
        $mail ->SetFrom("thomasmwangi96@gmail.com");
        $mail ->Subject = $subject;
        $mail ->Body = $message;
        $mail ->AddAddress("thomas.mwangi@strathmore.edu");

        if(!$mail->Send()){
            echo "Mail not sent";
        }else{
            echo "Mail sent";
        }
       // mail($to, $subject, $message, $headers);

        header("Location: ../reset-password.php?reset=success");



    }else{
        header("Location: ../LoginForm.php");
    }
?>