<?php include("basic.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>ISD3 Template</title>
	<?php heading(); ?>

</head>
<body>
<?php
	top_frame();
	
		/*---Content---*/
?>
	<div id="nav">
		<span class="nav-title">Home</span> > <span class="nav-title">Bagpipes</span> > <span class="nav-title">Wallace Bagpipes</span>
	</div>

	<div id="product-list">
		<div class="product-content">
			<div class="product-image">
				<div class="image-content">
					<img src="images/product_images/dummy/apple1.jpg" />
				</div>
				</div>
		<div class="product-desc">
			<span>Wallace Bagpipe Set A</span>
		</div>
		
			<div class="product-price-discount">
				<label class="discount-rate">-50%</label>
				<!---<label class="price" id="original-value">$2000.00</label>-->
				<label class="price" id="discount-value">$10000.00</label>
			</div>
			<div class="product-addcart">
				<span><input type="button" value="Add to Cart" /></span>
			</div>
			<?php if(isset($_GET['admin'])){ ?>
			<div class="product-modify">
				<span><input type="button" value="Edit" onClick="edit_Product('P0001')"/></span>
			</div>	
			<?php } ?>
		
		</div>
		<div class="product-content">
			<div class="product-image">
				<div class="image-content">
					<img src="images/product_images/dummy/mccallum-ab0.jpg" />
				</div>
			</div>
		<div class="product-desc">
			<span>Wallace Bagpipe Set B</span>
		</div>
		
			<div class="product-price-normal">
				<label class="price">$500.00</label>
			</div>
			<div class="product-addcart">
				<span><input type="button" value="Add to Cart" /></span>
			</div>
			<?php if(isset($_GET['admin'])){ ?>
			<div class="product-modify">
				<span><input type="button" value="Edit" onClick="edit_Product('P0001')"/></span>
			</div>	
			<?php } ?>
		
		</div>	
		<div class="product-content">
			<div class="product-image">
				<div class="image-content">
					<img src="images/product_images/dummy/apple1.jpg" />
				</div>
				</div>
		<div class="product-desc">
			<span>Wallace Bagpipe Set A</span>
		</div>
		
			<div class="product-price-discount">
				<label class="discount-rate">-50%</label>
				<!---<label class="price" id="original-value">$2000.00</label>-->
				<label class="price" id="discount-value">$10000.00</label>
			</div>
			<div class="product-addcart">
				<span><input type="button" value="Add to Cart" /></span>
			</div>
			<?php if(isset($_GET['admin'])){ ?>
			<div class="product-modify">
				<span><input type="button" value="Edit" onClick="edit_Product('P0001')"/></span>
			</div>	
			<?php } ?>
		
		</div>
		<div class="product-content">
			<div class="product-image">
				<div class="image-content">
					<img src="images/product_images/dummy/mccallum-ab0.jpg" />
				</div>
			</div>
		<div class="product-desc">
			<span>Wallace Bagpipe Set B</span>
		</div>
		
			<div class="product-price-normal">
				<label class="price">$500.00</label>
			</div>
			<div class="product-addcart">
				<span><input type="button" value="Add to Cart" /></span>
			</div>
			<?php if(isset($_GET['admin'])){ ?>
			<div class="product-modify">
				<span><input type="button" value="Edit" onClick="edit_Product('P0001')"/></span>
			</div>	
			<?php } ?>
		
		</div>
						<div class="product-content">
			<div class="product-image">
				<div class="image-content">
					<img src="images/product_images/dummy/apple1.jpg" />
				</div>
				</div>
		<div class="product-desc">
			<span>Wallace Bagpipe Set A</span>
		</div>
		
			<div class="product-price-discount">
				<label class="discount-rate">-50%</label>
				<!---<label class="price" id="original-value">$2000.00</label>-->
				<label class="price" id="discount-value">$10000.00</label>
			</div>
			<div class="product-addcart">
				<span><input type="button" value="Add to Cart" /></span>
			</div>
			<?php if(isset($_GET['admin'])){ ?>
			<div class="product-modify">
				<span><input type="button" value="Edit" onClick="edit_Product('P0001')"/></span>
			</div>	
			<?php } ?>
		
		</div>
		<div class="product-content">
			<div class="product-image">
				<div class="image-content">
					<img src="images/product_images/dummy/mccallum-ab0.jpg" />
				</div>
			</div>
		<div class="product-desc">
			<span>Wallace Bagpipe Set B</span>
		</div>
		
			<div class="product-price-normal">
				<label class="price">$500.00</label>
			</div>
			<div class="product-addcart">
				<span><input type="button" value="Add to Cart" /></span>
			</div>
			<?php if(isset($_GET['admin'])){ ?>
			<div class="product-modify">
				<span><input type="button" value="Edit" onClick="edit_Product('P0001')"/></span>
			</div>	
			<?php } ?>
		
		</div>
	</div>
		
<?php	/*---Content---*/
	footer();
?>

</body>
</html>

