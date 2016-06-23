<?php
//**************FIX TIMEZONE
$timezone = "Asia/Hong_Kong";
if(function_exists('date_default_timezone_set')){ date_default_timezone_set($timezone);}
//**************FIX TIMEZONE
//extract($_POST);
/*---Database---*/
	include("sql/sqlconnect.php");
   	require_once("sql/DB_config.php");
	require_once("sql/sqlconnect.php");
    require_once("sql/sql_function.php");
	
$db = new DB();//Handle Product Image path
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
$db1 = new DB();//Handle Product FileName
$db1->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
/*---Database---*/
$db->query("SELECT product_image FROM Product WHERE product_id = '$pid'");
$db_rs = $db->fetch_array();

/*---FileName Handle---*/
if($_FILES['product_image']["name"]!=""){
    unlink("images/product_images/".$db_rs['product_image']);
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
}else{
    $newfilename = $image;
}

/*---FileName Handle---*/

$update_sql = "UPDATE Product SET
product_name = '$productname',
product_price = '$price',
product_discount = '$product_discount',
product_stock = '$stock',
product_desc = '$description',
product_category = 'category',
brand_id = '$brandid',
product_image = '$newfilename'
WHERE product_id = '$pid'";



if(!sql_update($update_sql)){
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