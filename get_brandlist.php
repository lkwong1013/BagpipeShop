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
$sql = "SELECT * FROM Brand WHERE brand_name LIKE '%$brandname%'";
$db->query("SELECT * FROM Brand WHERE brand_name LIKE '%$brandname%'");
$id = array();
$name = array();
$result = array();
while($db_rs = $db->fetch_array()){
	/*array_push($id,$db_rs['brand_id']);
	array_push($name, $db_rs['brand_name'];);*/
	$tmp_name = $db_rs['brand_name'];
	$result[$tmp_name] = $db_rs['brand_id'];
}
json_encode($result);
echo json_encode($result);
//echo $sql;
?>