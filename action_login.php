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
	
$db = new DB();//Handle Max User Information
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
/*---Database---*/
$db->query("SELECT user_id, user_loginname, user_pwd, user_type, user_lname FROM User WHERE user_loginname = '$username'");
$db_rs = $db->fetch_array();
$pwd = hash('sha256', $pwd);//Encypted password

if($db_rs['user_loginname']!=""){
	if($pwd == $db_rs['user_pwd']){
		$_SESSION['userid'] = $db_rs['user_id'];
		$_SESSION['usertype'] = $db_rs['user_type'];
		$_SESSION['userlname'] = $db_rs['user_lname'];
		echo "success";
	}else{
		echo "pwd-failed";
	}
}else{
	echo "user-failed";
}

?>