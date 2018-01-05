<?php include('function.php') ?>
<!DOCTYPE html>
<html>
<head>
	<title>login</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body id="hemma">


	<form method="post" action="Login.php">

			<?php echo display_error();
			 ?>
		<div class="nav">
		<ul>
			<li id="loginmail"><label style="color: white;">E-mail: </label><input type="email" name="UserEmail"></li>

			<li id="loginpass"><label style="color: white;">Password: </label><input type="password" name="UserPassword"></li>

			<li id="loginbutt"><button type="submit" class="lgnbtn" name="login_btn">Login</button></li>

			<li id="rl"><a style="margin-top: 5px; margin-left: 20px; width: 100%;" href="register.php">or Register now</a></li>

			</ul>
		</div>
		

	</form>

</body>
</html>