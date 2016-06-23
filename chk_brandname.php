<?php
extract($_POST);
extract($_GET);
/*---Database---*/
	include("sql/sqlconnect.php");
   	require_once("sql/DB_config.php");
	require_once("sql/sqlconnect.php");
    require_once("sql/sql_function.php");
	
$db = new DB();//Handle Brand Name
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
/*---Database---*/
$db->query("SELECT brand_name FROM Brand WHERE brand_name = '$brandname'");
$db_rs = $db->fetch_array();

if($db_rs['brand_name']==""){
	echo "Not-found";
}else{
	echo "found";
}
?>