<?php 

include("../function.php");

if (!isAdmin()) {
		$_SESSION['msg'] = "You must log in first";
		header('location: ../Login.php');
	}
	?>

<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<link rel="stylesheet" type="text/css" href=" ../style.css">

</head>

<body id="hemma">	

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

</body>
</html>