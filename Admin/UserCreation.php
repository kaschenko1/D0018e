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
	<title>Create User</title>
	<link rel="stylesheet" type="text/css" href="../style.css">
</head>

<body>

	<form method="post" action="UserCreation.php">

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
			<label>E-mail Address: </label>
			<input type="email" name= "UserEmail" value="<?php echo $UserEmail; ?>">
		</div>

		<div class="reg-inp">
			<label>Firstname: </label>
			<input type="text" name="UserFirstName" value="<?php echo $UserFirstName; ?>">
		</div>

		<div class="reg-inp">
			<label>Lastname: </label>
			<input type="text" name="UserLastName" value="<?php echo $UserLastName; ?>">
		</div>

		<div class="reg-inp">
			<label>City: </label>
			<input type="text" name="UserCity" value="<?php echo $UserCity; ?>">
		</div>

		<div class="reg-inp">
			<label>State: </label>
			<input type="text" name="UserState" value="<?php echo $UserState; ?>">
		</div>

		<div class="reg-inp">
			<label>User Type</label>
			<select name="UserType" id = "UserType">
				<option value = ""></option>
				<option value = "admin">admin </option>
				<option value = "user">user </option>
			</select>
		</div>


		<div class="reg-inp">
			<label>Password: </label>
			<input type="password" name="password_1">
		</div>

		<div class="reg-inp">
			<label>Confirm password: </label>
			<input type="password" name="password_2">
		</div>

		<div class="reg-inp">
			<button type="submit" class="btn" name="register_btn"> Create User</button>
		</div>
	</form>
</body>
</html>
