<?php

session_start();
if(!isset($_SESSION["uid"])){
	header("location:mainpage.php");
}
include 'Include/head.php';
include 'Include/navigationprofile.php';
include 'Include/leftbar.php';
$mysqli = new mysqli("localhost", "102600", "choco95*", "giftit");
?>

	<div class="container-fluid" style="padding: 100px;">
	
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-10">
				<div class="panel panel-default">
					<div class="panel-heading"></div>
					<div class="panel-body">
						<h1>Customer Order details</h1>
						<hr/>
						<?php
							
							$user_id = $_SESSION["uid"];
							$orders_list = "SELECT o.order_id,o.user_id,o.product_id,o.quantity,o.trx_id,o.p_status,p.Title,p.DiscountedPrice,p.Image FROM orders o,products p WHERE o.user_id='$user_id' AND o.product_id=p.Id";
							$query = mysqli_query($mysqli,$orders_list);
							if (mysqli_num_rows($query) > 0) {
								while ($row=mysqli_fetch_array($query)) {
									?>
										<div class="row">
											<div class="col-md-6">
												<img style="float:right;" src="<?php echo $row['Image']; ?>" class="img-responsive img-thumbnail"/>
											</div>
											<div class="col-md-6">
												<table>
													<tr><td>Product Name</td><td><b><?php echo $row["Title"]; ?></b> </td></tr>
													<tr><td>Product Price</td><td><b><?php echo "$ ".$row["DiscountedPrice"]; ?></b></td></tr>
													<tr><td>Quantity</td><td><b><?php echo $row["quantity"]; ?></b></td></tr>
													<tr><td>Transaction Id</td><td><b><?php echo $row["trx_id"]; ?></b></td></tr>
												</table>
											</div>
										</div>
									<?php
								}
							}
						?>
						
					</div>
					<div class="panel-footer"></div>
				</div>
			</div>
			<div class="col-md-2"></div>
		</div>
	</div>
</body>
</html>
















































