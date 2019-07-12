<?php

require_once '../core/init.php'; 
if(!is_logged_in()){
    login_error_redirect();
}
include 'includes/head.php';
include 'includes/navigation.php';
//include '../helper/helper.php' ;
$mysqli = new mysqli("localhost", "102600", "choco95*", "giftit");
$sql="SELECT * FROM categories WHERE parent=0";
$result= $mysqli->query($sql);
$errors =array();
$category = '';
$post_parent = '';

//Edit category
if(isset($_GET['edit']) && !empty($_GET['edit'])){
	$edit_id = (int)$_GET['edit'];
	$edit_id = sanitize($edit_id);
	$edit_sql ="SELECT * FROM categories WHERE Id = '$edit_id'";
	$edit_result = $mysqli->query($edit_sql);
	$edit_category =mysqli_fetch_assoc($edit_result);
}

//Delete category
if(isset($_GET['delete']) && !empty($_GET['delete'])){
	$delete_id = (int)$_GET['delete'];
	$delete_id = sanitize($delete_id);
	
	//to delete the child of the deleted category
	$sql = "SELECT * FROM categories WHERE Id = '$delete_id' ";
	$result = $mysqli->query($sql);
	$category = mysqli_fetch_assoc($result);
	//this if statement will be skipped if the deleted parent has no child in the db
	if($category['parent'] == 0){
		$sql = "DELETE FROM categories WHERE parent = '$delete_id' ";
		$mysqli->query($sql);
	}
	$dsql = "DELETE FROM categories WHERE Id = '$delete_id'  ";
	$mysqli->query($dsql);
	header('Location: categories.php');
}

//Process form 
if(isset($_POST) && !empty($_POST)){
	$post_parent = sanitize($_POST['parent']);
	$category = sanitize($_POST['category']);
	$sqlform = "SELECT * FROM categories WHERE category = '$category' AND parent = '$post_parent' ";
	if(isset($_GET['edit'])){
		$id = $edit_category['Id'];
		$sqlform = "SELECT * FROM categories WHERE category = '$category' AND parent = '$post_parent' AND Id !='$id' ";
		
		
	}
	$fresult = $mysqli->query($sqlform);
	$count = mysqli_num_rows($fresult);
	//If category is blank
	if($category == ''){
	$errors[] .= 'The category cannot be left blank.';
	
	}
	
	//if exists in the database
	if($count > 0){
	$errors[] .= $category. ' already exists.Please choose a new category.' ;
	
	}
	//Display errors or update database 
	if(!empty($errors)){
		//display errors  
		echo display_errors($errors);
		//$display = display_errors($errors); ?>
			<script>
			jQuery('document').ready(function(){
				jQuery('#errors').html('<?=$display; ?>' );
			});
			</script>
		
	<?php }else{
		//update database
		
		$updatesql = "INSERT INTO categories (CategoryName,Parent) VALUES ('$category','$post_parent')" ;
		if(isset($_GET['edit'])){
			$udpatesql = "UPDATE categories SET CategoryName = '$category', Parent = '$post_parent' WHERE Id = '$edit_id' ";
			
		}
		$mysqli->query($updatesql);
		header('Location: categories.php');
	}
}

$category_value = '';
$parent_value = 0;
if(isset($_GET['edit'])){
	$category_value = $edit_category['CategoryName'];
	$parent_value = $edit_category['Parent'];
}else{
	if(isset($_POST)){
		$category_value = $category;
		$parent_value = $post_parent;
	}
	
}
?>
<h2 class="text-center">Categories</h2><hr>
<div class="row">

<!-- Form -->
<div class="col-md-6">
	<form class="form" action="categories.php<?=((isset($_GET['edit']))?'?edit=' .$edit_id:''); ?>" method="post">
	<legend><?=((isset($_GET['edit']))?'Edit':'Add A'); ?> Category</legend>
	<div id="errors"></div>
	<div class="form=group">
	<label for="parent">Parent</label>
	<select class="form-control" name="parent" id="parent">
	<option value="0"<?=(($parent_value == 0)?' selected="selected"':''); ?>>Parent</options>
	<?php while($parent = mysqli_fetch_assoc($result)): ?>
	<option value="<?=$parent['Id']; ?>"<?=(($parent_value == $parent['Id'])?' selected="selected"':''); ?>><?=$parent['CategoryName']; ?></option>
	
	<?php endwhile; ?>
	</select>
	</div>
	<div class="form-group">
	<label for="category">Category</label>
	<input type="text" class="form-control" id="category" name="category" value="<?=$category_value; ?>">
	</div>
	<div class="form-group">
	<input type="submit" value="<?=((isset($_GET['edit']))?'Edit':'Add'); ?>Category" class="btn btn-success"> 
	
	</div>
</form>


</div>

<!--Category Table -->
<div class="col-md-6">
<table class="table table-bordered">
<thead>
<th>Category</th>
<th>Parent</th>
<th></th>
</thead>
<tbody>
<?php
$sql="SELECT * FROM categories WHERE parent=0";
$result= $mysqli->query($sql);

 while($parent = mysqli_fetch_assoc($result)): 
	$parent_id = (int)$parent['Id'];
	$sql2 ="SELECT * FROM categories WHERE parent ='$parent_id'";
	$cresult = $mysqli->query($sql2);
?>
<tr class="bg-primary">
<td><?=$parent['CategoryName']; ?> </td>
<td>Parent</td>
<td>
<a href="categories.php?edit=<?=$parent['Id']; ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
<a href="categories.php?delete=<?=$parent['Id']; ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove-sign"></span></a>
</td>
</tr>
	<?php while($child = mysqli_fetch_assoc($cresult)): ?>
	<tr class="bg-info">
<td><?=$child['CategoryName']; ?> </td>
<td><?=$parent['CategoryName']; ?></td>
<td>
<a href="categories.php?edit=<?=$child['Id']; ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
<a href="categories.php?delete=<?=$child['Id']; ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove-sign"></span></a>
</td>
</tr>
	
	<?php endwhile; ?>
<?php endwhile; ?>
</tbody>
</table>
</div>
</div>
<?php include 'includes/footer.php'; ?>