<?php
if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
// session_start();
//
$mysqli = new mysqli("localhost", "102600", "choco95*", "Giftit");

$ip_add = getenv("REMOTE_ADDR");//include "insertlogin.php";
if(isset($_POST["page"])){
  $sql = "SELECT * FROM products";
  $run_query = mysqli_query($mysqli,$sql);
  $count = mysqli_num_rows($run_query);
  $pageno = ceil($count/9);
  for($i=1;$i<=$pageno;$i++){
    echo "
      <li><a href='#' page='$i' id='page'>$i</a></li>
    ";
  }
}
  if(isset($_POST["add_to_cart"])){
    $p_id = $_POST["product_id"];
    if(isset($_SESSION["uid"])){
    $user_id = $_SESSION["uid"];
    $sql = "SELECT * FROM cart WHERE p_id = '$p_id' AND user_id = '$user_id'";
    $run_query = mysqli_query($mysqli,$sql);
    $count = mysqli_num_rows($run_query);
    if($count > 0){
      echo "
        <div class='alert alert-warning'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <b>Product is already added into the cart Continue Shopping..!</b>
        </div>
      ";
    } else {
      $sql = "INSERT INTO `cart`
      (`p_id`, `ip_add`, `user_id`, `quantity`) 
      VALUES ('$p_id','$ip_add','$user_id','1')";

      if(mysqli_query($mysqli,$sql)){
        $message = "Product is Added..!";
echo "<script type='text/javascript'>alert('$message');</script>";
        
      }
    }
    }else{
      $sql = "SELECT id FROM cart WHERE ip_add = '$ip_add' AND p_id = '$p_id' AND user_id = -1";
      $query = mysqli_query($mysqli,$sql);
      if (mysqli_num_rows($query) > 0) {
        echo "
          <div class='alert alert-danger'>
              <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
              <b>Product is already added into the cart Continue Shopping..!</b>
          </div>";
          exit();
      }
      $sql = "INSERT INTO `cart`
      (`p_id`, `ip_add`, `user_id`, `quantity`) 
      VALUES ('$p_id','$ip_add','-1','1')";
      if (mysqli_query($mysqli,$sql)) {
        echo "
          <div class='alert alert-success'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <b>Your product is Added Successfully..!</b>
          </div>
        ";
        exit();
      }
      
    }
    
    
    
    
  }
if (isset($_POST["count_item"])) {
  if (isset($_SESSION['uid'])) {
    $sql = "SELECT COUNT(*) AS count_item FROM cart WHERE user_id ='" . $_SESSION['uid'] . "'";
  }else{
    $sql = "SELECT COUNT(*) AS count_item FROM cart WHERE ip_add = '$ip_add' AND user_id < 0";
  }
  
  $query = mysqli_query($mysqli,$sql);
  $row = mysqli_fetch_array($query);
  echo $row["count_item"];
  exit();
}
if (isset($_POST["Common"])) {

  if (isset($_SESSION["uid"])) {
    
    $sql = "SELECT a.Id,a.Title,a.DiscountedPrice,a.Image,b.Id,b.quantity,b.p_id FROM products a,cart b WHERE a.Id=b.p_id AND b.user_id='" . $_SESSION['uid'] . "'";
    // print_r($sql);
  }else{
    //When user is not logged in this query will execute
    $sql = "SELECT a.Id,a.Title,a.DiscountedPrice,a.Image,b.Id,b.quantity, b.p_id FROM products a,cart b WHERE a.Id=b.p_id AND b.ip_add='$ip_add' AND b.user_id < 0";
  }
  $query = mysqli_query($mysqli,$sql);

  if (isset($_POST["getCartItem"])) {
    if (mysqli_num_rows($query) > 0) {
      $n=0;
      while ($row=mysqli_fetch_array($query)) {
        $n++;
        $product_id = $row["p_id"];
        $product_title = $row["Title"];
        $product_price = $row["DiscountedPrice"];
        $product_price_dollars = ($product_price)/100;
        print_r($product_price_dollars);
        $product_image = $row["Image"];
        $cart_item_id = $row["Id"];
        $quantity = $row["quantity"];
        echo '
          <div class="row">
            <div class="col-md-3">'.$n.'</div>
            <div class="col-md-3"><img class="img-responsive" src="'.$product_image.'" /></div>
            <div class="col-md-3">'.$product_title.'</div>
            <div class="col-md-3">$'.$product_price.'</div>

          </div>';

        
      }
      ?>

        <a style="float:right;" href="cart.php" class="btn btn-warning">Edit&nbsp;&nbsp;<span class="glyphicon glyphicon-edit"></span></a>
      <?php
      exit();
    }
  }
  if (isset($_POST["checkOutDetails"])) {
    if (mysqli_num_rows($query) > 0) {
      echo "<form method='post' action='LoginForm.php'>";
        $n=0;
        while ($row=mysqli_fetch_array($query)) {
          $n++;
         $product_id = $row["p_id"];
        $product_title = $row["Title"];
        $product_price = $row["DiscountedPrice"];
        $product_price_dollars = ($product_price)/100;
        // print_r($product_price_dollars);
        $product_image = $row["Image"];
        $cart_item_id = $row["Id"];
        $quantity = $row["quantity"];

          echo 
            '<div class="row">
                <div class="col-md-2">
                  <div class="btn-group" data-product-id="'.$product_id.'">
                    <a href="#" class="btn btn-danger remove"><span class="glyphicon glyphicon-trash"></span></a>
                    
                  </div>
                </div>
                <input type="hidden" name="product_id[]" value="'.$product_id.'"/>
                <input type="hidden" name="" value="'.$cart_item_id.'"/>
                <div class="col-md-2"><img class="img-responsive" src="'.$product_image.'"></div>
                <div class="col-md-2">'.$product_title.'</div>
                <div class="col-md-2"><input type="text" class="form-control quantity" value="'.$quantity.'" ></div>
                <div class="col-md-2"><input type="number" class="form-control price" value="'.$product_price.'" readonly="readonly"></div>
                <div class="col-md-2"><input type="number" class="form-control dollars" value="'.$product_price_dollars.'" readonly="readonly"></div>
                <div style="visibility:hidden" class="col-md-2"><input type="number" class="form-control dollar" value="'.$product_price_dollars.'" readonly="readonly"></div>
                <div style="visibility:hidden" class="col-md-2"><input type="number" class="form-control total" value="'.$product_price_dollars.'" readonly="readonly"></div>
              </div>';
        }
        
        echo '<div class="row">
              <div class="col-md-8"></div>
              <div class="col-md-4">
                <b class="net_total" style="font-size:20px;"> </b>
          </div>';
        if (!isset($_SESSION["uid"])) {
 
          echo '<input type="submit" style="float:right;" name="login_user_with_product" class="btn btn-info btn-lg" value="Ready to Checkout" >
              </form>';
            
        }else if(isset($_SESSION["uid"])){
          //Paypal checkout form
          echo '
            </form>
            <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
              <input type="hidden" name="cmd" value="_cart">
              <input type="hidden" name="business" value="shoppingcart@khanstore.com">
              <input type="hidden" name="upload" value="1">';
                
              $x=0;
              $sql = "SELECT a.Id,a.Title,a.DiscountedPrice,a.Image,b.Id,b.quantity, b.p_id FROM products a,cart b WHERE a.Id=b.p_id AND b.user_id ='" . $_SESSION['uid'] . "'";
              $query = mysqli_query($mysqli,$sql) or die("Error " . mysqli_error($mysqli));
              while($row=mysqli_fetch_array($query)){
                $x++;
                echo    
                  '<input type="hidden" name="item_name_'.$x.'" value="'.$row["Title"].'">
                     <input type="hidden" name="item_number_'.$x.'" value="'.$x.'">
                     <input type="hidden" name="amount_'.$x.'" value="'.$row["DiscountedPrice"].'">
                     <input type="hidden" name="quantity_'.$x.'" value="'.$row["quantity"].'">';
                }
                
              echo   
                '<input type="hidden" name="return" value="http://localhost/GIFT-SHOP/payment_success.php"/>
                          <input type="hidden" name="notify_url" value="http://localhost/GIFT-SHOP/payment_success.php">
                  <input type="hidden" name="currency_code" value="USD"/>
                  <input type="hidden" name="custom" value="'.$_SESSION["uid"].'"/>
                  
                  <input style="float:right;margin-right:80px;" type="image" name="submit"
                    src="https://www.paypalobjects.com/webstatic/en_US/i/btn/png/blue-rect-paypalcheckout-60px.png" alt="PayPal Checkout"
                    alt="PayPal - The safer, easier way to pay online">
                    <button type="button"style=" padding:15px;" class="btn btn-primary pull-left" data-toggle="modal" data-target="#checkoutModal">
 <span class="glyphicon glyphicon-user"></span>Confirm Personal Details<button>

                </form>';
        }
      }
  }
  
  
}


if (isset($_POST["removeItemFromCart"])) 
{
          $remove_id = $_POST["rid"];
          if (isset($_SESSION["uid"])) 
          {
             $sql = "DELETE FROM cart WHERE p_id ='" . $remove_id . "'AND user_id = '" . $_SESSION['uid'] . "'";
             $result=mysqli_query($mysqli,$sql) or die("There was an error " . mysqli_error($mysqli));
              if($result)
              {
                        echo "<div class='alert alert-danger'>
                                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                <b>Product is removed from cart</b>
                            </div>";
                        exit();
               }
         }else{
          $sql = "DELETE FROM cart WHERE p_id ='" . $remove_id . "'AND user_id = -1";
             $result=mysqli_query($mysqli,$sql) or die("There was an error " . mysqli_error($mysqli));
              if($result)
              {
                echo "<div class='alert alert-danger'>
                      <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                      <b>Product is removed from cart</b>
                      </div>";
                      exit();
               }

         }
}






?>






