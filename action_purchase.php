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
	
$db = new DB();//Handle Max Order ID
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
$db1 = new DB();//Handle Max Payment ID
$db1->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
$db2 = new DB();//Handle Product Price
$db2->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
/*---Database---*/

$db->query("SELECT max(order_id) AS max_orderid FROM `Order`");
$db_rs = $db->fetch_array();
$db1->query("SELECT max(payment_id) AS max_paymentid FROM Payment");
$db1_rs = $db1->fetch_array();
/*---FileName Handle---*/

if($db_rs["max_orderid"]!=""){
	$next_orderid = sprintf("R%04d", substr($db_rs["max_orderid"],1)+1);
}else{
	//Empty DB (Initial ID)
	$next_orderid = "R0001";
}
if($db1_rs["max_paymentid"]!=""){
	$next_paymentid = sprintf("Y%04d", substr($db1_rs["max_paymentid"],1)+1);
}else{
	//Empty DB (Initial ID)
	$next_paymentid = "Y0001";
}

/*---New Order---*/
$date = date('Y-m-d');
$time = date('H:i:s');
$tmp_uid = $_SESSION['userid'];
$insert_sql = "INSERT INTO `Order`(`order_id`, `order_date`, `order_time`, `order_address1`, `order_address2`, `order_address3`, `payment_id`, `user_id`) VALUES ('$next_orderid','$date','$time','$address1','$address2','$address3','$next_paymentid','$tmp_uid')";

if(sql_insert($insert_sql)){
    //Add Order line

    for($i=0;$i<count($_SESSION['cart_pid']);$i++){
        $tmp_pid = $_SESSION['cart_pid'][$i];
        $tmp_qty = $_SESSION['cart_qty'][$i];
        $db2->query("SELECT product_price FROM Product WHERE product_id = '$tmp_pid'");
        $db2_rs = $db2->fetch_array();
        $price = $db2_rs['product_price'];
        $insert_sql = "INSERT INTO OrderLine (product_id, order_id, qty, price) VALUES('$tmp_pid','$next_orderid','$tmp_qty','$price')";
        if(!sql_insert($insert_sql)){
            $valid = 1;   
        }
    }
    
    
}else{
    $valid = 1;
    //Failed
}
/*---New Order---*/
/*---New Payment---*/
$insert_sql = "INSERT INTO Payment (payment_id, payment_cardno, payment_type, payment_amount,  payment_status,order_id) VALUES('$next_paymentid','$cardno','$payment','$total','Paid','$next_orderid')";
if(!sql_insert($insert_sql)){
    $valid= 1;
}
/*---New Payment---*/
if($valid ==1){
    //Erroe found!
    echo "sql-error";
}else{
    echo "success";
    $_SESSION['cart_pid'] = array();
    $_SESSION['cart_qty'] = array();
}

?>