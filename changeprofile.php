<?php 
include('function.php'); 

if(!isLoggedIn()){
	$_SESSION['msg'] = "You must login first";
	header('location: Login.php');
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Profile</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>


<body>
					

	<div class="nav">
		<ul>
			<li><a href="index.php">home</a></li>
			<li><a href="shop.php">shop</a></li>
			<li><a href="changeprofile.php">profile</a></li>
			<li><a id="bild" href="showCart.php"></a></li>
			<form action="showsearched.php">
			<li><input id="testid" type="text" name="search" placeholder="Search product"><button id="butt" name="searchbtn"><img src="searchbtn.png" width="100%" height="100%" /></button></li></form>
			<li><a id = "loggaut" href="index.php?logout='1'"> Logout</a></li>
			</ul>
		</div>


	<?php getMyUser(); ?>

</body>
</html>