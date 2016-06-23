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
		<span class="nav-title">Home</span> > <span class="nav-title">Bagpipes</span> > <span class="nav-title">Wallace Bagpipes</span> > <span class="nav-title">Wallace Bagpipe Set A</span>
	</div>
	<div id="product-info">
		<div id="product-image">
			<img src="images/product_images/dummy/apple1.jpg" />
		</div>
		<div id="product-detail">
			<table>
				<tr><td><span id="product-name">Wallace Bagpipe Set A</span></td></tr>
				<tr><td><span id="discount-rate">-50%</span> <label class="price" id="orginal-price">$16,000.00</label><label class="price" id="discount-price">$8,000.00</label></td></tr>
				<tr><td><span id="qty-title">Qty:</span><input type="text" name="qty" value="1" id="product-qty"/></td></tr>
				<tr><td><p>All McCallum bagpipes listed will be supplied with Balance Tone drone reeds.
					African Blackwood Fully Combed and Beaded
					Wooden button projecting mounts, beaded nickel ferrules, beaded nickel ring caps, wooden bushes, nickel and wooden mouthpiece with McCallum plastic pipe chanter.
					Plain nickel slides come as standard.
					McCallum sound at a budget price.</p></td></tr>
			</table>
		<input type="button" name="addtocart" value="Add To Cart" id="addtocart"/>	
		</div>
	</div>

<?php	/*---Content---*/
	footer();
?>

</body>
</html>

