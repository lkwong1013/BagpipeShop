<?php include("basic.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Product Information</title>
	<?php heading();
	extract($_GET);
	$db = new DB();//Handle Product Info
    $db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
	$db1 = new DB();//Handle Brand Info
    $db1->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);


    $db->query("SELECT * FROM Product WHERE product_id = '$pid'");
    $db_rs = $db->fetch_array();
    extract($db_rs);
    $db1->query("SELECT * FROM Brand WHERE brand_id = '$brand_id'");
	$db1_rs = $db1->fetch_array();
	 ?>

</head>
<body>
<?php
	top_frame();
	
		/*---Content---*/
?>
	<div id="nav">
		<span class="nav-title">Home</span> > 
		<span class="nav-title"><a href="product_list.php?category=<?php echo $product_category; ?>"><?php echo $product_category; ?></a></span> > 
		<span class="nav-title"><a href="product_list.php?category=<?php echo $product_category; ?>&brandid=<?php echo $brand_id; ?>"><?php echo $db1_rs['brand_name']; ?></a></span> > 
		<span class="nav-title"><?php echo $product_name; ?></span>
	</div>
	<div id="product-info">
		<div id="product-image">
			<img src="images/product_images/<?php echo $product_image; ?>" />
		</div>
		<div id="product-detail">
			<table>
				<tr><td><span id="product-name"><?php echo $product_name; ?></span></td></tr>
				<tr><td>
				<?php
					if($product_discount > 0){
						echo '<span id="discount-rate">-'.$product_discount.'0%</span> ';
						echo '<label class="price" id="orginal-price">$'.$product_price.'</label>';
						$price = $product_price * $product_discount / 10;
						echo '<label class="price" id="discount-price">$'.$price.'</label> ';
					}else{
						echo '<label class="price">$'.$product_price.'</label>';
					}
				?>
				</td></tr>
				<tr><td><div id="div-qty-text"><span id="qty-title">Qty:</span><input type="text" name="qty" value="1" id="product-qty"/></div>
                    <div id="div-qty-btn"><input type="image" value="Plus" src="images/plus.png" class="qty-btn" onClick="plusQty()"/><input type="image" src="images/minus.png" class="qty-btn" value="Minus" onClick="minusQty()"/></div></td></tr>
				<tr><td><p><?php echo $product_desc; ?></p></td></tr>
			</table>
		<input type="button" name="addtocart" value="Add To Cart" id="addtocart" onClick="addToCart('<?php echo $pid; ?>')"/>	
		</div>
	</div>

<?php	/*---Content---*/
	footer();
?>

</body>
</html>

