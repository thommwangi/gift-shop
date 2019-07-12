<?php

require_once '../core/init.php'; 
if(!is_logged_in()){
    login_error_redirect();
}
include 'includes/head.php';
include 'includes/navigation.php';
//include '../helper/helper.php' ;
$mysqli = new mysqli("localhost", "102600", "choco95*", "giftit");
$sql="SELECT * FROM tag_type WHERE parent=0";
$result= $mysqli->query($sql);
$errors =array();
$tag_name = '';
$post_parent = '';

//Edit category
if(isset($_GET['edit']) && !empty($_GET['edit'])){
	$edit_id = (int)$_GET['edit'];
	$edit_id = sanitize($edit_id);
	//for the child
	$edit_id1 = (int)$_GET['edit'];
	$edit_id1 = sanitize($edit_id1);

	$edit_sql ="SELECT * FROM tag_type WHERE tag_type_id = '$edit_id'";
	$edit_sql1 ="SELECT * FROM tag_type_value WHERE tag_type_id = '$edit_id'";
	$edit_result = $mysqli->query($edit_sql);
	$edit_result1=$mysqli->query($edit_sql1);
	$edit_tag =mysqli_fetch_assoc($edit_result);
	$edit_tag1 = mysqli_fetch_assoc($edit_result1);	
	//for child
	$edit_result1 = $mysqli->query($edit_sql1);
	$edit_tag1 =mysqli_fetch_assoc($edit_result1);
}

//Delete tag name
if(isset($_GET['delete']) && !empty($_GET['delete'])){
	$delete_id = (int)$_GET['delete'];
    $delete_id = sanitize($delete_id);
    
     $delete_id1 = (int)$_GET['delete'];
	 $delete_id1 = sanitize($delete_id1);
	
	//to delete the child of the deleted tag name
    $sql = "SELECT * FROM tag_type WHERE tag_type_id = '$delete_id' ";
    $sql1 = "SELECT * FROM tag_type_value WHERE id = '$delete_id1' ";
    $result = $mysqli->query($sql);
    $result1 = $mysqli->query($sql1);
    $tag_name = mysqli_fetch_assoc($result);
    $tag_name1 = mysqli_fetch_assoc($result1);
	//this if statement will be skipped if the deleted parent has no child in the db
	if($tag_name['parent'] == 0){
        $sql = "DELETE FROM tag_type WHERE tag_type_id = '$delete_id' ";
        $sql1 = "DELETE FROM tag_type_value WHERE id = '$delete_id1' ";
        $mysqli->query($sql);
        $mysqli->query($sql1);
	}
    $dsql = "DELETE FROM tag_type WHERE id = '$delete_id'  ";
    //$dsql1 = "DELETE FROM tag_type_value WHERE id = '$delete_id'  ";
    $mysqli->query($dsql);
   // $mysqli->query($dsql1);
	header('Location: producttags.php');
}

//Process form 
if(isset($_POST) && !empty($_POST)){
	$post_parent = sanitize($_POST['parent']);
	$tag_name = sanitize($_POST['tagname']);
	$sqlform = "SELECT * FROM tag_type WHERE tag_type = '$tag_name' AND parent = '$post_parent' ";
	if(isset($_GET['edit'])){
		$id = $edit_tag['tag_type_id'];
		$sqlform = "SELECT * FROM tag_type WHERE tag_type = '$tag_name' AND parent = '$post_parent' AND tag_type_id !='$id' ";
		
		
	}
	$fresult = $mysqli->query($sqlform);
	$count = mysqli_num_rows($fresult);
	//If category is blank
	if($tag_name== ''){
	$errors[] .= 'The Tag Name cannot be left blank.';
	
	}
	
	//if exists in the database
	if($count > 0){
	$errors[] .= $tag_name. ' already exists.Please choose a new Tag Name.' ;
	
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
		
        $updatesql = "INSERT INTO tag_type(tag_type,parent) VALUES ('$tag_name','$post_parent')" ;
        $updatesql1 = "INSERT INTO tag_type_value(tag_type_id,tag_type_value) VALUES ('$post_parent','$tag_name')";
		if(isset($_GET['edit'])){
			$updatesql = "UPDATE tag_type SET tag_type = '$tag_name', parent = '$post_parent' WHERE tag_type_id = '$edit_id' ";
			$updatesql1 = "UPDATE tag_type_value SET tag_type_id ='$id', tag_type_value='$tag_name'"; 
		}
        $mysqli->query($updatesql) or die(mysqli_error($updatesql)); 
        $mysqli->query($updatesql1) or die(mysqli_error($updatesql1));
	    //header('Location: producttags.php');
	}
}

$tag_value = '';
$parent_value = 0;
if(isset($_GET['edit'])){
	$tag_value = $edit_tag1['tag_type_value'];
	$parent_value = $edit_tag['parent'];
}else{
	if(isset($_POST)){
		$tag_value = $tag_name;
		$parent_value = $post_parent;
	}
	
}
?>
<h2 class="text-center">Tag Name</h2><hr>
<div class="row">

<!-- Form -->
<div class="col-md-6">
	<form class="form" action="producttags.php<?=((isset($_GET['edit']))?'?edit=' .$edit_id:''); ?>" method="post">
	<legend><?=((isset($_GET['edit']))?'Edit':'Add A'); ?> Product Tag</legend>
	<div id="errors"></div>
	<div class="form=group">
	<label for="parent">Parent</label>
	<select class="form-control" name="parent" id="parent">
	<option value="0"<?=(($parent_value == 0)?' selected="selected"':''); ?>>Parent</options>
	<?php while($parent = mysqli_fetch_assoc($result)): ?>
	<option value="<?=$parent['tag_type_id']; ?>"<?=(($parent_value == $parent['tag_type_id'])?' selected="selected"':''); ?>><?=$parent['tag_type']; ?></option>
	
	<?php endwhile; ?>
	</select>
	</div>
	<div class="form-group">
	<label for="category">Tag Name</label>
	<input type="text" class="form-control" id="tagname" name="tagname" value="<?=$tag_value; ?>">
	</div>
	<div class="form-group">
	<input type="submit" value="<?=((isset($_GET['edit']))?'Edit':'Add'); ?>TagName" class="btn btn-success"> 
	
	</div>
</form>


</div>

<!--Category Table -->
<div class="col-md-6">
<table class="table table-bordered">
<thead>
<th>Tag Name</th>
<th>Parent</th>
<th></th>
</thead>
<tbody>
<?php
$sql="SELECT * FROM tag_type WHERE parent=0";
$result= $mysqli->query($sql);

 while($parent = mysqli_fetch_assoc($result)): 
	$parent_id = (int)$parent['tag_type_id'];
	$sql2 ="SELECT * FROM tag_type_value WHERE tag_type_id ='$parent_id'";
	$cresult = $mysqli->query($sql2);
?>
<tr class="bg-primary">
<td><?=$parent['tag_type']; ?> </td>
<td>Parent</td>
<td>
<a href="producttags.php?edit=<?=$parent['tag_type_id']; ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
<a href="producttags.php?delete=<?=$parent['tag_type_id']; ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove-sign"></span></a>
</td>
</tr>
	<?php while($child = mysqli_fetch_assoc($cresult)): ?>
	<tr class="bg-info">
<td><?=$child['tag_type_value']; ?> </td>
<td><?=$parent['tag_type']; ?></td>
<td>
<a href="producttags.php?edit=<?=$child['id']; ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
<a href="producttags.php?delete=<?=$child['id']; ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove-sign"></span></a>
</td>
</tr>
	
	<?php endwhile; ?>
<?php endwhile; ?>
</tbody>
</table>
</div>
</div>
<?php include 'includes/footer.php'; ?>