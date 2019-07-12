<?php
$mysqli = new mysqli("localhost", "102600", "choco95*", "Giftit");
$sql= "SELECT * FROM categories WHERE Parent = 0";
$pquery=$mysqli->query($sql);
?>

<header>
<nav class="navbar navbar fixed-top navbar-light bg-light">
	<a href="mainpage.php" class="navbar-brand"><img src="images/download.jpg" width="50"></a>
			<ul class="nav navbar-nav navbar-right">
				
				<?php while($Parent =mysqli_fetch_assoc($pquery)):?>
					<?php 
					$Parent_ID=$Parent['Id'];
					$sql2="SELECT * FROM categories WHERE Parent = '$Parent_ID'";
					$cquery=$mysqli->query($sql2);
					?>
				<li><a href="" class="dropdown-toggle" data-toggle="dropdown"><?php echo $Parent['CategoryName'] ?><span class="caret"></span></a>
     				<ul>
     					 <?php
     					 while($child = mysqli_fetch_assoc($cquery)): ?>
     					<li><a href="category.php?cate=<?=$child['Id'];?>"><?php echo $child['CategoryName'];?> </a></li>
     				<?php endwhile; ?>
     				</ul>
				</li>
 				<?php endwhile;?>
				<li><a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-shopping-cart"></span>Cart<span class="badge">0</span></a>
					<div class="dropdown-menu" style="width:400px;">
						<div class="panel panel-success">
							<div class="panel-heading">
								<div class="row">
									<div class="col-md-3">Sl.No</div>
									<div class="col-md-3">Product Image</div>
									<div class="col-md-3">Product Name</div>
									<div class="col-md-3">Price in $.</div>
								</div>

							</div>

							<div class="panel-body">
								<div id="cart_product">
									
								</div>
							</div>
							<div class="panel-footer"></div>
						</div>
					</div>
				</li>
				<li> <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span>SignIn<span class="caret"></span></a>
					<ul>
						<li>
						<a href="register.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a>
					</li>
					<li>
						<a href="LoginForm.php"><span class="glyphicon glyphicon-log-in"></span> Login</a>
					</li>
				</ul>
				</li>
 					
				
                 
			</ul> 
		</nav>
	</header>
	