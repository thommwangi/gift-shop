fvghy<?php
$mysqli = new mysqli("localhost", "102600", "choco95*", "Giftit");
$Id=$_POST['Id'];
$Id=(int)$Id;
$sql="SELECT * FROM products WHERE Id='$Id'";
$result=$mysqli->query($sql);
$product=mysqli_fetch_assoc($result);
$sizestring=$product['Size'];
$size_array = explode(',',$sizestring);

?>

<?php ob_start(); ?>


<div class="modal details" id="details-modal" tabindex="-1" role="dialog" aria-labelledby="details" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
		<div class="modal-header">
			<button class="close" type="button" onclick="CloseModal()" aria-label="close"><span aria-hidden="true">&times;</span></button>
			
			<h4 class="modal-title text-center"><?php echo $product['Title']; ?></h4>
			
		</div>	
		<div class="modal-body">
			<div class="container-fluid">
				<div class="row">
					<span id="modal_errors" class="bg-danger"></span>
					<div class="col-sm-6">
						<div class="center-block">
							<img src="<?php echo $product['Image']; ?>" width="200" class= "details img-responsive">
						</div>
					</div> 
					<div class="col-sm-6">
						<h4>Details</h4>
						<p><?php echo $product['Description']; ?></p>
							<hr>
							<p>Price:Ksh <?php echo $product['DiscountedPrice']; ?></p>
		<form action="cart_man.php" method="post" class="add-product-form">
			<input type="hidden" name="product_id" value="<?=$Id;?>">
			<input type="hidden" name="available" value="">
			
			 <div class="form-group">
            <div class="col-xs-4">
                <label for="quantity" style="float: left;"></style>Quantity:</label>

                <input type="number" class="form-control" id="quantity" name="quantity" style="float: left;">
            </div>
            <div class="col-xs-9">
            
        </div></div><br><br><br>
        <div class="form-group">
            <label for="size" style="float: left;">Size</label>
            <select name="size" id="size" class="form-control">
                <option value=""></option>
                 <?php foreach($size_array as $string){
                	$string_array=explode(':', $string);
                	$size=$string_array[0];
                	$available=$string_array[1];
                	echo '<option value="'.$size.'"data-available="'.$available.'" >'.$size.'('.$available.'Available)</option>';
                	
                } ?>

            </select> 

            
        </div>
        <div class="modal-footer">
			<button class="btn btn-default" data-dismiss='modal' id="close-modal">close</button>
			<button id="add_to_cart" class="btn btn-warning"><span class="glyphicon glyphicon-shopping-cart"></span> Add to Cart</button>
			
		</div>	
    </form>
</div>
</div>
</div>
</div>
		
	</div>
	</div>
</div> 
<script>
	jQuery('#size').change(function(){
		var available=jQuery('#size option:selected').data("available");

	jQuery('#available').val(available);
	});



	function CloseModal() {
		jQuery('#details-modal').modal('hide');
		setTimeout(function(){
			jQuery('#details-modal').remove();
			jQuery('.modal-backdrop').remove();
		}, 500);
	}
	function add(){
		alert("Item added to cart");
	}
</script>
<?php echo ob_get_clean(); ?>
