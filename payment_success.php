<?php

session_start();
if(!isset($_SESSION["uid"])){
	header("location:mainpage.php");
}
include 'Include/head.php';
include 'Include/navigationprofile.php';
// include 'Include/headerfull.php';


if (isset($_GET["st"])) {

	# code...
	$trx_id = $_GET["tx"];
		$p_st = $_GET["st"];
		$amt = $_GET["amt"];
		$cc = $_GET["cc"];
		$cm_user_id = $_GET["cm"];
		$c_amt = $_COOKIE["ta"];
	if ($p_st == "Completed") {

		

		$mysqli = new mysqli("localhost", "102600", "choco95*", "Giftit");
		$sql = "SELECT p_id,quantity FROM cart WHERE user_id = '$cm_user_id'";
		$query = mysqli_query($mysqli,$sql);
		if (mysqli_num_rows($query) > 0) {
			# code...
			while ($row=mysqli_fetch_array($query)) {
			$product_id[] = $row["p_id"];
			$quantity[] = $row["quantity"];
			}

			for ($i=0; $i < count($product_id); $i++) { 
				$sql = "INSERT INTO orders (user_id,product_id,quantity,trx_id,p_status) VALUES ('$cm_user_id','".$product_id[$i]."','".$quantity[$i]."','$trx_id','$p_st')";
				mysqli_query($mysqli,$sql);
			}

			$sql = "DELETE FROM cart WHERE user_id = '$cm_user_id'";
			if (mysqli_query($mysqli,$sql)) {
				?>
					
						<div class="container-fluid" style="padding: 100px;>
						
							<div class="row">
								<div class="col-md-2"></div>
								<div class="col-md-10">
									<div class="panel panel-default">
										<div class="panel-heading"></div>
										<div class="panel-body">
											<h1>Thankyou </h1>
											<hr/>
											<p>Hello <?php echo "<b>".$_SESSION["name"]."</b>"; ?>,Your payment process is 
											successfully completed and your Transaction id is <b><?php echo $trx_id; ?></b><br/>
											you can continue your Shopping <br/></p>
											<a href="userprofile.php" class="btn btn-success btn-lg">Continue Shopping</a>
										</div>
										<div class="panel-footer"></div>
									</div>
								</div>
								<div class="col-md-2"></div>
							</div>
						</div>
						
					</body>
					</html>

				<?php
			}
		}else{
			header("location:mainpage.php");
		}
		
	}
}



?>

















































