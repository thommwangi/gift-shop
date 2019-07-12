<?php
$mysqli = new mysqli("localhost", "102600", "choco95*", "giftit");
require_once '../core/init.php'; 
//include '../helper/helper.php' ;
if(!is_logged_in()){
    login_error_redirect(); 
}
if(!has_permission('admin')){
    permission_error_redirect('index.php');
}
include 'includes/head.php';
include 'includes/navigation.php'; 
//query for deleting user
if(isset($_GET['delete'])){
        $delete_id = $_GET['delete'];
        $mysqli->query("DELETE FROM register WHERE user_id='$delete_id'");
        $_SESSION['success_flash'] = 'User has been deleted';
        header('Location: view_registeredusers.php');
}
//for adding new user
// if(isset($_GET['add'])){
//     $name=((isset($_POST['name']))?sanitize($_POST['name']):'');
//     $email=((isset($_POST['email']))?sanitize($_POST['email']):'');
//     $password=((isset($_POST['password']))?sanitize($_POST['password']):'');
//     $confirm=((isset($_POST['confirm']))?sanitize($_POST['confirm']):'');
//     $permissions=((isset($_POST['permissions']))?sanitize($_POST['permissions']):'');
//     $errors=array();

    //validation adding new user form
    // if($_POST){
    //     $emailQuery=$mysqli->query("SELECT * FROM users WHERE email='$email'");
    //     $emailCount = mysqli_num_rows($emailQuery);

    //     if($emailCount != 0){
    //         $errors[]='The Entered Email Already Exists In The Database';
    //     }
    //     $required = array('name','email','password','confirm','permissions');
    //     foreach($required as $f){
    //         if(empty($_POST[$f])){
    //             $errors[]='You Must Fill Out All Fields!';
    //             break;
    //         }
    //     }
    //     if(strlen($password) <6){
    //         $errors[]='Your Password Must Be More Than 6 Charaters';
    //     }
    //     if($password != $confirm){
    //         $errors[]='Your Passwords Do Not Match';
    //     }
    //     if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
    //         $errors[]='You Must Enter A Valid Email';
    //     }
        
    //     if(!empty($errors)){
    //         echo display_errors($errors);
    //     }else{
    //         //add new user to database
    //         $hashed = password_hash($password,PASSWORD_DEFAULT);
    //         $mysqli->query("INSERT INTO users (full_name,email,password,permissions) VALUES ('$name','$email','$hashed','$permissions')");
    //         $_SESSION['success_flash'] = 'User Has Been Added';
    //         header('Location: users.php');
    //     }
    // }
?>
    <!-- <h2 class="text-center">Add New User</h2><hr>
    <form action="users.php?add=1" method="post">
    <div class="form-group col-md-6">
    <label for="name">Full Name:</label>
    <input type="text" name="name" id="name" class="form-control" value="<?=$name;?>">
    </div>
    <div class="form-group col-md-6">
    <label for="email">Email:</label>
    <input type="email" name="email" id="email" class="form-control" value="<?=$email;?>">
    </div>
    <div class="form-group col-md-6">
    <label for="password">Password:</label>
    <input type="password" name="password" id="password" class="form-control" value="<?=$password;?>">
    </div>
    <div class="form-group col-md-6">
    <label for="confirm">Confirm Password:</label>
    <input type="password" name="confirm" id="confirm" class="form-control" value="<?=$confirm;?>">
    </div>
    <div class="form-group col-md-6">
    <label for="permissions">Permissions:</label>
    <select class="form-control" name="permissions">
    <option value=""<?=(($permissions == '')?'selected':'');?>></option>
    <option value="editor"<?=(($permissions == 'editor')?'selected':'');?>>Editor</option>
    <option value="admin,editor"<?=(($permissions == 'admin,editor')?'selected':'');?>>Admin</option>
    </select>
    </div>
    <div class="form-group col-md-6 text-right" style="margin-top:25px;">
    <a href="users.php" class="btn btn-default">Cancel</a>
    <input type="submit" value="Add User" class="btn btn-primary">
    </div>
    </form> -->

<?php


        //query from selecting data from Users
        $registereduserQuery = $mysqli->query("SELECT * FROM register");
        ?> 
        <h2>Registered Users</h2>
        <!--<a href="users.php?add=1" class="btn btn-success pull-right" id="add-product-btn">Add New User</a> -->
        <hr>
        <table class="table table-bordered table-striped table-condensed">
            <thead><th></th><th>Email</th><th>Gender</th><th>Full Name</th><th>Address</th><th>P Address</th><th>Phone Number</th></thead>
            <tbody>
            <?php while($user = mysqli_fetch_assoc($registereduserQuery)): ?> 
                <tr>
                    <td>
                    <!-- delete button -->
                    <?php if($user['user_id'] != $user['user_id']): ?>
                        <a href="view_registeredusers.php?delete=<?=$user['user_id']; ?>" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-remove-sign"></span></a>
                    <?php endif; ?>
                    </td>
                    <td><?= $user['email'];?></td>
                    <td><?= $user['gender'];?></td>
                    <td><?= $user['fullname']?></td>
                    <td><?= $user['address'];?></td>
                    <td><?= $user['paddress'];?></td>
                    <td><?= $user['PhoneNumber'];?></td>
                </tr>
<?php endwhile;?>
    </tbody>
    </table>
<?php include 'includes/footer.php'; ?>