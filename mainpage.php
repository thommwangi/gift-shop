<?php 
session_start();
if(isset($_SESSION["uid"])){
	header("location:userprofile.php");
}
// require_once 'mainpageconnect.php';
include 'Include/head.php';
include 'Include/navigation.php';
include 'Include/headerfull.php';
include 'Include/leftbar.php';
//session_start();
///echo "My email is " . $_SESSION["email"];
include 'cart_man.php';
$mysqli = new mysqli("localhost", "102600", "choco95*", "giftit");
$sql="SELECT * FROM products WHERE Feature=1";
$featured=$mysqli->query($sql);

?>

	<!-- Main Content -->

	<div class="col-md-8"> 
		<div class="row">
			<h2 class="text-center">Feature products</h2>
			<?php while($product=mysqli_fetch_assoc($featured)):?>
					<div class="col-sm-3" id='product'>
						<h4><?php echo $product['Title']; ?></h4>
						<div >
							<img src="<?php echo $product['Image']; ?>" width="200" class= "img-thumb">
						</div>
							<p class="list-price text-danger">Original Price: <s>Ksh <?php echo $product['OriginalPrice']; ?></s></p>
							<p class="price">Discounted Price: Ksh <?php echo $product['DiscountedPrice']; ?></p>
							<button type="button"  class="btn btn-sm btn-success" onclick="modal(<?php echo $product['Id']; ?>)">Details</button>
					</div>
			<?php endwhile; ?>
		</div>
	</div>
	<!-- <div class="col-md-1"></div>
		</div>
<div class="row">
			<div class="col-md-12">
				<center>
					<ul class="pagination" id="pageno">
						<li><a href="#">1</a></li>
					</ul>
				</center>
			</div>
		</div>
	</div> -->

	<?php 
	include 'Include/rightbar.php';
	include 'Include/footer.php';
	?>
