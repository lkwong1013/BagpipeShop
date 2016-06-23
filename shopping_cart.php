<?php include("basic.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Shopping Cart</title>
	<?php heading(); 
    $db = new DB();//Handle Product Information
    $db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
    $db1 = new DB();//Handle User Address
    $db1->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
    $tmp_uid = $_SESSION['userid'];
    $db1->query("SELECT user_address1, user_address2, user_address3, user_lname, user_fname, user_contactno FROM User WHERE user_id = '$tmp_uid'");
    $db1_rs = $db1->fetch_array();
	?>

</head>
<body>
<?php
	top_frame();
	
		/*---Content---*/
?>
	<div id="shopping-cart">
		<label id="title">Shopping Cart Summary</label>
		<table id="cart-table">
			<thead>
				<tr>
					<td id="p-img"></td>
					<td id="p-name">Product Name</td>
					<td id="p-price">Unit Price</td>
					<td id="p-qty">Qty</td>
					<td id="p-subtotal">Subtotal</td>
					<td id="p-action"></td>
				</tr>
			</thead>
			<tbody>
				<?php
				if(count($_SESSION['cart_pid'])>0){
					for($i=0;$i<count($_SESSION['cart_pid']);$i++){
						$tmp_pid = $_SESSION['cart_pid'][$i];
						$db->query("SELECT * FROM Product WHERE product_id = '$tmp_pid'");
						$db_rs = $db->fetch_array();
						extract($db_rs);
						if($product_status == '0'){
							echo "<tr><td><div id=\"cart-image-container\"><img src=\"images/product_images/$product_image\" class=\"cart-image\"/></div></td>";
							echo "<td id=\"p-name\">$product_name</td>";
							if($product_discount > 0){
								$price = $product_price * $product_discount / 10;
								echo "<td style=\"color:red\">$".number_format($price,2)."</td>";;
							}else{
								$price = $product_price;
								echo "<td>$".number_format($product_price,2)."</td>";
							}

							echo "<td><img src=\"images/plus.png\" class=\"small-icon\" id=\"plus\" onClick=\"updateCartQty('".$tmp_pid."','plus')\" /><input type=\"text\" class=\"qty\" id=\"qty-".$tmp_pid."\" value=\"".$_SESSION['cart_qty'][$i]."\" onkeyup=\"updateCartQty('".$tmp_pid."','nth')\"/><img src=\"images/minus.png\" class=\"small-icon\" id=\"minus\" onClick=\"updateCartQty('".$tmp_pid."','minus')\"/></td>";
							$subtotal = $price * $_SESSION['cart_qty'][$i];
							$total += $subtotal;
							$total_qty += $_SESSION['cart_qty'][$i];
							echo "<td><span id=\"subtotal-".$tmp_pid."\">$".number_format($subtotal,2)."</span></td><td><img src=\"images/delete.png\" onClick=\"delFromCart('".$tmp_pid."')\"/></td></tr>";

						}//End IF(if($product_status == '0'))
					}
				}else{
					echo "<tr><td colspan='6'>Nothing here! Let's go shopping!</td></tr>";
				}

				?>
			</tbody>
			<tfoot>
				<tr><td colspan="6"><?php echo $total_qty; ?> item(s) in cart.</td></tr>
			</tfoot>
		</table>
		<form method="post" action="order_confirm.php">
		<div id="order-checkout">
		<!---Delivery Address-->
			<div id="delivery-detail">
			<label id="title">Order Delivery Detail</label>	
			<div id="newaddress">
				
			</div>
			<table>
				<tbody>
                <?php if($db1_rs['user_address1']==""&&$db1_rs['user_address2']==""&&$db1_rs['user_address3']==""){ ?>
                <tr><td></td><td><a href="profile.php"><input type="button" class="basic-btn" style="width:200px;margin-left:60px" value="Add Billing Address" /></a> <span class="warning-msg-red" id="bill-address-warning"></span></td></tr>
                <?php } ?>
               		
					<tr><td>Billing Address</td>
                        <td><span class="user-data"><?php echo $db1_rs['user_address1']; ?></span></td></tr>
                    <tr><td></td><td><span class="user-data"><?php echo $db1_rs['user_address2']; ?></span></td></tr>

                    <!--Hidden Billing Address(For Checking)-->
                    <input type="hidden" id="bill-address1" name="bill-address1" value="<?php echo $db1_rs['user_address1']; ?>" />
                    <input type="hidden" id="bill-address2" name="bill-address2" value="<?php echo $db1_rs['user_address2']; ?>" />
                    <input type="hidden" id="bill-address3" name="bill-address3" value="<?php echo $db1_rs['user_address3']; ?>" />
                    <!--Hidden Billing Address(For Checking)-->
					<tr><td></td><td><span class="user-data"><?php echo $db1_rs['user_address3']; ?></span></td></tr>        
					<tr><td><input type="button" value="Use new address" onclick="clrDeliveryAdd()" class="basic-btn" style="width:200px"/> </td><td></td></tr>         
					<tr><td>Delivery Address</td><td><input type="text" id="address1" name="address1" value="<?php echo $db1_rs['user_address1']; ?>" class="editTextBox"/><span class="warning-msg-red" id="address-warning"></span></td></tr>
					<tr><td></td><td><input type="text" id="address2" name="address2" value="<?php echo $db1_rs['user_address2']; ?>" class="editTextBox"/></td></tr>
					<tr><td></td><td><input type="text" id="address3" name="address3" value="<?php echo $db1_rs['user_address3']; ?>" class="editTextBox"/></td></tr>
					<tr><td>Name</td><td><span class="user-data"><?php echo $db1_rs['user_lname']." ".$db1_rs['user_fname']; ?></span></td></tr>
					<tr><td>Contact No.</td><td><span class="user-data"><?php echo $db1_rs['user_contactno']; ?></span></td></tr>
					<tr><td colspan="2"></td></tr>
				</tbody>
			</table>
			</div>
		<!---Delivery Address-->

		<!--Payment Method-->
			<div id="payment-method-container">
				<label id="title">Payment Method</label>
				<p>Choose your payment method</p>
				<div id="payment-select">
					<div class="payment-method" id="visa" onclick="paymentSelected('visa')">
						<img src="images/visa.png" />
					</div>
					<div class="payment-method" id="ae" onclick="paymentSelected('ae')">
						<img src="images/ae.png" />
					</div>
					<div class="payment-method" id="master" onclick="paymentSelected('master')">
						<img src="images/master-card.png" />
					</div>
					<div class="payment-method" id="discover" onclick="paymentSelected('discover')">
						<img src="images/discover.png" />
					</div>
				<input type="hidden" id="payment" name="payment" value="" />
				</div>
				<span class="warning-msg-red" id="payment-method-warning"></span>
				<table>
					<tbody>
						<tr><td>Card No.</td><td><input type="text" id="cardno" name="cardno" value="" class="editTextBox"/></td></tr>
						<tr><td></td><td><span class="warning-msg-red" id="cardno-warning" style="margin-left:110px"></span></td></tr>
					</tbody>
				</table>
			</div>
		<!--Payment Method-->
		</div>
		<div id="grandtotal">
			<span id="grandtotal-title">Grand Total&nbsp;&nbsp;&nbsp;&nbsp;</span>$<?php echo number_format($total,2); ?>
		</div>
		<?php if(count($_SESSION['cart_pid'])>0){ ?>
		<div id="checkout">
			<input type="button" value="Checkout!" id="checkout-btn" onclick="dspDeliveryAdd()" />
			<input type="button" value="Next!" id="submit-btn" onclick="confirmOrder()" />
		</div>
		<?php } ?>
		</form>
	</div>

<?php	/*---Content---*/
	footer();
?>

</body>
</html>

