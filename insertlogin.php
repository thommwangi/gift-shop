<?php
$mysqli = new mysqli("localhost", "102600", "choco95*", "giftit");
if($mysqli === false){
    die("ERROR: Could not connect. " . $mysqli->connect_error);
}


//$User_Name = $mysqli->real_escape_string($_REQUEST['email']);
$User_Name=$_POST['email'];
//$Password = $mysqli->real_escape_string($_REQUEST['password']);
$Password=$_POST['password'];
//validation for recaptcha
$secretkey="6LcawawUAAAAALAlavmAagmiC65pZyT7goiRL-0f";
$responsekey=$_POST['g-recaptcha-response'];
$userip=$_SERVER['REMOTE_ADDR']; 

$url="https://www.google.com/recaptcha/api/siteverify?secret=$secretkey&response=$responsekey";
$response=file_get_contents($url);
$response=json_decode($response);
// if($response->success){


$query = "SELECT * FROM register WHERE email = '$User_Name';";
$results=$mysqli->query($query)or die($mysqli->error());

  $row=mysqli_fetch_array($results);
  $hashedpass=$row['password'];
 if($row['email']==$User_Name && password_verify($Password,$hashedpass)){
 	session_start();
 	$_SESSION["uid"] = $row["user_id"];
    $_SESSION["name"] = $row["fullname"]; 
    $_SESSION["email"] = $User_Name;

	$ip_add = getenv("REMOTE_ADDR");

 	//we have created a cookie in LoginForm.php page so if that cookie is available means user is not login

if (isset($_COOKIE["product_list"])) {
				$p_list = stripcslashes($_COOKIE["product_list"]);
				//here we are decoding stored json product list cookie to normal array
				$product_list = json_decode($p_list,true);
				for ($i=0; $i < count($product_list); $i++) { 
					//After getting user id from database here we are checking user cart item if there is already product is listed or not
					 $verify_cart = "SELECT Id FROM cart WHERE user_id =" . $_SESSION["uid"] . " AND p_id = " .$product_list[$i]."";
					$result  = mysqli_query($mysqli,$verify_cart);
					if(mysqli_num_rows($result) < 1){
						//if user is adding first time product into cart we will update user_id into database table with valid id
						$update_cart = "UPDATE cart SET user_id ='' " . $_SESSION['uid'] . " 'WHERE ip_add = '$ip_add' AND user_id = -1";
						mysqli_query($mysqli,$update_cart);
					}else{
						//if already that product is available into database table we will delete that record
						$delete_existing_product = "DELETE FROM cart WHERE user_id = -1 AND ip_add = '$ip_add' AND p_id = ".$product_list[$i];
						mysqli_query($mysqli,$delete_existing_product);
					}
				}
				//here we are destroying user cookie
				setcookie("product_list","",strtotime("-1 day"),"/");
				//if user is logging from after cart page we will send cart_login
				echo "cart_login";
				exit();
				
			}
			//if user is login from page we will send login successful message.
				echo "Login Successful! Welcome ".$row['fullname'];
 	header("Location: userprofile.php");
			exit();
 } else{
 	echo "Please Check The Recaptcha Box";
 	//header("Location: LoginForm.php");
 	
 }
 
// Close connection
$mysqli->close();

?>