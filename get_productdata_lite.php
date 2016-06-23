<?php
    session_start();
    extract($_POST);
    /*---DB---*/
    include("sql/sqlconnect.php");
   	require_once("sql/DB_config.php");
	require_once("sql/sqlconnect.php");
    require_once("sql/sql_function.php");

	$db = new DB();//Handle Product Data
	$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
    $db->query("SELECT * FROM Product WHERE product_id = '$pid'");
    /*---DB---*/
    
    $db_rs = $db->fetch_array();
    $data = array();
    array_push($data,$db_rs['product_name']);
    array_push($data,$db_rs['product_price']);
    array_push($data,$db_rs['product_discount']);
    
    echo json_encode($data);
    
    
    
?>