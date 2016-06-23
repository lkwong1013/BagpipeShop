<?php
	session_start();
	extract($_POST);
	require_once("sql/sqlconnect.php");
    require_once("sql/DB_config.php");
    require_once("sql/sqlconnect.php");
    require_once("sql/sql_function.php");
    $db1 = new DB();//Handle Product Name for return use
    $db1->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
    $db1->query("SELECT product_name FROM Product WHERE product_id = '$pid'");
    $db1_rs = $db1->fetch_array();

	if(!isset($qty)){
		$qty = 1;
	}
	if($_SESSION['userid']!=""){
		//Logged In
		if(isset($_SESSION['cart_pid'])){
			//Have Some Product in Cart
			if(in_array($pid, $_SESSION['cart_pid'])){
				//Selected Product already in cart
				$cart_index  = array_search($pid, $_SESSION['cart_pid']); //Search index of Product in Cart array
				$cart_qty = $_SESSION['cart_qty'][$cart_index];//Get qty of product in cart
				$cart_qty += $qty;//Plus qty
				$_SESSION['cart_qty'][$cart_index] = $cart_qty;//Update the qty of product
				/*print_r($_SESSION['cart_pid']);
				print_r($_SESSION['cart_qty']);	*/
			}else{
				//Selected Product not in cart
				array_push($_SESSION['cart_pid'], $pid);
				array_push($_SESSION['cart_qty'], $qty);
				/*print_r($_SESSION['cart_pid']);
				print_r($_SESSION['cart_qty']);	*/
			}
		}else{
			//Nothing in Cart
			$_SESSION['cart_pid'] = array();
			$_SESSION['cart_qty'] = array();
			array_push($_SESSION['cart_pid'], $pid);
			array_push($_SESSION['cart_qty'], $qty);
			/*print_r($_SESSION['cart_pid']);	
			print_r($_SESSION['cart_qty']);	*/
		}
		echo $db1_rs['product_name'];
	}else{
		echo "login-first";
	}
	//print_r($_POST);
?>