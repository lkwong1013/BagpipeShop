<?php include("basic.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Product Delete</title>
	<?php heading(); ?>

</head>
<body>
<?php
	top_frame();
	extract($_GET);

	$db = new DB();//Handle Product Detail
    $db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
    $db->query("SELECT * FROM Product WHERE product_id = '$product_id'");
    $db_rs = $db->fetch_Array();
    if($db_rs['product_status']=="0"){
		/*---Content---*/
    
?>
	<div id="product-delete">

		<div id="title"><?php echo $product_id; ?> Product Delete?</div>
		<div id="product-info">
			<table>
			<tr><td><img src="images/product_images/<?php echo $db_rs['product_image']; ?>" /></td><td><?php echo $db_rs['product_name']; ?></td></tr>
			<tr><td colspan="2"><label id="msg">WARNING! Are you sure you want to delete this product?</label></td></tr>
			<tr><td><input type="button" value="Yes! Do it!" class="basic-btn" onClick="delProduct('<?php echo $product_id; ?>')"/></td><td><a href="product_manage.php"><input type="button" value="No Thanks!" class="basic-btn"/></a></td></tr>
			</table>
		</div>
	</div>
<?php	
	}else{
		?><meta http-equiv="refresh" content="0;url=product_manage.php" /><?php 
	}

/*---Content---*/
	footer();
?>

</body>
</html>

