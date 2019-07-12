<script type="text/javascript">
    function passwordMatch($id, $password) {
    global $mysqli;
 
    $userdata = getUserDataByUserId($id);
 
    $makePassword = makePassword($password, $userdata['salt']);
 
    if($makePassword == $userdata['password']) {
        return true;
    } else {
        return false;
    }
 
    // close connection
    $connect->close();
}
 
function changePassword($id, $password) {
    global $mysqli;
 
    $salt = salt(32);
    $makePassword = makePassword($password, $salt);
 
    $sql = "UPDATE register SET password = '$makePassword', salt = '$salt' WHERE user_id = $id";
    $query = $mysqli->query($sql);
 
    if($query === TRUE) {
        return true;
    } else {
        return false;
    }
}
</script>
<?php
$mysqli = new mysqli("localhost", "102600", "choco95*", "giftit");
if($mysqli === false){
    die("ERROR: Could not connect. " . $mysqli->connect_error);
}
session_start();



if($_POST) {
    $currentpassword = $_POST['currentpassword'];
    $newpassword = $_POST['password'];
    $confirmpassword = $_POST['confirmpassword'];
 
    if($currentpassword == "") {
        echo "Current Password field is required <br />";
    }
 
    if($newpassword == "") {
        echo "New Password field is required <br />";
    }
 
    if($confirmpassword == "") {
        echo "Confirm Password field is required <br />";
    }
 
    if($currentpassword && $newpassword && $confirmpassword) {
        if(passwordMatch($_SESSION["uid"], $currentpassword) === TRUE) {
 
            if($newpassword != $confirmpassword) {
                echo "New password does not match confirm password <br />";
            } else {
                if(changePassword($_SESSION["uid"], $newpassword) === TRUE) {
                    echo "Successfully updated";
                } else {
                    echo "Error while updating the information <br />";
                }
            }
             
        } else {
            echo "Current Password is incorrect <br />";
        }
    }
}
