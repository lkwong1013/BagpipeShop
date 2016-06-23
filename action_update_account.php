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
if($pwd==""){
	$update_sql = "UPDATE User SET 
	user_type = '$user_type',
	user_loginname = '$loginname',
	user_fname = '$fname',
	user_lname = '$lname',
	user_email = '$email',
	user_contactno = '$contactno',
	user_address1 = '$address1',
	user_address2 = '$address2',
	user_address3 = '$address3'
	WHERE user_id = '$id'";
}else{
	$pwd = hash('sha256', $pwd);//Encypted password
	$update_sql = "UPDATE User SET 
	user_type = '$user_type',
	user_loginname = '$loginname',
	user_fname = '$fname',
	user_lname = '$lname',
	user_email = '$email',
	user_contactno = '$contactno',
	user_address1 = '$address1',
	user_address2 = '$address2',
	user_address3 = '$address3',
	user_pwd = '$pwd'
	WHERE user_id = '$id'";
}
if(sql_update($update_sql)){
	echo "success";
}else{
	echo "sql-error";
}

?>