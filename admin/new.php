<?php 
include 'includes/head.php';
include 'includes/navigation.php';
include '../helper/helper.php' ;
$mysqli = new mysqli("localhost", "102600", "choco95*", "giftit");
$sql = "SELECT * FROM products WHERE deleted = 0";
$presults = $mysqli->query($sql);
if(isset($_GET['featured'])){
    $id = (int)$_GET['id'];
    $featured = (int)$_GET['featured'];
    $featuredsql = "UPDATE products SET featured = '$featured' WHERE id = '$id'";
    $mysqli->query($featuredsql);
    header ('Location: new.php' );
}
?>
<h2 class="text-center">Products</h2><hr>
<table class="table table-bordered table-condensed table-stripped">
    <thead><th></th><th>Product</th><th>Price</th><th>Category</th><th>Featured</th><th>Sold</th></thead>
    <tbody>
    <?php while($product = mysqli_fetch_assoc($presults)):
        $childID = $product['category'];
        $catsql= "SELECT * FROM categories WHERE Id = '$childID'";
        $result = $mysqli->query($catsql);
        $child = mysqli_fetch_assoc($result);
        $parentID = $child['parent'];
        $psql = "SELECT * FROM categories WHERE Id = '$parentID'";
        $presult = $mysqli->query($psql);
        $parent = mysqli_fetch_assoc($presult);
        $category = $parent['category'].'¬'.$child['category'];
        ?>
        <tr>
        <td>
        <a href="new.php=?edit<?=$products['id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
        <a href="new.php=?delete<?=$products['id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove"></span></a>
        </td>
        <td><?=$product['title'];?></td>
        <td><?=money($product['discounted_price']);?></td>
        <td><?=$category;?></td>
       <td><a href="new.php?feature= <?=(($product['feature'] == 0)?'1':'0'); ?>&id=<?=$product['id'];?>" class=" btn btn-xs btn-default">
<span class="glyphicon glyphicon-<?=(($product['feature'] == 1)?'minus':'plus');?>"></span>
</a>&nbsp <?=(($product['feature'] == 1)?'Featured Product' :'');?></td>
        <td></td>

        </tr>
        <?php endwhile; ?>
        
    </tbody>
</table>



<td><a href="products.php?feature= <?=(($product['feature'] == 0)?'1':'0'); ?>&id=<?=$product['id'];?>" class=" btn btn-xs btn-default">
<span class="glyphicon glyphicon-<?=(($product['feature'] == 1)?'minus':'plus');?>"></span>
</a>&nbsp <?=(($product['feature'] == 1)?'Featured Product' :'');?></td>
