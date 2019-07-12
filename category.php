<?php 
require_once 'mainpageconnect.php';
include 'Include/head.php';
include 'Include/navigationcart.php';
//include 'Include/headerpartial.php';
include 'Include/leftbar.php';
include 'helper.php';
$mysqli = new mysqli("localhost", "102600", "choco95*", "Giftit");

if(isset($_GET['cate'])){
	$cat_id= mysql_real_escape_string($_GET['cate']);
} 
else
{
	$cat_id='';
}

$sql="SELECT * FROM products WHERE category='$cat_id'";


$productQ=$mysqli->query($sql);
$category= get_category($cat_id);

?>


	
	<!-- Main Content -->
	<div class="col-md-8" style="margin-top: 100px;"> 
		<div class="row">
			<h2 class="text-center" style="margin-bottom: 70px;">
			<?php 
					
						echo $category['Parent'].':'.$category['child'];
					
						
			?>
				
			</h2>
			<?php while($product=mysqli_fetch_assoc($productQ)):?>
					<div class="col-sm-3">
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


	<?php 
	include 'Include/rightbar.php';
	include 'Include/footer.php';
	?>
