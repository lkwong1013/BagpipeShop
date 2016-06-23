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
	
$db = new DB();//Handle Max User ID
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
/*---Database---*/
$db->query("SELECT max(user_id) AS max_userid FROM User");
$db_rs = $db->fetch_array();
if($db_rs["max_userid"]!=""){
	$next_userid = sprintf("U%04d", substr($db_rs["max_userid"],1)+1);
}else{
	//Empty DB (Initial ID)
	$next_userid = "U0001";
}
$pwd = hash('sha256', $pwd);//Encypted password
$insert_sql = "INSERT INTO User (user_id,user_type, user_loginname, user_pwd, user_fname, user_lname, user_email, user_contactno, user_point) VALUES ('$next_userid', 'N', '$loginname','$pwd', '$fname','$lname','$email','$contactno','0')";	
if(!sql_insert($insert_sql)){
	//Failed
	echo "sql-error";
}else{
	echo "success";

}

?>