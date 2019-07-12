<?php 
//require_once $_SERVER['DOCUMENT_ROOT'].'/core/init.php';
$mysqli = new mysqli("localhost", "102600", "choco95*", "giftit");
//session_start();
include '../core/init.php'; 
include 'includes/head.php';
//include '../helper/helper.php' ;
// $password = 'password';
// $hashed = password_hash($password,PASSWORD_DEFAULT);
// echo $hashed;




$email = ((isset($_POST['email']))?sanitize($_POST['email']):'');
$email=trim($email);
$password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
$password=trim($password);

$errors = array();
?>

<style>
    #login-form{
  width:50%;
  height:60%;
  border:2px solid #000;
  border-radius: 15px;
  box-shadow:7px 7px 15px rgba(0,0,0,0,6);
  margin:7% auto;
  padding:15px;
  background-color: white;
}
body{
    background-image:url("../images/background.jpg");
    background-size: 100vw 100vh;
    background-attachment:fixed;
}
</style>


<div id="login-form">
    <div>

        <?php
           if($_POST){
            
                if(empty($_POST['email']) || empty($_POST['password'])){
                    $errors[]= 'You Must Fill All Fields';
                }
                    //validate email
                    if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
                        $errors[] ='You must enter  valid email'; 
                    }

                    //password is more than 6 characters
                    if(strlen($password)<6){
                        $errors[]='Password must be more than 6 characters';
                    }
                    //check if email exists in the database
                    $query = $mysqli->query("SELECT * FROM users WHERE email = '$email'");
                    $user = mysqli_fetch_assoc($query);
                    $userCount = mysqli_num_rows($query);
                    if($userCount < 1){
                        $errors[] = 'That email does not exist in our database';
                    }
                    //check if password entered matches the one in the database
                    if(!password_verify($password, $user['password'])){
                        $errors[]= 'The password does not match our records, try again';
                    }

                    //check for errors
                    if(!empty($errors)){
                        echo display_errors($errors);
                    }else{
                        //log in user
                        $user_id=$user['id'];
                        login($user_id);
                    }
           } 

        ?>

    </div>
    <h2 class="text-center">Login</h2><hr>
    <form action="login.php" method="post">
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" class="form-control" value="<?=$email;?>">
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" class="form-control" value="<?=$password;?>">
        </div>
        <div class="form-group">
            <input type="submit" value="Login" class="btn btn-primary">
        </div>
    </form>
    <p class="text-right"><a href="../mainpage.php" alt="home">Visit Site</a></p>
</div>

<?php include 'includes/footer.php' ; ?>