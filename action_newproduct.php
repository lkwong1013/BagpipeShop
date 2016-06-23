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
	
$db = new DB();//Handle Max Product ID
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
$db1 = new DB();//Handle Product FileName
$db1->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
/*---Database---*/
$db->query("SELECT max(product_id) AS max_productid FROM Product");
$db_rs = $db->fetch_array();

/*---FileName Handle---*/
$filename = $_FILES['product_image']["name"];
$extension=end(explode(".", $filename));
$filename= ereg_replace(" ","_",$filename);
if($filename !=""){//file upload and delete
	do{
		$head = rand(0,9999999);
		$newfilename=$head.$filename;
		$db1->query("SELECT product_image FROM Product WHERE product_image = '$newfilename'");
		$db1_rs = $db1->fetch_array();
	}while ($db1_rs['product_image']!="");
}


/*---FileName Handle---*/
if($db_rs["max_productid"]!=""){
	$next_productid = sprintf("P%04d", substr($db_rs["max_productid"],1)+1);
}else{
	//Empty DB (Initial ID)
	$next_productid = "P0001";
}


$insert_sql = "INSERT INTO Product (product_id,product_name, product_price, product_discount, product_stock,product_desc,product_category,brand_id,product_image)
 VALUES ('$next_productid', '$productname', '$price','$product_discount','$stock','$description','$category','$brandid','$newfilename')";	


if(!sql_insert($insert_sql)){
	//Failed
	echo "sql-error";
}else{
	/*---File Upload---*/
	if($filename != ""){
		move_uploaded_file($_FILES['product_image']['tmp_name'], 'images/product_images/'.$newfilename); //Upload File
	}

	/*---File Upload---*/
	echo "success";

}

?>