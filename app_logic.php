<?php 
require_once('PHPMailer/PHPMailerAutoload.php');
session_start();

$errors = [];

$user_id = "";
// connect to database
$db = mysqli_connect('localhost', '102600', 'choco95*', 'giftit');
$token = bin2hex(random_bytes(50));
$url="http://localhost/GIFT-SHOP/new_pass.php?token=" .$token;
// LOG USER IN
if (isset($_GET['token'])) {
    $_SESSION['token']=mysqli_real_escape_string($db,$_GET['token']);
    }

// if (isset($_POST['login_user'])) {
//   // Get username and password from login form
//   $user_id = mysqli_real_escape_string($db, $_POST['user_id']);
//   $password = mysqli_real_escape_string($db, $_POST['password']);
//   // validate form
//   if (empty($user_id)) array_push($errors, "Username or Email is required");
//   if (empty($password)) array_push($errors, "Password is required");

//   // if no error in form, log user in
//   if (count($errors) == 0) {
//     $password = md5($password);
//     $sql = "SELECT * FROM register WHERE username='$user_id' OR email='$user_id' AND password='$password'";
//     $results = mysqli_query($db, $sql);

//     if (mysqli_num_rows($results) == 1) {
//       $_SESSION['username'] = $user_id;
//       $_SESSION['success'] = "You are now logged in";
//       header('location: index.php');
//     }else {
//       array_push($errors, "Wrong credentials");
//     }
//   }
// }

/*
  Accept email of user whose password is to be reset
  Send email to user to reset their password
*/
if (isset($_POST['reset-password'])) {
  $email = mysqli_real_escape_string($db, $_POST['email']);
  // ensure that the user exists on our system
  $query = "SELECT email FROM register WHERE email='$email'";
  $results = mysqli_query($db, $query);

  if (empty($email)) {
    array_push($errors, "Your email is required");
  }else if(mysqli_num_rows($results) <= 0) {
    array_push($errors, "Sorry, no user exists on our system with that email");
  }
  // generate a unique random token of length 100
  $token = bin2hex(random_bytes(50));

  if (count($errors) == 0) {
    // store token in the password-reset database table against the user's email
    $sql = "INSERT INTO password_resets(email, token) VALUES ('$email', '$token')";
    $results = mysqli_query($db, $sql);

    // Send email to user with the token in a link they can click on
    // $to = $email;
    // $subject = "Reset your password on examplesite.com";
    // $msg = "Hi there, click on this <a href=\"new_password.php?token=" . $token . "\">link</a> to reset your password on our site";
    // $msg = wordwrap($msg,70);
    // $headers = "From: info@examplesite.com";
    // mail($to, $subject, $msg, $headers);

    $url="http://localhost/GIFT-SHOP/new_pass.php?token=" .$token;
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
        $mail ->AddAddress($email);

        if(!$mail->Send()){
            echo "Mail not sent";
        }else{
            echo "Mail sent";
        }




    header('location: pending.php?email=' . $email);
  }
}

// ENTER A NEW PASSWORD
if (isset($_POST['new_password'])) {
  $new_pass = mysqli_real_escape_string($db, $_POST['new_pass']);
  $new_pass_c = mysqli_real_escape_string($db, $_POST['new_pass_c']);

  // Grab to token that came from the email link
//    if (isset($_GET['token'])) {
//      $_SESSION['token']=mysqli_real_escape_string($db,$_GET['token']);
//      }
//    $token = $_SESSION['token'];

// $token=file_get_contents($url);
// echo $token;

  if (empty($new_pass) || empty($new_pass_c)) array_push($errors, "Password is required");
  if ($new_pass !== $new_pass_c) array_push($errors, "Password do not match");

  if (count($errors) == 0) {
    // select email address of user from the password_reset table 
    $sql = "SELECT email FROM password_resets LIMIT 1";
    $results = mysqli_query($db, $sql);
    
    $email = mysqli_fetch_assoc($results)['email'];
    

    if ($email) {
      $new_pass = password_hash($new_pass,PASSWORD_DEFAULT);
      $sql = "UPDATE users SET password='$new_pass' WHERE email='$email'";
      $results = mysqli_query($db, $sql);
      header('location: LoginForm.php');
    }
  }
}
?>