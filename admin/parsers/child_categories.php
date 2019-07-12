<?php
$mysqli = new mysqli("localhost", "root", "", "giftit");
$parentID = (int)$_POST['parentID'];
$selected = $_POST['selected'];
$childquery = $mysqli->query("SELECT * FROM categories WHERE Parent = '$parentID' ORDER BY CategoryName");
ob_start();?>
<option value=""></option>
<?php while($child = mysqli_fetch_assoc($childquery)): ?>
<option value="<?=$child['Id'];?>" <?=(($selected == $child['Id'])?' selected':'');?>><?=$child['CategoryName'];?></option>
<?php endwhile; ?>

<?php echo ob_get_clean(); ?>

