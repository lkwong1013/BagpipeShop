<?php include("basic.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Welcome to Highland Supply Shopping Center</title>
	<?php heading(); 
$db = new DB();//Handle New Product
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
$db->query("SELECT * FROM Product WHERE product_status='0' ORDER BY product_id LIMIT 0,3");
$db1 = new DB();//Handle New Product
$db1->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
$db1->query("SELECT * FROM Product WHERE product_discount > 0  AND product_status='0'  ORDER BY product_id LIMIT 0,3");
?>
</head>
<body>
<?php
	top_frame();
	
		/*---Content---*/
?>
<div id="banner">Welcome to Highland Supply Shopping Center</div>
<span class="index-title">New Product</span>
	<div class="index-product-list" id="product-list">
        	 <?php while($db_rs=$db->fetch_array()){ ?>
		<div class="product-content">

			<a href="product_info.php?pid=<?php echo $db_rs['product_id']; ?>"><div class="product-image">
				<div class="image-content">
					<img src="images/product_images/<?php echo $db_rs['product_image']; ?>" />
				</div>
				</div>
			</a>
		<div class="product-desc">
			<span><?php echo $db_rs['product_name']; ?></span>
		</div>
		<?php if($db_rs['product_discount'] != 0){ ?>
		<!--Discount Model-->
			<div class="product-price-discount">
				<label class="discount-rate"><?php echo $db_rs['product_discount']."0%"; ?></label>
				<label class="price" id="discount-value">
				<?php 
				$price = $db_rs['product_price'] * $db_rs['product_discount'] /10; 
				echo "$".number_format($price,2); 
				?></label>
			</div>
		<!--Discount Model-->
		<?php }else{ ?>
		<!--Normal Model-->
			<div class="product-price-normal">
				<label class="price"><?php echo "$".$db_rs['product_price']; ?></label>
			</div>
		<!--Normal Model-->
		<?php } ?>
			<div class="product-addcart">
				<span><input type="button" value="Add to Cart" onClick="addToCart('<?php echo $db_rs['product_id']; ?>')"/></span>
			</div>
			<?php if($_SESSION['usertype']=="A"){ ?>
			<div class="product-modify">
				<span><input type="button" value="Edit" onClick="edit_Product('<?php echo $db_rs['product_id']; ?>')"/></span>
			</div>	
			<?php } ?>
		
		</div>
	<?php }//End While ?>
    </div>
    <div class="index-product-list" id="product-list">
        <span class="index-title" id="sale">Special offer&nbsp;</span>
			 <?php while($db1_rs=$db1->fetch_array()){ ?>
		<div class="product-content">

			<a href="product_info.php?pid=<?php echo $db1_rs['product_id']; ?>"><div class="product-image">
				<div class="image-content">
					<img src="images/product_images/<?php echo $db1_rs['product_image']; ?>" />
				</div>
				</div>
			</a>
		<div class="product-desc">
			<span><?php echo $db1_rs['product_name']; ?></span>
		</div>
		<?php if($db1_rs['product_discount'] != 0){ ?>
		<!--Discount Model-->
			<div class="product-price-discount">
				<label class="discount-rate"><?php echo $db1_rs['product_discount']."0%"; ?></label>
				<label class="price" id="discount-value">
				<?php 
				$price = $db1_rs['product_price'] * $db1_rs['product_discount'] /10; 
				echo "$".number_format($price,2); 
				?></label>
			</div>
		<!--Discount Model-->
		<?php }else{ ?>
		<!--Normal Model-->
			<div class="product-price-normal">
				<label class="price"><?php echo "$".$db1_rs['product_price']; ?></label>
			</div>
		<!--Normal Model-->
		<?php } ?>
			<div class="product-addcart">
				<span><input type="button" value="Add to Cart" onClick="addToCart('<?php echo $db1_rs['product_id']; ?>')"/></span>
			</div>
			<?php if($_SESSION['usertype']=="A"){ ?>
			<div class="product-modify">
				<span><input type="button" value="Edit" onClick="edit_Product('<?php echo $db1_rs['product_id']; ?>')"/></span>
			</div>	
			<?php } ?>
		
		</div>
	<?php }//End While ?>
	</div>
		
<?php	/*---Content---*/
	footer();
?>

</body>
</html>

