<?php
session_start();
if(!isset($_SESSION["uid"])){
	header("location:mainpage.php");
}
include 'Include/head.php';
include 'Include/navigationprofile.php';
//include 'Include/headerfull.php';
include 'Include/leftbar.php';
include 'cart_man.php';


$relationship = $_POST['relationship'];
$occassion = $_POST['occassion'];
$gender= $_POST['gender'];
$age = $_POST['age'];

$mysqli = new mysqli("localhost", "102600", "choco95*", "giftit");

$filter="SELECT DISTINCT id FROM products";
$id = $mysqli->query($filter);
$i=0;
$match = 0;
$products = [];

foreach ($id as $value) {
	$tagq = "SELECT tag_type_value_id FROM product_tag_value WHERE product_id = ". $value['id'];

	$tags = $mysqli->query($tagq);

	while ($record = mysqli_fetch_array($tags)) {
		$r = $record['tag_type_value_id'];
		// var_dump($record['tag_type_value_id']);
	 	if ($r == $relationship || $r == $occassion || $r == $age || $r == $gender) {
	 		$match++;
	 	}
 	}
 	if ($match >= 4) {
 		array_push($products, $value['id']);
 	}
 	$match = 0;
}

// var_dump($products);
$filter = "SELECT * FROM products WHERE ";

foreach ($products as $id) {
	if(++$i === count($products)) {
  	  $filter .= "Id = " . $id;
  	} else {
  		$filter .= "Id = " . $id . " OR ";
  	}
}


//$filtered=$mysqli->query($filter);
?> 
<div class="col-md-8" style="margin-top: 90px;"> 
		<div class="row">
			<h2 class="text-center" style="margin-bottom: 50px;">Filtered products</h2>
			<?php 
			if($filtered=$mysqli->query($filter)){
			 while($product=$filtered->fetch_array()):?>
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
			<?php }else{
			 echo "<h1>No Products Found</h1>";
			
		}?>
		</div>
	</div>


	<?php 
	include 'Include/rightbar.php';
	include 'Include/footer.php';
	?>