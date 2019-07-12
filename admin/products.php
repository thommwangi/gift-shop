<?php 
//require_once $_SERVER['DOCUMENT_ROOT'].'/core/init.php';
require_once '../core/init.php'; 
if(!is_logged_in()){
    login_error_redirect();
}
include 'includes/head.php';
include 'includes/navigation.php';
//include '../helper/helper.php' ;

//delete or archive product
if(isset($_GET['delete'])){
    $mysqli = new mysqli("localhost", "102600", "choco95*", "giftit");
    $id = sanitize($_GET['delete']);
    $mysqli->query("UPDATE products SET deleted=1 WHERE Id= '$id'");
    header('Location:products.php');
}

define('BASEURL', $_SERVER['DOCUMENT_ROOT'].'/GIFT-SHOP/'); 
$dbpath = '';
if(isset($_GET['add']) || isset($_GET['edit'])){
            $mysqli = new mysqli("localhost", "root", "", "giftit");
            $brandquery = $mysqli->query("SELECT * FROM	brand ORDER BY brand");
            $parentquery = $mysqli->query("SELECT * FROM categories WHERE Parent = 0 ORDER BY CategoryName");
            $title =((isset($_POST['title']) && $_POST['title'] != '')?sanitize($_POST['title']):'');
            $brand = ((isset($_POST['brand']) && !empty($_POST['brand']))?sanitize($_POST['brand']):'');
            $parent = ((isset($_POST['parent']) && !empty($_POST['parent']))?sanitize($_POST['parent']):'');
            $category = ((isset($_POST['child']) && !empty($_POST['child']))?sanitize($_POST['child']):'');
            $original_price = ((isset($_POST['original_price']) && !empty($_POST['original_price']))?sanitize($_POST['original_price']):'');
            $discounted_price = ((isset($_POST['discounted_price']) && !empty($_POST['discounted_price']))?sanitize($_POST['discounted_price']):'');
            $description = ((isset($_POST['description']) && $_POST['description'] != '')?sanitize($_POST['description']):'');
            if(isset($_POST['relationship'])){
             $relationship=$_POST['relationship'];
            }
            // echo 'the product is'.$relationship[0];
            $sizes = ((isset($_POST['sizes']) && $_POST['sizes'] != '')?sanitize($_POST['sizes']):'');
            if(isset($_POST['age'])){
            $age=$_POST['age'];}
            //echo 'the age is'.$age;
            if(isset($_POST['gender'])){
            $gender = $_POST['gender'];}
            // foreach ($gender as $g){
            //     echo "item " . $g . "<br>";
            // }
            
            //$occassion = ((isset($_POST['occassion']) && $_POST['occassion'] != '')?sanitize($_POST['occassion']):'');
           if(isset($_POST['occassion'])){
            $occassion=$_POST['occassion'];}
            $saved_image = '';
            
    
    
	    if(isset($_GET['edit'])){
            $editid = (int)$_GET['edit'];
            $productresult = $mysqli->query("SELECT * FROM products WHERE Id = '$editid'");
            $product = mysqli_fetch_assoc($productresult);
        if(isset($_GET['delete_image'])){
            $image_url = $_SERVER['DOCUMENT_ROOT'].$product['Image'];echo $image_url;
            unlink($image_url);
            $mysqli->query("UPDATE products SET Image = '' WHERE Id = '$editid' ");
            header('Location:products.php?edit='.$editid);
        }
            $category = ((isset($_POST['child']) && $_POST['child'] != '')?sanitize($_POST['child']):$product['Category']);
            $title = ((isset($_POST['title']) && $_POST['title'] !='')?sanitize($_POST['title']):$product['Title']);
            $brand = ((isset($_POST['brand']) && $_POST['brand'] !='')?sanitize($_POST['brand']):$product['Brand']);

            $parentq = $mysqli->query("SELECT * FROM categories WHERE Id = '$category'");
            $parentresult = mysqli_fetch_assoc($parentq);

         
            $parent = ((isset($_POST['parent']) && $_POST['parent'] !='')?sanitize($_POST['parent']):$parentresult['parent']);
            $original_price = ((isset($_POST['original_price']) && $_POST['original_price'] !='')?sanitize($_POST['original_price']):$product['OriginalPrice']);
            $discounted_price = ((isset($_POST['discounted_price']) && $_POST['discounted_price'] !='')?sanitize($_POST['discounted_price']):$product['DiscountedPrice']);
            $description = ((isset($_POST['description']) && $_POST['description'] !='')?sanitize($_POST['description']):$product['Description']);
            $relationship = ((isset($_POST['relationship']) && $_POST['relationship'] !='')?sanitize($_POST['relationship']):$product['relationship']);
            $sizes = ((isset($_POST['sizes']) && $_POST['sizes'] !='')?sanitize($_POST['sizes']):$product['Size']);
            
            $age = ((isset($_POST['age']) && $_POST['age'] !='')?sanitize($_POST['age']):$age['age']);
            
            $gender = ((isset($_POST['gender']) && $_POST['gender'] !='')?sanitize($_POST['gender']):$gender['tag_type_value']);
           
            
            $occassion = ((isset($_POST['occassion']) && $_POST['occassion'] !='')?sanitize($_POST['occassion']):$occassion['tag_type_value']);
            $personality = ((isset($_POST['personality']) && $_POST['personality'] !='')?sanitize($_POST['personality']):$product['personality']);
            $saved_image = (($product['Image'] != '')?$product['Image']:'');
            $dbpath = $saved_image;
            // $gender=$_POST['gender'];
            // echo $gender;
    }
    if(!empty($sizes)){
			$sizeString = sanitize($sizes);
			$sizeString = rtrim($sizeString,',');
			$sizesArray = explode(',',$sizeString);
			$sArray = array();
			$qArray = array();
			foreach($sizesArray as $ss){
				$s = explode(':' , $ss);
				$sArray[] = $s[0];
				$qArray[] = $s[1]; 
				
			}
	}else{$sizesArray = array(); }
	
	if($_POST){
     
        
		$errors = array();
		
		    $required = array('title', 'original_price', 'parent','child','sizes');
		foreach($required as $field){
			if($_POST[$field] == ''){
				    $errors[] = 'All Fields With An Asterix Must Be Filled';
				    break;
			}
		} 
        //check for image
         if(!empty($_FILES)){
            //  $target = "../images".basename($_FILES['photo']['name']);
            //  $photo = $_FILES['photo']['name'];
            //  if(move_uploaded_file($_FILES['photo']['tmp_name'], $target)){
            //      $msg = "image uploaded successfully";
            //  }else{
            //      $msg= "there was a problem";
            //  }
          // var_dump($_FILES);
            $photo = $_FILES['photo'];
            $name = $photo['name'];
            $nameArray = explode('.',$name);
            $fileName = $nameArray[0];
            $fileExt = $nameArray[1];
            $mime = explode('/',$photo['type']);
            $mimeType = $mime[0];
            $mimeExt = $mime[1];
            $tmpLoc = $photo['tmp_name'];
            $fileSize = $photo['size'];
            //creating array for allowed file extensions
            $allowed = array('png','jpg','jpeg','gif');
           
            $uploadName = md5(microtime()).'.'.$fileExt;
             $uploadPath = BASEURL.'images/'.$uploadName;
            $dbpath = '/GIFT-SHOP/images/'.$uploadName;
            //validation of image
            if ($mimeType != 'image'){
                $errors[] = 'The File Must Be An Image';
            }
            /*if(!in_array($fileExt, $allowed)){
                $errors[] = 'The Photo Extension Must Be a png,jpeg,jpg or gif';
            }*/
            if ($fileSize > 15000000){
                $errors[] = 'The File Size Must Be Under 15mb';
            }
            if($fileExt != $mimeExt && ($mimeExt == 'jpeg' && $fileExt != 'jpg')){
                $errors[] = 'File Extension Does Not Match The File';
            }
         }
        

         


		if(!empty($errors)){
			echo display_errors($errors);
		}else{
            //upload file and insert into database
            if(!empty($_FILES)){
                    move_uploaded_file($tmpLoc,$uploadPath);
            }


            
            
                    $insertsql = "INSERT INTO products (`Title`,`DiscountedPrice`,`OriginalPrice`,`Brand`,`Category`,`Image`,`Description`,`Size`) 
                    VALUES ('$title','$discounted_price','$original_price','$brand','$category','$dbpath','$description','$sizes')";
                    $mysqli->query($insertsql) or die(mysqli_error($mysqli));
                    header('Location: products.php');


                    //for choosing the last inserted id from products table
                    $fetchsql=$mysqli->query("SELECT * FROM `products` ORDER BY Id DESC LIMIT 1");
                    $prod=mysqli_fetch_assoc($fetchsql);
                    $product_id=$prod['Id'];


                    foreach($age as $a){
                        //echo "age" . $a . "<br>";
                        $insertsql1="INSERT INTO `product_tag_value`( `product_id`, `tag_type_value_id`) VALUES ('$product_id','$a') ";
                        $mysqli->query($insertsql1) or die(mysqli_error($insertsql1)); 
                    }

                    foreach($gender as $g){
                        //echo "age" . $a . "<br>";
                        $insertsql1="INSERT INTO `product_tag_value`( `product_id`, `tag_type_value_id`) VALUES ('$product_id','$g') ";
                        $mysqli->query($insertsql1) or die(mysqli_error($insertsql1)); 
                    }

                    foreach($occassion as $o){
                        //echo "age" . $a . "<br>";
                        $insertsql1="INSERT INTO `product_tag_value`( `product_id`, `tag_type_value_id`) VALUES ('$product_id','$o') ";
                        $mysqli->query($insertsql1) or die(mysqli_error($insertsql1)); 
                    }

                    foreach($relationship as $r){
                        //echo "age" . $a . "<br>";
                        $insertsql1="INSERT INTO `product_tag_value`( `product_id`, `tag_type_value_id`) VALUES ('$product_id','$r') ";
                        $mysqli->query($insertsql1) or die(mysqli_error($insertsql1)); 
                    }
                    

                if(isset($_GET['edit'])){
                    $updateSql ="UPDATE products SET Title ='$title', DiscountedPrice = '$discounted_price',
                    OriginalPrice = '$original_price' ,  Brand = '$brand', Category = '$category', Size = '$sizes' , Image = '$dbpath', Description = '$description' WHERE Id = '$editid'";
            }
            
                $mysqli->query($updateSql);
               // header('Location: products.php');
		}
	}
	?>
            <!--ADD NEW PRODUCT FORM-->
	 
            <h2 class="text-center"><?=((isset($_GET['edit']))?'Edit':'Add A New');?> Product</h2><hr>
            <form action="products.php?<?=((isset($_GET['edit']))?'edit='.$editid:'add=1');?>" method="POST" enctype="multipart/form-data">
            <div class="form-group col-md-3">
            <label for="title">Title*:</label>
            <input type="text" name="title" id="title" class="form-control" value="<?=$title;?>">
	</div>
	<div class="form-group col-md-3">
            <label for="brand">Brand*:</label>
            <select class="form-control" id="brand" name="brand">
            <option value="<?=(($brand == '')?' selected':'');?>"></option>
		    <?php while($b = mysqli_fetch_assoc($brandquery)): ?>
		        <option value="<?=$b['Id'];?>"<?=(($brand == $b['Id'])?' selected':'');?>><?=$b['Brand'];?></option>
		
		     <?php endwhile; ?>
	            </select>
	            </div>
	            <div class="form-group col-md-3">
                <label for="parent">Parent Category*:</label>
                <select class="form-control" id="parent" name="parent">
                <option value="<?=(($parent == '')?' selected':'');?>"></option>
             <?php while($p = mysqli_fetch_assoc($parentquery)): ?>
                <option value="<?=$p['Id'];?>"<?=(($parent == $p['Id'])?' selected':'');?>><?=$p['CategoryName'];?></option>
	
                <?php endwhile; ?>
            </select>
            </div>

         <!-- for the categories  -->
        <!-- <div class="form-group col-md-3">
	<label for="relationship">Relationship*:</label>
	<input type="text" id="relationship" name="relationship" class="form-group" value="<?=$relationship; ?>">
	</div> -->

    
        <!-- ADDING AGE -->
        <div class="form-group col-md-3">
        <label for="age">Age*:</label><br>
        <?php
            $ageQuery=$mysqli->query("SELECT * FROM tag_type_value WHERE tag_type_id='3'");
            while($age = mysqli_fetch_array($ageQuery)) {
                
            echo "<input type='checkbox' name='age[]' value='{$age['id']}'>" . $age['tag_type_value'] . '<br>';
            //var_dump($age['id']);
            }

        ?>
      </div>
      <hr>

                <!-- ADDING GENDER -->
                <div class="form-group col-md-3">
        <label for="gender">Gender*:</label><br>
        
        <?php
            $genderQuery=$mysqli->query("SELECT * FROM tag_type_value WHERE tag_type_id='4'");
            while($gender = mysqli_fetch_array($genderQuery)) {
          
            echo "<input type='checkbox' name='gender[]' value='{$gender['id']}'>" . $gender['tag_type_value'] . '</br>';
            }
            
        ?>
      </div>
      <hr>

                <!--ADDING THE OCCASSION -->
                <div class="form-group col-md-3">
        <label for="occassion">Occassion*:</label>
        <?php
            $occassionQuery=$mysqli->query("SELECT * FROM tag_type_value WHERE tag_type_id='2'");
            while($occassion = mysqli_fetch_array($occassionQuery)) {
            
            echo "<input type='checkbox' name='occassion[]' value='{$occassion['id']}'>" . $occassion['tag_type_value'] . '</br>';
            }

        ?>
      </div>
      <hr>

                <!-- ADDING THE RELATIONSHIP -->
                <div class="form-group col-md-3">
        <label for="relationship">Relationship*:</label>
<?php
            $relationshipQuery=$mysqli->query("SELECT * FROM `tag_type_value` WHERE tag_type_id ='1' ") or die(mysqli_error($relationshipQuery));
          
            while($relationship = mysqli_fetch_array($relationshipQuery)){
               
                echo "<input type='checkbox' name='relationship[]' value='{$relationship['id']}'>" . $relationship['tag_type_value'] . '</br>';
               
                }
               

                    ?>
    
      </div>

	<div class="form-group col-md-3">
	<label for="child">Child Category*:</label>
	<select id="child" name="child" class="form-control"></select>
	
	</div>
	<div class="form-group col-md-3">
	<label for="price">Original Price*:</label>
	<input type="text" id="original_price" name="original_price" class="form-group" value="<?=$original_price; ?>">
	</div>
	<div class="form-group col-md-3">
	<label for="price">Discounted Price*:</label>
	<input type="text" id="discounted_price" name="discounted_price" class="form-group" value="<?=$discounted_price; ?>">
	</div>
	<div class="form-group col-md-3">
	<label>Quantity & Sizes*:</label>
	<button class="btn btn-default form-control" onclick="jQuery('#sizesModal').modal('toggle');return false;">Quantity & sizes</button>
	</div>
	<div class="form-group col-md-3">
	<label for="sizes">Sizes & Quantity Review</label>
	<input type="text" class="form-control" name="sizes" id="sizes" value="<?=$sizes;?>" readonly>
	</div>
	<div class="form-group col-md-6">
        <?php if($saved_image != ''): ?>
        <div class="saved_image"><img src="<?=$saved_image;?>" alt="saved_image"/><br>
        <a href="products.php?delete_image=1&edit=<?=$editid;?>" class="text-danger">Delete Image</a>
        </div>
        <?php else: ?>
	<label for="photo">Product Photo</label>
	<input type="file" name="photo" id="photo" class="form-control">
        <?php endif; ?>
	</div>
	<div class="form-group col-md-6">
	<label for="description">Description:</label>
	<textarea id="description" name="description" class="form-control" rows="6"><?=$description;?></textarea>
	</div>
	<div class="form-group pull-left">
        <a href="products.php" class="btn btn-default" >Cancel</a>
		<input type="submit" value="<?= ((isset($_GET['edit']))?'Edit':'Add');?> Product" class=" btn btn-success pull-right">
	</div><div class="clearfix"></div>
	</form>
	<!-- Modal --> 
<div class="modal fade "  id="sizesModal" tabindex="-1" role="dialog" aria-labelledby="sizesModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="sizesModalLabel">Sizes & Quantity</h4>
      </div>
      <div class="modal-body">
	  <div class="container-fluid">
        <?php for($i=1;$i <= 12;$i++): ?>
			<div class="form-group col-md-4">
			<label for="size<?=$i;?>">Size:</label>
			<input type="text" name="size<?=$i;?>" id="size<?=$i;?>" value="<?=((!empty($sArray[$i-1]))?$sArray[$i-1]:'');?>" class="form-control">
			</div>
			
        
			<div class="form-group col-md-2">
			<label for="quantity<?=$i;?>">Quantity:</label>
			<input type="number" name="quantity<?=$i;?>" id="quantity<?=$i;?>" value="<?=((!empty($qArray[$i-1]))?$qArray[$i-1]:'');?>" min="0" class="form-control">
			</div>
		
		<?php endfor; ?>
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="updateSizes();jQuery('#sizesModal').modal('toggle');return false;">Save changes</button>
      </div>
    </div>
  </div>
</div>  
<?php }else{
 

$mysqli = new mysqli("localhost", "102600", "choco95*", "giftit");
$sql = "SELECT * FROM products WHERE deleted = 0";
$presults = $mysqli->query($sql);
if(isset($_GET['feature'])){
    $id = (int)$_GET['id'];
    $featured = (int)$_GET['feature'];
    $featuredsql = "UPDATE products SET Feature = '$featured' WHERE Id = '$id'";
    $mysqli->query($featuredsql);
    header ('Location: products.php' );
}
?>
<h2 class="text-center">Products</h2><hr>
<a href="products.php?add=1" class="btn btn-success pull-right" id="add-product-btn">Add Product</a><div class="clearfix"></div>
<hr>
<table class="table table-bordered table-condensed table-stripped">
    <thead><th></th><th>Product</th><th>Price</th><th>Category</th><th>Featured</th><th>Sold</th></thead>
    <tbody>
    <?php while($product = mysqli_fetch_assoc($presults)):
        $childID = $product['Category'];
        $catsql= "SELECT * FROM categories WHERE Id = '$childID'";
        $result = $mysqli->query($catsql);
        $child = mysqli_fetch_assoc($result);
        $parentID = $child['Parent'];
        $psql = "SELECT * FROM categories WHERE Id = '$parentID'";
        $presult = $mysqli->query($psql);
        $parent = mysqli_fetch_assoc($presult);
        $category = $parent['CategoryName'].'¬'.$child['CategoryName'];
        ?>
        <tr>
        <td>
        <a href="products.php?edit=<?=$product['Id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
        <a href="products.php?delete=<?=$product['Id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove"></span></a>
        </td>
        <td><?=$product['Title'];?></td>
        <td><?=money($product['DiscountedPrice']);?></td>
        <td><?=$category;?></td>
       <td><a href="products.php?feature= <?=(($product['Feature'] == 0)?'1':'0'); ?>&id=<?=$product['Id'];?>" class=" btn btn-xs btn-default">
<span class="glyphicon glyphicon-<?=(($product['Feature'] == 1)?'minus':'plus');?>"></span>
</a>&nbsp <?=(($product['Feature'] == 1)?'Featured Product' :'');?></td>
        <td></td>

        </tr>
        <?php endwhile; ?>
        
    </tbody>
</table>




<?php } 
include 'includes/footer.php' ; ?>
<script>
    jQuery('document').ready(function(){
      get_child_options('<?=$category;?>');
        
      });
    </script>