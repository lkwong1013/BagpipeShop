<?php
session_start();
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
	
/*---Database---*/
$update_sql = "UPDATE Brand SET 
brand_name = '$brandname',
brand_desc = '$brand_desc'
WHERE brand_id = '$id'";
if(sql_update($update_sql)){
	echo "success";
}else{
	echo "sql-error";
}

?>