<?php
$mysqli = new mysqli("localhost", "102600", "choco95*", "giftit");
require_once '../core/init.php'; 
if(!is_logged_in()){
    login_error_redirect();
}
if(!has_permission('admin')){
    permission_error_redirect('index.php');
}
include 'includes/head.php';
include 'includes/navigation.php';

$orderq=$mysqli->query("SELECT * FROM orders");
$orders=mysqli_fetch_assoc($orderq);
$user=$orders['user_id'];
$product=$orders['product_id'];

//fetching product name from products table
$productq=$mysqli->query("SELECT Title FROM products WHERE Id='$product'");
$product_name=mysqli_fetch_assoc($productq);
$product_nam=$product_name['Title'];

//fetching user name from register table
$userq=$mysqli->query("SELECT * FROM register WHERE user_id='$user'");
$user_details=mysqli_fetch_assoc($userq);
$user_name=$user_details['fullname'];
$user_email=$user_details['email'];
$user_address=$user_details['address'];
$user_number=$user_details['PhoneNumber'];
?>
<?php

//query from selecting data from orders
$orderq=$mysqli->query("SELECT * FROM orders");

?> 

<!--<a href="users.php?add=1" class="btn btn-success pull-right" id="add-product-btn">Add New User</a> -->
<hr>
<table class="table table-bordered table-striped table-condensed">
<h2>Orders</h2>
    <thead><th>Full Name</th><th>Email</th><th>Phone Number</th><th>Order ID</th><th>Product</th><th>Quantity</th><th>Transaction ID</th><th>Status</th></thead>
    <tbody>
    <?php while($orders=mysqli_fetch_assoc($orderq)): ?> 
        <tr>
            
            <td><?= $user_name;?></td>
            <td><?= $user_email;?></td>
            <td><?= $user_number?></td>
            <td><?= $orders['order_id'];?></td>
            <td><?= $product_nam;?></td>
            <td><?= $orders['quantity'];?></td>
            <td><?= $orders['trx_id'];?></td>
            <td><?= $orders['p_status'];?></td>
        </tr>
<?php endwhile;?>
</tbody>
</table>
<?php include 'includes/footer.php'; ?>