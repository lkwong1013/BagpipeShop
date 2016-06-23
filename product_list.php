<?php 
session_start();
include("basic.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>ISD3 Template</title>
	<?php heading();
	extract($_GET);
	$db = new DB();//Handle Product Info
    $db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
    $db1 = new DB();//Handle Brand Name
    $db1->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
    if(!isset($search)){
	    if(isset($brandid)){
	    	//Selected Brand
	    	$db->query("SELECT * FROM Product WHERE brand_id = '$brandid' AND product_category = '$category' AND product_status='0'");
	    	$db1->query("SELECT * FROM Brand WHERE brand_id = '$brandid'");
	    	$db1_rs = $db1->fetch_array();
	    	$brand_name = $db1_rs['brand_name'];
	    }else{
	    	$db->query("SELECT * FROM Product WHERE product_category = '$category' AND product_status='0'");
	    }
	}else{
		$db->query("SELECT * FROM Product WHERE product_status='0' AND product_name LIKE '%$search%'");
	
	}
 ?>
</head>
<body>
<?php
	top_frame();
	
		/*---Content---*/
?>
	<div id="nav">
		<span class="nav-title">Home</span>
		<?php if(isset($category)){ ?>
		 > <span class="nav-title"><?php echo ucfirst($category); ?></span>
		<?php } ?>

		<?php if(isset($brandid)){ echo " > <span class=\"nav-title\">$brand_name</span>"; }
			  if(isset($search)){ echo " > <span class=\"nav-title\">Search: \"$search\"</span>"; }
		 ?>
	</div>

	<div id="product-list">
	<!---Product 1 -->
		<?php if($brand_name!=""){ ?>
		<div id="brand-info">
			<span id="brand-name"><?php echo $brand_name; ?></span>
			<p><?php  echo $db1_rs['brand_desc']; ?></p>
		</div>
		<?php } ?>
	<?php
	$db_cnt = $db->get_num_rows();
	if($db_cnt>0){
	 while($db_rs=$db->fetch_array()){
	 	if($db_rs['product_status']=='0'){
	  ?>
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
	<?php 
		}//End if($db_rs['product_status']=='0')
	}//End While
		}else{
			?><div id="no-result">Sorry, we couldn't find any results based on your search query.</div><?php
		}

	 ?>
	<!---Product 1 -->	
	
	</div>
		
<?php	/*---Content---*/
	footer();
?>

</body>
</html>

