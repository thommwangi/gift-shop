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

//check if user is logged in
if(!is_logged_in()){
    login_error_redirect();
}


$hashed = $user_data['password'];
$old_password = ((isset($_POST['old_password']))?sanitize($_POST['old_password']):'');
$old_password=trim($old_password);

$password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
$password=trim($password);

$confirm = ((isset($_POST['confirm']))?sanitize($_POST['confirm']):'');
$confirm=trim($confirm);

$new_hashed = password_hash($password, PASSWORD_DEFAULT);
$user_id = $user_data['id'];
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
            
                if(empty($_POST['old_password']) || empty($_POST['password']) || empty($_POST['confirm'])){
                    $errors[]= 'You Must Fill All Fields';
                }
                    

                    //password is more than 6 characters
                    if(strlen($password)<6){
                        $errors[]='Password must be more than 6 characters';
                    }
                    //check if new password matches confirm
                    if($password != $confirm){
                        $errors[]='The new Passwords Do Not Match';
                    }
                    //check if password entered matches the one in the database
                    if(!password_verify($old_password, $hashed)){
                        $errors[]= 'Your Old Password Does Not Match Our Database';
                    }

                    //check for errors
                    if(!empty($errors)){
                        echo display_errors($errors);
                    }else{
                        //change password
                        $mysqli->query("UPDATE users SET password = '$new_hashed' WHERE id = '$user_id' ");
                        $_SESSION['success_flash'] = 'Your Password Has Been Updated';
                        header('Location: index.php');
                    }
           } 

        ?>

    </div>
    <h2 class="text-center">Change Password</h2><hr>
    <form action="change-password.php" method="post">
        <div class="form-group ">
            <label for="old_password">Old Password:</label>
            <input type="password" name="old_password" id="old_password" class="form-control" value="<?=$old_password;?>">
        </div>
        <div class="form-group ">
            <label for="password">New Password:</label>
            <input type="password" name="password" id="password" class="form-control" value="<?=$password;?>">
        </div>
        
        <div class="form-group">
            <label for="confirm">Confirm New Password:</label>
            <input type="password" name="confirm" id="confirm" class="form-control" value="<?=$confirm;?>">
        </div>
        
        <div class="form-group ">
        <a href="index.php" class="btn btn-default">Cancel</a>
            <input type="submit" value="Login" class="btn btn-primary">
        </div>

    </form>
    <p class="text-right"><a href="../mainpage.php" alt="home">Visit Site</a></p>
</div>

<?php include 'includes/footer.php' ; ?>