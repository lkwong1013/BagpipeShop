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

$update_sql = "UPDATE Product SET product_status = 1 WHERE product_id = '$pid'" ;	
if(!sql_update($update_sql)){
	//Failed
	echo "sql-error";
}else{
	echo "success";

}

?>