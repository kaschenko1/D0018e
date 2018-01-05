<?php
session_start();

$db = mysqli_connect('localhost','root','root','TestSchema');

$UserEmail = "";
$UserFirstName = "";
$UserLastName = "";
$UserCity = "";
$UserState = "";
$errors = array();

if(isset($_POST['register_btn'])) {
	register();
}

if(isset($_POST['login_btn'])){
	login();
}

if(isset($_POST['add_product'])){
	addproduct();
}

if(isset($_GET['logout'])){
	session_destroy();
	unset($_SESSION['user']);
	header('location: ../Login.php');
}

if(isset($_POST['searchbtn'])){
    header('location:showsearched.php');
}


/* 
Register function with error handler
*/

function register(){
	global $db, $errors;

	$UserEmail = e($_POST['UserEmail']);
	$UserFirstName = e($_POST['UserFirstName']);
	$UserLastName = e($_POST['UserLastName']);
	$UserCity = e($_POST['UserCity']);
	$UserState = e($_POST['UserState']);
	$password_1 = e($_POST['password_1']);
	$password_2 = e($_POST['password_2']);

	if(empty($UserEmail)){
		array_push($errors,"E-Mail Is Required");
	}
	if(empty($UserFirstName)){
		array_push($errors,"Firstname Is Required");
	}
	if(empty($UserLastName)){
		array_push($errors,"Lastname Is Required");
	}
	if(empty($UserCity)){
		array_push($errors,"City Is Required");
	}
	if(empty($UserState)){
		array_push($errors,"State Is Required");
	}
	if(empty($password_1)){
		array_push($errors,"Password Is Required");
	}

	if($password_1 != $password_2){
		array_push($errors,"Passwords does not match");
	}

	if(count($errors) == 0){
		$UserPassword = md5($password_1);

		if(isset($_POST['UserType'])){
			$UserType = e($_POST['UserType']);
			$query = "INSERT INTO User (UserEmail,UserPassword,UserFirstName,UserLastName,UserCity,UserState,UserType) VALUES ('$UserEmail','$UserPassword','$UserFirstName','$UserLastName','$UserCity','$UserState','$UserType')";
			mysqli_query($db, $query);
			$_SESSION['success'] = "New user successfully created";
			header('location: home.php');
		}else{
			$query = "INSERT INTO User (UserEmail,UserPassword,UserFirstName,UserLastName,UserCity,UserState,UserType) VALUES ('$UserEmail','$UserPassword','$UserFirstName','$UserLastName','$UserCity','$UserState','user')";
			
			mysqli_query($db, $query);
            $logged_in_user_id = mysqli_insert_id($db);
			$_SESSION['user'] = getUserById($logged_in_user_id);
			$_SESSION['success'] = "You have successfully regged";
			header('location: index.php');
		}
	}
}


/*
A function that returns the userid
*/
function getUserById($id){
	global $db;
	$query = "SELECT * FROM User WHERE id=" . $id;
	$result = mysqli_query($db, $query);
	$user = mysqli_fetch_assoc($result);
	return $user;
}


/*
Login function that differentiates between an admin or a user
*/
function login(){
	global $db, $UserEmail, $errors;

	$UserEmail = e($_POST['UserEmail']);
	$UserPassword = e($_POST['UserPassword']);


	if(empty($UserEmail)){
		array_push($errors,"Email is required");}
	if(empty($UserPassword)){
		array_push($errors, "Password is required");}
	if(count($errors) == 0){
		$UserPassword = md5($UserPassword);
		$query = "SELECT * FROM User WHERE UserEmail='$UserEmail' AND UserPassword = '$UserPassword' LIMIT 1";
		$result = mysqli_query($db, $query);

		if(mysqli_num_rows($result) == 1){
			$logged_in_user = mysqli_fetch_assoc($result);
			if($logged_in_user['UserType'] == 'admin'){

				$_SESSION['user'] = $logged_in_user;
				$_SESSION['success'] = "You are now logged in";
				header('location: admin/home.php');
			}else{
				$q2 = "SELECT OrderID FROM Orders WHERE OrderUserID = '$logged_in_user[UserID]' AND OrderDate IS NULL AND OrderShipDate IS NULL";
				$resultid = mysqli_query($db,$q2);
				$logged_in_user_Oid = mysqli_fetch_assoc($resultid);

				$_SESSION['orderId'] = $logged_in_user_Oid['OrderID'];
				$_SESSION['UserID'] = $logged_in_user['UserID'];
				$_SESSION['user'] = $logged_in_user;
				$_SESSION['success'] = "You are now logged in";
				header('location: index.php');

			}
		}else{
			array_push($errors, "wrong username or password");
		}
	}
}



/*
A fuction for adding products as admin
*/
function addproduct(){
	global $db,$errors;

	$ProductPicture = $_FILES['ProductPicture']['name'];
	$ProductPicture_tmp = $_FILES['ProductPicture']['tmp_name'];
	move_uploaded_file($ProductPicture_tmp,"prod_img/$ProductPicture");

	$ProductName = e($_POST['ProductName']);
	$ProductPrice = e($_POST['ProductPrice']);
	$ProductDescription = e($_POST['ProductDescription']);
	$ProductStock = e($_POST['ProductStock']);

    if(empty($ProductPicture)){
        array_push($errors,"An Image is required");
    }
    if(empty($ProductName)){
        array_push($errors,"A Name is required");
    }
    if(empty($ProductPrice)){
        array_push($errors,"A Price is required");
    }
    if(empty($ProductDescription)){
        array_push($errors,"A Description is required");
    }
    if(empty($ProductStock)){
        array_push($errors,"An amount is required");
    }
    if(count($errors) == 0){
	$query = "INSERT INTO Products (ProductName,ProductPrice,ProductPicture,ProductDescription,ProductStock) VALUES ('$ProductName','$ProductPrice','$ProductPicture','$ProductDescription','$ProductStock') ";
	mysqli_query($db,$query);
	$_SESSION['success'] = "New product successfully created";
	header('location: home.php');
    }
}


/*
A function that selects all the registered users and displays them for admin, possible to delete the user if they are not registered to an order.
*/
function getusers(){
	global $db;

    if(isset($_POST['dlt_user_btn'])){
        $sqlgetID = "SELECT OrderUserID FROM Orders Where OrderUserID = '$_POST[hidden]'";
        $qID = mysqli_query($db,$sqlgetID);
        $fetchID = mysqli_fetch_assoc($qID);
        $_SESSION['OrderUID'] = $fetchID['OrderUserID'];
        if($_SESSION['OrderUID']){
            echo "<p>".$_SESSION['OrderUID']."</p>";
            echo "<p> This User has a Registered Order with OrderUserID: ".$_SESSION['OrderUID']." <a href='showOrders.php'>Show Orders</a></p>";
            }else{
                $sqld = "DELETE FROM User WHERE UserID ='$_POST[hidden]'"; ///FEEEEEEEL
                mysqli_query($db,$sqld);
                echo "<p> Sucessfully deleted</p>";
            }
        }

	$sql = "SELECT * FROM User";
	$records = mysqli_query($db,$sql);

	echo "<table id='AllUserProfile' border = 1 cellpaddin = 1 cellspacing = 1 style = 'position: center;'>
        <tr>
            <th>UserID</th>
            <th>E-mail </th>
            <th>Firstname </th>
            <th>Lastname </th>
            <th>City </th>
            <th>State </th>
            <th>type</th>
            <th>Delete</th>
        </tr>";

	while($row=mysqli_fetch_array($records)){



        echo"<form method='post' action='showusers.php'>";
        echo "<tr>";
        echo "<td>".$row['UserID']."</td>";
        echo "<td>".$row['UserEmail']."</td>";
        echo "<td>".$row['UserFirstName']."</td>";
        echo "<td>".$row['UserLastName']."</td>";
        echo "<td>".$row['UserCity']."</td>";
        echo "<td>".$row['UserState']."</td>";
        echo "<td>".$row['UserType']."</td>";
        echo "<input type='hidden' name='hidden' value =".$row['UserID']."</input>";
        echo "<td><button type='submit' class='btn' name='dlt_user_btn'> Delete</button></td>";
        echo "</tr>";
        echo "</form>";
    }
}

/*
A function that displays all requested orders that needs to be confirmed by an admin
*/

function getOrders(){
	global $db;
    if(isset($_POST['dlt_ord_btn'])){
        $sqlD1 = "DELETE FROM ShoppinCart WHERE OrderID ='$_POST[hidden]'";
        mysqli_query($db,$sqlD1);
        $sqlDO = "DELETE FROM Orders Where OrderID = '$_POST[hidden]'";
        mysqli_query($db,$sqlDO);
        echo "<p>Sucessfully deleted order and shoppin</p>";
}

	$sql = "SELECT * FROM Orders WHERE OrderDate IS NOT NULL AND OrderShipDate IS NULL";
	$records = mysqli_query($db,$sql);

	echo " <table id='AllOrders' border = 1 cellpaddin = 1 cellspacing = 1 style = 'position: center;'>
            <tr>
            	<th>OrderID</th>
                <th>OrderUserID </th>
                <th>Delete</th>
                <th>Process</th>     
             </tr>";

	while($row=mysqli_fetch_array($records)){

        echo"<form method='post' action='showOrders.php'>";
        echo "<tr>";
        echo "<td>".$row['OrderID']."</td>";
        echo "<td>".$row['OrderUserID']."</td>";
        echo "<input type='hidden' name='hidden' value =".$row['OrderID']."</input>";
        echo "<td><button type='submit' class='btn' name='dlt_ord_btn'> Delete</button></td>";
        echo "<td><button class = 'btn'><a href='ProcessOrder.php?OrdersID=".$row['OrderID']."'>process</a></button></td>";
        echo "</tr>";
        echo "</form>";
    }
}

/*
A function that displays all requested and confirmed orders with timestamps
*/
function getprocessOrders(){
    global $db;
    if(isset($_POST['dlt_ord_btn'])){
        $sqlD1 = "DELETE FROM ShoppinCart WHERE OrderID ='$_POST[hidden]'";
        mysqli_query($db,$sqlD1);
        $sqlDO = "DELETE FROM Orders Where OrderID = '$_POST[hidden]'";
        mysqli_query($db,$sqlDO);
        echo "<p>Sucessfully deleted order and shoppin</p>";
    }
    $sql = "SELECT * FROM Orders WHERE OrderShipDate IS NOT NULL";
    $records = mysqli_query($db,$sql);
    
    echo " <table id='AllOrders' border = 1 cellpaddin = 1 cellspacing = 1 style = 'position: center;'>
        <tr>
            <th>OrderID</th>
            <th>OrderUserID </th>
            <th>OrderDate</th>
            <th>Shipped</>
            <th>Delete</th>
        </tr> ";

    while($row=mysqli_fetch_array($records)){

        echo"<form method='post' action='ProcessedOrders.php'>";
        echo "<tr>";
        echo "<td>".$row['OrderID']."</td>";
        echo "<td>".$row['OrderUserID']."</td>";
        echo "<input type='hidden' name='hidden' value =".$row['OrderID']."</input>";
        echo "<td>".$row['OrderDate']."</td>";
        echo "<td>".$row['OrderShipDate']."</td>";
        echo "<td><button type='submit' class='btn' name='dlt_ord_btn'> Delete</button></td>";
        echo "</tr>";
        echo "</form>";
    }
    
}

/*
A function that lets and admin confirm requested orders
*/
function processOrders(){
	global $db;
    echo " <table id='AllOrders' border = 1 cellpaddin = 1 cellspacing = 1 style = 'position: center;'>
            <tr>
            	<th>E-Mail adress</th>
                <th>FirstName </th>
                <th>LastName </th>
                <th>City </th>
                <th>State </th>
            </tr>";

	if(isset($_GET['OrdersID'])){
		$sqll = "SELECT OrderUserID FROM Orders WHERE OrderID = '$_GET[OrdersID]'";
		$sel = mysqli_query($db,$sqll);
		$fetchOrd = mysqli_fetch_assoc($sel);
		$userID = $fetchOrd['OrderUserID'];

		$sqlU = "SELECT * FROM User Where UserID = '$userID'";
		$uSel = mysqli_query($db,$sqlU);
		$fetchSel = mysqli_fetch_assoc($uSel);

		echo"<form method='post' action='ProcessOrder.php?OrdersID=".$_GET['OrdersID']."'>";
        echo "<tr>";
		echo "<td>".$fetchSel['UserEmail']."</td>";
		echo "<td>".$fetchSel['UserFirstName']."</td>";
		echo "<td>".$fetchSel['UserLastName']."</td>";
		echo "<td>".$fetchSel['UserCity']."</td>";
		echo "<td>".$fetchSel['UserState']."</td>";
		echo "</tr>";
		echo "<button type='submit' class='shipbtn' name='send_ship'> Send</button>";
        echo "</form>";

        $sqlP = "SELECT ProductID, Quantity FROM ShoppinCart WHERE OrderID = '$_GET[OrdersID]'";
        $sSel = mysqli_query($db,$sqlP);

        echo "<table id='AllOrders' border = 1 cellpaddin = 1 cellspacing = 1 style = 'position: center;'>
        <tr>
            <th>ProductID</th>
            <th>Amount </th>
        </tr>";

        while($rowchart=mysqli_fetch_array($sSel)){
            echo"<form method='post' action='ProcessOrder.php?OrdersID=".$_GET['OrdersID']."'>";
            echo "<tr>";
            echo "<td>".$rowchart['ProductID']."</td>";
            echo "<td>".$rowchart['Quantity']."</td>";
            echo "</tr>";
            echo "</form>";
        }

      if(isset($_POST['send_ship'])){
        $senddate = date_create()->format('Y-m-d H:i:s');
		$upsql = "UPDATE Orders SET OrderShipDate = '$senddate' WHERE OrderID = ".$_GET['OrdersID']."";
		mysqli_query($db,$upsql);
		echo "<p>skickad</p>";
    }
	}
}


/*
A function that displays all registered products with possibility to change product information or remove it.
*/

function getAproducts(){
	global $db;
    if(isset($_POST['dlt_prod_btn'])){
        $sqld = "DELETE FROM Products WHERE ProductID ='$_POST[hidden]'";
        mysqli_query($db,$sqld);
    }
    if(isset($_POST['updt_prod_btn'])){
        $sqld = "UPDATE Products SET ProductPrice ='$_POST[ProductPrice]',ProductDescription ='$_POST[ProductDescription]',ProductStock ='$_POST[ProductStock]' WHERE ProductID ='$_POST[hidden]'";
        mysqli_query($db,$sqld);
    }

	$sql = "SELECT * FROM Products";
	$records = mysqli_query($db,$sql);

		 echo "<table id='ProductsProfile' border = 1 cellpaddin = 1 cellspacing = 1 style = 'position: center;'>
            <tr>
            	<th>Product ID</th>
                <th>Product Name </th>
                <th>Product Price </th>
                <th>Product Description </th>
                <th>Product quantity </th>
                <th>Delete</th>
                <th>Update</th>
                <th>View Comments</th>
                </tr>";

	while($row=mysqli_fetch_array($records)){

        echo"<form method='post' action='showproducts.php'>";
        echo "<tr>";
        echo "<td>".$row['ProductID']."</td>";
        echo "<td>".$row['ProductName']."</td>";
        echo "<td>"."<input type='text' name='ProductPrice' value=".$row['ProductPrice']."></td>";
        echo "<td>"."<input type='text' name='ProductDescription' value= '".$row['ProductDescription']."'></td>";
        echo "<td>"."<input type='text' name='ProductStock' value=".$row['ProductStock']."></td>";
        echo "<input type='hidden' name='hidden' value =".$row['ProductID']."</input>";
        echo "<td><button type='submit' class='btn' name='dlt_prod_btn'> Delete</button></td>";
        echo "<td><button type='submit' class='btn' name='updt_prod_btn'> Update</button></td>";
        echo "<td><button><a href = 'comInfo.php?ProdID=".$row['ProductID']."'> View Comments</a></button></td>";
        echo "</tr>";
        echo "</form>";
        }

}



/*
A function that displays the products for the customer side, and the ability to put it into their shopping cart.
*/
function getproducts(){
	global $db;
	$getprod = "SELECT * FROM Products";
	$run_getprod = mysqli_query($db,$getprod);

	while($row_prods=mysqli_fetch_array($run_getprod)){
        $prods_price = $row_prods['ProductPrice'];
        $prods_img = $row_prods['ProductPicture'];
        $maxval = $row_prods['ProductStock'];

        echo"<form method='post' action='shop.php'>";
        echo "<div class='singleproduct' style= 'border-bottom: 1px solid #222;'>";
        echo "<br>";
        echo "<h2>".$row_prods['ProductName']."</h2>";
        echo "<a href = 'prodInfo.php?ProdID=".$row_prods['ProductID']."'> <img src='Admin/$prods_img' width='200' height='200' /></a>";
        echo "<input type='hidden' name='hidden' value =".$row_prods['ProductID']."</input>";
        echo "<button type='submit' class='btn' name='cartadder'> Add to cart</button></td><input name='quant' style='width: 50px;' type='number' value= '1' min='1' max='$maxval'>";
        echo "<input type='hidden' name='hiddenprice' value ='".$row_prods['ProductPrice']."'></input>";
        echo "<p>Price: <b>$prods_price</b></p>";
        echo "</div>";
        echo "</form>";
	}

	if(isset($_POST['cartadder'])){
		if(!isset($_SESSION['orderId'])){

			$query = "INSERT INTO Orders (OrderUserID) VALUES ('".$_SESSION['UserID']."')";
			mysqli_query($db,$query);
			$_SESSION['orderId'] = mysqli_insert_id($db);
        }
		$shop = "INSERT INTO ShoppinCart(OrderID, ProductID, Quantity, ProductPrice) VALUES ('".$_SESSION['orderId']."', '".$_POST['hidden']."','".$_POST['quant']."'
        ,'".$_POST['hiddenprice']."')";
		mysqli_query($db,$shop);

	}
}


/*
A function that displays the specific product information such as rating, comments, description of product. And allows user to rate, comment and add it to cart if wished. 
*/
function getpInfo(){
	global $db;

    if(isset($_POST['sendaway'])){
        $sqlC = "INSERT INTO Comments(CommentUserID, CommentMsg, CommentProductID, Rating) VALUES 
        ('" . $_SESSION['UserID'] . "', '" .$_POST['cmt']. "' , '" .$_GET['ProdID'] . "', '" . $_POST['rate'] . "')";
        mysqli_query($db,$sqlC);
    }

	$sqlinf = "SELECT * FROM Products WHERE ProductID = '$_GET[ProdID]'";
	$go = mysqli_query($db,$sqlinf);
    $sqlGet = "SELECT Rating FROM Comments WHERE CommentProductID = $_GET[ProdID]";
    $getr = mysqli_query($db,$sqlGet);
    $total = 0;
    $cnt = 0;
    while($gRate=mysqli_fetch_array($getr)) {
        $total = $total+ $gRate['Rating'];
        $cnt++;
    }
    $rat = 0;
    if($cnt != 0){
        $rat = $total / $cnt;
    }
	while($rowinfo=mysqli_fetch_array($go)){
		$prods_img = $rowinfo['ProductPicture'];
        $maxval = $rowinfo['ProductStock'];

        echo "<div class= 'wrapper' style= 'border-bottom: 1px solid #222;'>";
        echo "<div class='ssingleproduct'>";
        echo"<form method='post' action='prodInfo.php?ProdID=".$_GET['ProdID']."'>";
        echo "<br>";
        echo "<div class='ratingstar'>";
    if(($rat >= 0.0) && ($rat <= 0.5)){
        echo "<span class='fa fa-star '></span>";
        echo "<span class='fa fa-star '></span>";
        echo "<span class='fa fa-star '></span>";
        echo "<span class='fa fa-star '></span>";
        echo "<span class='fa fa-star '></span>";
    }
    else if(($rat >= 0.5) &&($rat <= 1.5)){
        echo "<span class='fa fa-star checked'></span>";
        echo "<span class='fa fa-star '></span>";
        echo "<span class='fa fa-star '></span>";
        echo "<span class='fa fa-star '></span>";
        echo "<span class='fa fa-star '></span>";
    }
    else if(($rat >= 1.5) &&($rat <= 2.5)){
        echo "<span class='fa fa-star checked'></span>";
        echo "<span class='fa fa-star checked'></span>";
        echo "<span class='fa fa-star '></span>";
        echo "<span class='fa fa-star '></span>";
        echo "<span class='fa fa-star '></span>";
    }
    else if(($rat >= 2.5) &&($rat <= 3.5)){
        echo "<span class='fa fa-star checked'></span>";
        echo "<span class='fa fa-star checked'></span>";
        echo "<span class='fa fa-star checked'></span>";
        echo "<span class='fa fa-star '></span>";
        echo "<span class='fa fa-star '></span>";
    }
    else if(($rat >= 3.5) &&($rat <= 4.5)){
        echo "<span class='fa fa-star checked'></span>";
        echo "<span class='fa fa-star checked'></span>";
        echo "<span class='fa fa-star checked'></span>";
        echo "<span class='fa fa-star checked'></span>";
        echo "<span class='fa fa-star '></span>";
    }
    else if(($rat >= 4.5) && ($rat <= 5.0)){
        echo "<span class='fa fa-star checked'></span>";
        echo "<span class='fa fa-star checked'></span>";
        echo "<span class='fa fa-star checked'></span>";
        echo "<span class='fa fa-star checked'></span>";
        echo "<span class='fa fa-star checked'></span>";
    }
        echo "</div>";
        echo "<h4>".$rowinfo['ProductName']."</h4>";
        echo "<a href = 'prodInfo.php?ProdID=".$rowinfo['ProductID']."'> <img src='Admin/$prods_img' width='400' height='400' /></a>";
        echo "<input type='hidden' name='hidden' value =".$rowinfo['ProductID']."</input>";
        echo "<button type='submit' class='btn' name='cartadder'> Add to cart</button></td><input name='quant' style='width: 50px;' type='number' value= '1' min='1' max='$maxval'>";
         echo "<input type='hidden' name='hiddenprice' value ='".$rowinfo['ProductPrice']."'></input>";
        echo "<p><b>".$rowinfo['ProductPrice']."</b> kr</p>";
        echo "</form>";
        echo "</div>";
        echo "<div class= 'pDes'>";
        echo "<p>".$rowinfo['ProductDescription']."</p>";
        echo "</div>";

        echo "<div class = 'CR'>";
        echo"<form method='post' action='prodInfo.php?ProdID=".$_GET['ProdID']."'>";
        echo "<input id='rate' name='rate' style='width: 50px;' type='hidden' min='0' max='5'</input>";

        echo "<span id='S1' class='fa fa-star ' onclick='starred(this.id,this)'></span>";
        echo "<span id='S2' class='fa fa-star ' onclick='starred(this.id,this)'></span>";
        echo "<span id='S3' class='fa fa-star ' onclick='starred(this.id,this)'></span>";
        echo "<span id='S4' class='fa fa-star ' onclick='starred(this.id,this)'></span>";
        echo "<span id='S5' class='fa fa-star ' onclick='starred(this.id,this)'></span>";
        echo "<textarea name = 'cmt' rows='4' cols='25'></textarea>";
        echo "<button type='submit' class='btn' name='sendaway'> send</button>";
         echo "</form>";
        echo"</div>";
        echo "</div>";
    }
    

    $sqlGetC = "SELECT Comments.CommentMsg, User.UserFirstName FROM Comments INNER JOIN User ON Comments.CommentUserID = User.UserID WHERE CommentProductID = $_GET[ProdID] AND Comments.CommentMsg IS NOT NULL";
    $getC = mysqli_query($db,$sqlGetC);
    while($gCom=mysqli_fetch_array($getC)) {
        if(($gCom['CommentMsg'] != " ") &&($gCom['CommentMsg'] != "")){
            echo "<div class= 'comments'> ";
        	echo"<p id ='uscom'>".$gCom['UserFirstName']."</p>";
            echo "<p>".$gCom['CommentMsg']."</p>";
            echo"</div>";
        }
    }

    

    if(isset($_POST['cartadder'])){
        if(!isset($_SESSION['orderId'])){
            $query = "INSERT INTO Orders (OrderUserID) VALUES ('".$_SESSION['UserID']."')";
            mysqli_query($db,$query);
            $_SESSION['orderId'] = mysqli_insert_id($db);
        }

        $shop = "INSERT INTO ShoppinCart(OrderID, ProductID, Quantity, ProductPrice) VALUES ('".$_SESSION['orderId']."', '".$_POST['hidden']."','".$_POST['quant']."'
        ,'".$_POST['hiddenprice']."' )";
        mysqli_query($db,$shop);
    }
}


/*
A function that displays the customers shopping cart. Change amount of a product or remove it, and set their order in motion. 
*/
function getCart(){
	global $db;
    if(isset($_POST['cartRemover'])){
        $del = "DELETE FROM ShoppinCart WHERE ProductID ='$_POST[hidden]'";
        mysqli_query($db,$del);
    }

    if(isset($_POST['updatequant'])){
        $sqlupd = "UPDATE ShoppinCart SET Quantity = '$_POST[Quantity]' WHERE ProductID ='$_POST[hidden]'";
        mysqli_query($db,$sqlupd);
    }

	$sql = "SELECT ShoppinCart.ProductID, Products.ProductName, Products.ProductPicture, ShoppinCart.Quantity, Products.ProductPrice, Products.ProductStock FROM ShoppinCart INNER JOIN Products ON ShoppinCart.ProductID = Products.ProductID WHERE OrderID = ".$_SESSION['orderId']."";
	$result = mysqli_query($db,$sql);

	$produkter = array();
	$amount = array();

	while($row_cart=mysqli_fetch_array($result)){
		$prods_img = $row_cart['ProductPicture'];
		$maxval = $row_cart['ProductStock'];
		array_push($produkter, $row_cart['ProductID']);
		array_push($amount, $row_cart['Quantity']);
		
		echo"<form method='post' action='showCart.php'>";
		echo "<div class='cartproduct' style= 'border-bottom: 1px solid #222;'>";
		echo "<a href = 'prodInfo.php?ProdID=".$row_cart['ProductID']."'> <img src='Admin/$prods_img' width='200' height='200' /></a>";
		echo"<p>".$row_cart['ProductName']."</p>";
		echo"<p>".$row_cart['ProductPrice']."</p>";
		echo "<p></td><input name='Quantity' style='width: 50px;' type='number' min='1' max='$maxval' value=".$row_cart['Quantity']."><button type='submit' class='btn' name='updatequant'> update</button> </p>";
		echo "<input type='hidden' name='hidden' value =".$row_cart['ProductID']."</input>";
		echo "<td><button type='submit' class='btn' name='cartRemover'> Delete</button></td>";
		echo "</div>";
		echo "</form>";

		$summa = $summa + $row_cart['ProductPrice'] * $row_cart['Quantity'];
	}

    if($summa != 0){
    
	echo"<form method='post' action='showCart.php'>";
    echo "<div class='productprice'>";
	echo"<p>Total SEK : $summa<button type='submit' class='confirmbtn' name='Orderbtn'> CHECKOUT</button></p>";
    echo "</div>";
    echo "</form>";

    if(isset($_POST['Orderbtn'])){
        $currdate = date_create()->format('Y-m-d H:i:s');
        $sqlupdate = "UPDATE Orders SET OrderDate = '$currdate' WHERE OrderID = ".$_SESSION['orderId']."";
        mysqli_query($db,$sqlupdate);

        for($n=0; $n<count($amount); $n++){
            $sqlOup = "UPDATE Products SET ProductStock = ProductStock - $amount[$n] WHERE ProductID = $produkter[$n]";
            mysqli_query($db,$sqlOup);
        }
        echo "<p> Your order will now be handled</p>";
        unset($_SESSION['orderId']);
    }
    }else{
        echo "<p id = 'Semp'>Shopping cart is empty</p>";
    }
}

/*
A function that displays the customers user information, and the ability to change information if needed. 
*/
function getMyUser(){
	global $db,$errors;
    if(isset($_POST['updt_user_btn'])){

        $updtuser = "UPDATE User SET UserEmail ='$_POST[UserEmail]',UserFirstName ='$_POST[UserFirstName]',UserLastName ='$_POST[UserLastName]',UserCity ='$_POST[UserCity]',UserState ='$_POST[UserState]' WHERE UserID ='$_POST[hidden]'";
        mysqli_query($db,$updtuser);    
    }
	$myinfo = "SELECT * FROM User WHERE UserID=('".$_SESSION['UserID']."')";
	$records = mysqli_query($db,$myinfo);



	 echo "<table id='UserProfile' border = 1 cellpaddin = 1 cellspacing = 1 style = 'position: center;'>
            <tr>
                <th>E-mail </th>
                <th>Firstname </th>
                <th>Lastname </th>
                <th>City </th>
                <th>State </th>
                <th></th>
            </tr>";


	while($rowuser=mysqli_fetch_array($records)){
        echo"<form method='post' action='changeprofile.php'>";
        echo "<tr>";
        echo "<td>"."<input type='text' name = 'UserEmail' value =".$rowuser['UserEmail']."></td>";
        echo "<td>"."<input type='text' name = 'UserFirstName' value ='".$rowuser['UserFirstName']."'></td>";
        echo "<td>"."<input type='text' name = 'UserLastName' value ='".$rowuser['UserLastName']."'></td>";
        echo "<td>"."<input type='text' name = 'UserCity' value ='".$rowuser['UserCity']."'></td>";
        echo "<td>"."<input type='text' name = 'UserState' value ='".$rowuser['UserState']."'></td>";
        echo "<input type='hidden' name='hidden' value ='".$rowuser['UserID']."'></input>";
        echo "<td><button type='submit' class='UPB' name='updt_user_btn'> SAVE</button></td>";
        echo "</tr>";
        echo "</form>";
        }

	
}



function getSearched(){
    global $db;
    if(isset($_GET['search'])){
        $sqlsearch = "SELECT * FROM Products WHERE ProductName LIKE '%".$_GET['search']."%'";
        $searchquery = mysqli_query($db,$sqlsearch);
        if(mysqli_num_rows($searchquery) != 0){
        while ($row = mysqli_fetch_assoc($searchquery)) {
            $prods_price = $row['ProductPrice'];
            $prods_img = $row['ProductPicture'];
            $maxval = $row['ProductStock'];


            

            echo"<form method='post' action='shop.php'>";
            echo "<div class='singleproduct' style= 'border-bottom: 1px solid #222;'>";
            echo "<br>";
            echo "<h2>".$row['ProductName']."</h2>";
            echo "<a href = 'prodInfo.php?ProdID=".$row['ProductID']."'> <img src='Admin/$prods_img' width='200' height='200' /></a>";
            echo "<input type='hidden' name='hidden' value =".$row['ProductID']."</input>";
            echo "<button type='submit' class='btn' name='cartadder'> Add to cart</button></td><input name='quant' style='width: 50px;' type='number' value= '1' min='1' max='$maxval'>";
            echo "<input type='hidden' name='hiddenprice' value ='".$row['ProductPrice']."'></input>";
            echo "<p>Price: <b>$prods_price</b></p>";
            echo "</div>";
            echo "</form>";
    }
}else{
    echo "<p id = 'Semp';>No such product exists</p>";
}
}
 


}





function getComments(){
    global $db;
    if(isset($_POST['com_del_btn'])){
        $delC = "UPDATE Comments SET CommentMsg = NULL WHERE CommentID = ".$_POST[hidden]."";
        mysqli_query($db,$delC);

}
    $sqlGetC = "SELECT Comments.CommentMsg, User.UserFirstName, Comments.CommentID FROM Comments INNER JOIN User ON Comments.CommentUserID = User.UserID WHERE CommentProductID = $_GET[ProdID] AND Comments.CommentMsg IS NOT NULL";
    $getC = mysqli_query($db,$sqlGetC);
        
    while($gCom=mysqli_fetch_array($getC)) {
        if(($gCom['CommentMsg'] != " ") &&($gCom['CommentMsg'] != "")){
            echo"<form method='post' action='comInfo.php?ProdID=".$_GET['ProdID']."'>";
            echo "<div class= 'comments'> ";
            echo"<p id ='uscom'>".$gCom['UserFirstName']."</p>";
            echo "<p>".$gCom['CommentMsg']."</p>";
            echo "<input type='hidden' name='hidden' value =".$gCom['CommentID']."></input>";
            echo "<button type='submit' class='UPB' name='com_del_btn'> Delete</button>";
            echo"</div>";
            echo"</form>";
        }


}
    





}











/*
boolean function that confirms if someone is logged in.
*/
function isLoggedIn(){
	if(isset($_SESSION['user'])){
		return true;
	}else{
		return false;
	}
}
/*
boolean function that confirms is the logged in user is an admin
*/
function isAdmin(){
	if (isset($_SESSION['user']) && ($_SESSION['user']['UserType'] == 'admin' )) {
			return true;
		}else{
			return false;
		}
}

/*
convert function.
*/
function e($val){
	global $db;
	return mysqli_real_escape_string($db, trim($val));
}

/*
Error handling function. 
*/
function display_error(){
	global $errors;

	global $errors;

		if (count($errors) > 0){
			echo '<div class="error">';
				foreach ($errors as $error){
					echo $error .'<br>';
				}
			echo '</div>';
		}
}
?>