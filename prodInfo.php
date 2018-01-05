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
	<title>Product Information</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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


	<?php  getpInfo();?>

<script>	
function starred(id, elem){
	Srate = document.getElementById('rate');


	if(id == "S1"){
		document.getElementById('S1').classList.add('checked');
		document.getElementById('S2').classList.remove('checked');
		document.getElementById('S3').classList.remove('checked');
		document.getElementById('S4').classList.remove('checked');
		document.getElementById('S5').classList.remove('checked');
		Srate.value = 1;
	}

	else if(id == "S2"){
		document.getElementById('S1').classList.add('checked');
		document.getElementById('S2').classList.add('checked');
		document.getElementById('S3').classList.remove('checked');
		document.getElementById('S4').classList.remove('checked');
		document.getElementById('S5').classList.remove('checked');
		Srate.value = 2;
	}

	else if(id == "S3"){
		document.getElementById('S1').classList.add('checked');
		document.getElementById('S2').classList.add('checked');
		document.getElementById('S3').classList.add('checked');
		document.getElementById('S4').classList.remove('checked');
		document.getElementById('S5').classList.remove('checked');
		Srate.value = 3;
	}

	else if(id == "S4"){
		document.getElementById('S1').classList.add('checked');
		document.getElementById('S2').classList.add('checked');
		document.getElementById('S3').classList.add('checked');
		document.getElementById('S4').classList.add('checked');
		document.getElementById('S5').classList.remove('checked');
		Srate.value = 4;
	}

	else if(id == "S5"){
		document.getElementById('S1').classList.add('checked');
		document.getElementById('S2').classList.add('checked');
		document.getElementById('S3').classList.add('checked');
		document.getElementById('S4').classList.add('checked');
		document.getElementById('S5').classList.add('checked');
		Srate.value = 5;
	}
}
</script>


</body>
</html>