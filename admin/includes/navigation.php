<header>
<nav class="navbar navbar fixed-top navbar-light bg-light">
	<a href="mainpage.php" class="navbar-brand"><img src="../images/download.jpg" width="50"></a>
			<ul class="nav navbar-nav navbar-right">
               
			   <li><a href="brands.php">Brands</a></li>
                <li><a href="categories.php">Categories</a></li>
				<li><a href="producttags.php">Product Tags</a></li>
				 <li><a href="products.php">Products</a></li>
				 <li><a href="view_registeredusers.php">View Registered Users</a></li>
				 <li><a href="vieworders.php">View Orders</a></li>
				

			 <!-- to check	 if someone has permission to access the users page -->
				 	<?php if(has_permission('admin')): ?>
				 
				 		<li><a href="users.php">Users</a></li>
					<?php endif; ?>
					<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">Hello-<?=$user_data['first'];?>
					<span class="caret"></span>
					</a>
					<ul class="dropdown-menu" role="menu">
						<li><a href="change-password.php">Change Password</a></li>
						<li><a href="logout.php">Logout</a></li>
					</ul>
					</li> 
				<!--
				<li><a href="" class="dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></a>
     				<ul>
     					
     					<li><a href="category.php?cate= </a></li>
     				
     				</ul>
				</li> -->
 				
 				<li>
 					<!--<a href="cart.php"><span class="glyphicon glyphicon-shopping-cart"></span> Cart</a> -->
 				</li>
			<!--	<li><a href="register.html"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li> -->
             <!--   <li><a href="LoginForm.html"><span class="glyphicon glyphicon-log-in"></span> Login</a></li> -->
			</ul> 
		</nav>
	</header>
	