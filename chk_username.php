<?php
extract($_POST);
extract($_GET);
/*---Database---*/
	include("sql/sqlconnect.php");
   	require_once("sql/DB_config.php");
	require_once("sql/sqlconnect.php");
    require_once("sql/sql_function.php");
	
$db = new DB();//Handle Login Name
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
/*---Database---*/
$db->query("SELECT user_loginname FROM User WHERE user_loginname = '$username'");
$db_rs = $db->fetch_array();

if($db_rs['user_loginname']==""){
	echo "Not-found";
}else{
	echo "found";
}
?>