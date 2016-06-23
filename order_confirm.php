<?php include("basic.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Order Confirmation</title>
	<?php heading(); 
    $db = new DB();//Handle User Data
    $db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
    $db1 = new DB();//Handle Product Status
    $db1->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
    $tmp_uid = $_SESSION['userid'];
    $db->query("SELECT user_address1, user_address2, user_address3, user_lname, user_fname FROM User WHERE user_id = '$tmp_uid'");
    $db_rs = $db->fetch_array();
    extract($_POST);
	?>

</head>
<body>
<?php
if(count($_SESSION['cart_pid'])>0){
	//If some item in shopping cart
	top_frame();
	
		/*---Content---*/
/*---Check the Product Status---*/
for($i=0;$i<count($_SESSION['cart_pid']);$i++){
	$tmp_pid = $_SESSION['cart_pid'][$i];
	$db1->query("SELECT * FROM Product WHERE product_id = '$tmp_pid'");
	$db1_rs = $db1->fetch_array();
	if($db1_rs['product_status'] == '1'){
		//Product Disabled
		$_SESSION['cart_pid'][$i] = "";
		$_SESSION['cart_qty'][$i] = "";
	}


}
//Cleard all disabled items
		$new_pid = array();
		$new_qty = array();
//Reset Shopping Cart session
		for($i=0;$i<count($_SESSION['cart_qty']);$i++){
			if($_SESSION['cart_pid'][$i] != "" && $_SESSION['cart_qty'][$i] != ""){
			array_push($new_pid, $_SESSION['cart_pid'][$i]);
			array_push($new_qty, $_SESSION['cart_qty'][$i]);
			}
		}

		unset($_SESSION['cart_pid']);
		unset($_SESSION['cart_qty']);
		$_SESSION['cart_pid'] = array();
		$_SESSION['cart_qty'] = array();
		for($i=0;$i<count($new_pid);$i++){
			array_push($_SESSION['cart_pid'], $new_pid[$i]);
			array_push($_SESSION['cart_qty'], $new_qty[$i]);
		}



/*---Check the Product Status---*/
?>

<form id="order">
	<div id="order-confirm">
		<label id="title">Order Confirmation</label>
		<div id="billto">
			<label id="sub-title">Bill to</label></br>
			<label><?php echo $db_rs['user_lname']." ".$db_rs['user_fname']; ?></label></br>
			<label><?php echo $db_rs['user_address1']; ?></label></br>
			<label><?php echo $db_rs['user_address2']; ?></label></br>
			<label><?php echo $db_rs['user_address3']; ?></label></br>
		</div>
		<div id="deliveryto">
			<label id="sub-title">Ship to</label></br>
			<label><?php echo $db_rs['user_lname']." ".$db_rs['user_fname']; ?></label></br>
			<label><?php echo $address1; ?></label></br>
			<label><?php echo $address2; ?></label></br>
			<label><?php echo $address3; ?></label></br>
		</div>
        <input type="hidden" name="address1" value="<?php echo $address1; ?>" />
        <input type="hidden" name="address2" value="<?php echo $address2; ?>" />
        <input type="hidden" name="address3" value="<?php echo $address3; ?>" />

		<div id="cart-table">
			<table id="cart-table">
				<thead>
					<tr>
						<td id="p-img"></td>
						<td id="p-name">Product Name</td>
						<td id="p-price">Unit Price</td>
						<td id="p-qty">Qty</td>
						<td id="p-subtotal">Subtotal</td>
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
							echo "<tr><td><div id=\"cart-image-container\"><img src=\"images/product_images/$product_image\" class=\"cart-image\"/></div></td>";
							echo "<td id=\"p-name\">$product_name</td>";
							if($product_discount > 0){
								$price = $product_price * $product_discount / 10;
								echo "<td style=\"color:red\">$".number_format($price,2)."</td>";;
							}else{
								$price = $product_price;
								echo "<td>$".number_format($product_price,2)."</td>";
							}
							echo "<td>".$_SESSION['cart_qty'][$i]."</td>";
							$subtotal = $price * $_SESSION['cart_qty'][$i];
							$total += $subtotal;
							$total_qty += $_SESSION['cart_qty'][$i];
							echo "<td><span id=\"subtotal-".$tmp_pid."\">$".number_format($subtotal,2)."</span></td></tr>";
						}
					}

					?>
				</tbody>
				<tfoot>
					<tr><td colspan="6"><?php echo $total_qty; ?> item(s) in cart.</td></tr>
				</tfoot>
			</table>
		</div>
		<div id="payment">
			<label id="sub-title">Payment</label></br>
			<?php 
				switch($payment){
					case "visa": echo "<img src=\"images/visa.png\" /></br>";
					break;
					case "ae": echo "<img src=\"images/ae.png\" /></br>";
					break;		
					case "master": echo "<img src=\"images/master-card.png\" /></br>";
					break;
					case "discover": echo "<img src=\"images/discover.png\" /></br>";
					break;
					default: echo "ERROR!";
				}
			?>
			<input type="hidden" name="payment" value="<?php echo $payment; ?>" />
			<label id="cardno">Card No. <?php echo $cardno; ?></label>
            <input type="hidden" name="cardno" value="<?php echo $cardno; ?>" />
		</div>
		<div id="grandtotal">
			<span id="grandtotal-title">Grand Total&nbsp;&nbsp;&nbsp;&nbsp;</span>$<?php echo number_format($total,2); ?>
            <input type="hidden" name="total" value="<?php echo $total; ?>" />
		</div>
		<div id="purchase">
			<input type="button" value="Purchase!" id="purchase-btn" onclick="submitPurchase()" />
		</div>	
	</div>
</form>
<?php
}else{
    echo '<meta http-equiv="refresh" content="0;url=index.php" />';
}
?>
<?php	/*---Content---*/
	footer();
?>

</body>
</html>

