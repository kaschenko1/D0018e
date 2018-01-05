<?php include('function.php') ?>

<!DOCTYPE html>
<html>
<head>
	<title>Registration</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>


<body>
	<div class="header">
		<h2>Register</h2>
	</div>
	
	<form method="post" action="register.php">

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
			<label>Password: </label>
			<input type="password" name="password_1">
		</div>


		<div class="reg-inp">
			<label>Confirm password: </label>
			<input type="password" name="password_2">
		</div>


		<div class="reg-inp">
			<button type="submit" class="btn" name="register_btn">Register</button>
		</div>

		<div class="reg-inp">
		<p>
			Already a member? <a href="Login.php">Sign in</a>
		</p>
	</div>

	
	</form>
</body>
</html>