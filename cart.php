 <?php 

$mysqli = new mysqli("localhost", "102600", "choco95*", "Giftit");
// require_once 'Include/mainpageconnect.php';
include 'Include/head.php';
// include 'insertlogin.php';
include 'Include/navigationcart.php';
// include 'Include/headerfull.php';
session_start();
 	// $_SESSION["uid"] = $row["user_id"];
if (isset($_SESSION["uid"])) 
{
$sql="SELECT * FROM register WHERE user_id ='" . $_SESSION['uid'] . "'";
$result=$mysqli->query($sql) or die("Error " . mysqli_error($mysqli));
$register=mysqli_fetch_assoc($result);
}
else
{

}
                        // print_r($result);
                        // echo "<br>";
                       
                        // echo "user session " . $_SESSION['uid'];


?>


<div class="space"></div>
<div class="wait overlay">
	<div class="loader"></div>
</div>
	
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-8" id="cart_msg">
				<!--Cart Message--> 
			</div>
			<div class="col-md-2"></div>
		</div>
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-8">
				<div class="panel panel-primary">
					<div class="panel-heading">Cart Checkout</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-2 col-xs-2"><b>Action</b></div>
							<div class="col-md-2 col-xs-2"><b>Product Image</b></div>
							<div class="col-md-2 col-xs-2"><b>Product Name</b></div>
							<div class="col-md-2 col-xs-2"><b>Quantity</b></div>
							<div class="col-md-2 col-xs-2"><b>Product Price</b></div>
							<div class="col-md-2 col-xs-2"><b>Price in $</b></div>
						</div>

						<div id="cart_checkout"></div>
						</div>

					</div>
					<div class="panel-footer"></div>

				</div>
			</div>
			<div class="col-md-2"></div>
			
		</div>

<div class="modal fade" id="checkoutModal" tabindex="-1" role="dialog" aria-labelledby="checkoutModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="checkoutModalLabel">CHECK OUT</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<h3>Full Name</h3><br><h3><?php echo $register['fullname']; ?>.</h3>
      	 <h3>Phone Number:</h3><br><h3><?php echo $register['PhoneNumber']; ?></h3>
      	  <h3>Email Address:</h3><br><h3><?php echo $register['email']; ?></h3>
        <h3>Shipping Address</h3><br><h3><?php echo $register['address']; ?>.</h3>
        <h3>Physical Address</h3><br><h3><?php echo $register['paddress']; ?></h3>
       
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Back to Cart</button>
       <!-- <a href="cart.php"> <button type="button" class="btn btn-primary">Edit Details</button></a> -->
      </div>
    </div>
  </div>
</div>




	</div>
</div>
 <?php
 include 'Include/footer.php';
 ?>