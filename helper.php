<?php 
function get_category($child_Id){
 $sqli=$mysqli = new mysqli("localhost", "102600", "choco95*", "giftit");
	$id=mysql_real_escape_string($child_Id);
	$sql="SELECT p.Id AS 'pId', p.CategoryName AS 'Parent', c.Id AS 'cId', c.CategoryName AS 'child' 
	FROM categories c 
	INNER JOIN categories p 
	ON c.Parent= p.Id
	WHERE c.Id='$id'";

	$query=$sqli->query($sql);
	$category=mysqli_fetch_assoc($query);
	return $category;

}


 ?>