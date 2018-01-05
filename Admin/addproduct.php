<?php 
include('../function.php');

if (!isAdmin()) {
		$_SESSION['msg'] = "You must log in first";
		header('location: ../Login.php');
	}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Create product</title>
	<link rel="stylesheet" type="text/css" href="../style.css">
</head>

<body>

	<form method="post" action="addproduct.php" enctype="multipart/form-data">
		




	<div class="nav">
		<ul>
			<li><a href="home.php">home</a></li>
			<li><a href="UserCreation.php"> add user</a></li>
			<li><a href="addproduct.php">Add Product</a></li>
			<li><a href="showusers.php">Show Users</a></li>
			<li><a href="showproducts.php">Show Products</a></li>
			<li><a href="showOrders.php">Show Orders</a></li>
			<li><a href="ProcessedOrders.php">Processed Orders</a></li>
			<li><a id = "loggautadmin" href="home.php?logout='1'"> Logout</a></li>
			</ul>
		</div>

		<?php echo display_error(); ?>

		<div class="reg-inp">
			<label>Product image: </label>
			<input type="file" name= "ProductPicture" value="<?php echo $ProductPicture; ?>">
		</div>

		<div class="reg-inp">
			<label>Product name: </label>
			<input type="text" name= "ProductName" value="<?php echo $ProductName; ?>">
		</div>

		<div class="reg-inp">
			<label>Product Price: </label>
			<input type="text" name="ProductPrice" value="<?php echo $ProductPrice; ?>">
		</div>

		<div class="reg-inp">
			<label>Quantity: </label>
			<input type="text" name="ProductStock" value="<?php echo $ProductStock; ?>">
		</div>

		<div class="reg-inp">
			<label>Product Description: </label>
			<input type="text" name="ProductDescription" value="<?php echo $ProductDescription; ?>">
		</div>



		<div class="reg-inp">
			<button type="submit" class="btn" name="add_product"> add product</button>
		</div>
	</form>
</body>
</html>