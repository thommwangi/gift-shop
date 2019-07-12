<?php

require_once 'mainpageconnect.php';
 $mysqli = new mysqli("localhost", "102600", "choco95*", "Giftit");

$product_id=mysqli_real_escape_string($mysqli,$_POST['product_id']);
$size=mysqli_real_escape_string($mysqli,$_POST['size']);
$available=mysqli_real_escape_string($mysqli,$_POST['available']);
$quantity=mysqli_real_escape_string($mysqli,$_POST['quantity']);
$item=array();
$item[]=array(
'Id'      =>$product_id,
'size'    =>$size,
'quantity'=>$quantity,
);

$domain =($_SERVER['HTTP_HOST'] !='localhost')?'.'.$_SERVER['HTTP_HOST']:false;
$query=$mysqli->query("SELECT * FROM products WHERE Id='{$product_id}'");
$product=mysqli_fetch_assoc($query);
$_SESSION['success_flash']=$product['Title'].'was added to your cart.';
//check to see if cart cookie exists
if($cart_id != ''){
	$cartQ=$mysqli->query("SELECT * FROM cart WHERE Id='{cart_id}'");
	$cart=mysqli_fetch_assoc($cartQ);
	$previous_items=json_decode($cart['Items'],true);
	$item_match=0;
	$new_items=array();
	foreach ($previous_items as $pitem) {
		if($item[0]['Id']==$pitem['Id']&&$item[0]['size']){
			$pitem['quantity']+$item[0]['quantity'];
			if($pitem['quantity']>available){
				$pitem['quantity']=$available;
			}
			$item_match=1;

		}
		$new_items=$pitem;
	}
	if($item_match!= 1){
		$new_items=array_merge($item,$previous_items);
	}
	$items_json=json_encode($new_items);
	$cart_expire=date("Y-m-d H:i:s",strtotime("+30 days"));
	$mysqli->query("UPDATE cart SET items='{$items_json}',expire_date='{$cart_expire}' WHERE Id ='{$cart_id}'");
	setcookie(CART_COOKIE,'',1,"/",$domain,false);
	setcookie(CART_COOKIE,$cart_id,CART_COOKIE_EXPIRE,'/',$domain,false);


}else{
	//add the cart to the database and set cookie
	$items_json=json_encode($item);
	$cart_expire=date("Y-m-d H:i:s",strtotime("+30 days"));
	$mysqli->query("INSERT INTO cart(Items,expire_date)VALUES ('{$items_json}','{$cart_expire}')");
	$cart_id=$mysqli->insert_id;
	setcookie(CART_COOKIE,$cart_id,CART_COOKIE_EXPIRE,'/',$domain,false);

}

?>