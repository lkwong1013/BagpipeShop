<?php
	session_start();
	/*---Database---*/
    
    require_once("sql/sqlconnect.php");
    require_once("sql/DB_config.php");
    require_once("sql/sqlconnect.php");
    require_once("sql/sql_function.php");
    $db = new DB();//Handle product price
    $db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
	/*---Database---*/
	extract($_POST);

	if($qty == 0){ //If user input 0

		$cart_index = array_search($pid, $_SESSION['cart_pid']);
		$_SESSION['cart_pid'][$cart_index] = "";
		$_SESSION['cart_qty'][$cart_index] = "";
		$new_pid = array();
		$new_qty = array();

		for($i=0;$i<count($_SESSION['cart_qty']);$i++){
			if($_SESSION['cart_pid'][$i] != "" && $_SESSION['cart_qty'][$i] != ""){
			array_push($new_pid, $_SESSION['cart_pid'][$i]);
			array_push($new_qty, $_SESSION['cart_qty'][$i]);
			}
		}

		unset($_SESSION['cart_pid']);
		unset($_SESSION['cart_qty']);
		$_SESSION['cart_pid'] = array();
		$_SESSION['cart_qty'] = array();
		for($i=0;$i<count($new_pid);$i++){
			array_push($_SESSION['cart_pid'], $new_pid[$i]);
			array_push($_SESSION['cart_qty'], $new_qty[$i]);
		}

		//print_r($_SESSION['cart_pid']);

	}else{
		$db->query("SELECT product_price FROM Product WHERE product_id = '$pid'");
		$db_rs = $db->fetch_array();
		$cart_index = array_search($pid, $_SESSION['cart_pid']);
		$_SESSION['cart_qty'][$cart_index] = $qty;
		$subtotal = $qty * $db_rs['product_price'];
		echo $subtotal;
	}
?>
