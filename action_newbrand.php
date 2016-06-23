<?php
//**************FIX TIMEZONE
$timezone = "Asia/Hong_Kong";
if(function_exists('date_default_timezone_set')){ date_default_timezone_set($timezone);}
//**************FIX TIMEZONE
extract($_POST);
/*---Database---*/
	include("sql/sqlconnect.php");
   	require_once("sql/DB_config.php");
	require_once("sql/sqlconnect.php");
    require_once("sql/sql_function.php");
	
$db = new DB();//Handle Max Brand ID
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
/*---Database---*/
$db->query("SELECT max(brand_id) AS max_brandid FROM Brand");
$db_rs = $db->fetch_array();
if($db_rs["max_brandid"]!=""){
	$next_brandid = sprintf("B%04d", substr($db_rs["max_brandid"],1)+1);
}else{
	//Empty DB (Initial ID)
	$next_brandid = "B0001";
}
$insert_sql = "INSERT INTO Brand (brand_id, brand_name, brand_desc) VALUES ('$next_brandid', '$brandname', '$description')";	
if(!sql_insert($insert_sql)){
	//Failed
	echo "sql-error";
}else{
	echo "success";

}

?>