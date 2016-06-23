<?php
	session_start();
	extract($_POST);
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
?>