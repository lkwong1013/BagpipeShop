<?php include("basic.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="css/admin_template.css" type="text/css"/> 
	<title>Order Detail</title>
	<?php heading(); 
	extract($_GET);
    $db = new DB();//Handle Order Data
    $db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
    $db1 = new DB();//Handle Payment Data
    $db1->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
    $db2 = new DB();//Handle User Data
    $db2->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']); 
    $db3 = new DB();//Handle OrderLine Data
    $db3->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
    $db4 = new DB();//Handle Product Data
    $db4->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);   
    $db->query("SELECT *  FROM `Order` WHERE order_id = '$order_id'");
    $db_rs = $db->fetch_array();
    $tmp_paymentid = $db_rs['payment_id'];
    $db1->query("SELECT * FROM Payment WHERE payment_id = '$tmp_paymentid'");
    $db1_rs = $db1->fetch_array();
    $tmp_userid = $db_rs['user_id'];
    $db2->query("SELECT * FROM User WHERE user_id = '$tmp_userid'");
    $db2_rs = $db2->fetch_array();    

    /*---Check User---*/
    if($_SESSION['usertype']!='A'){
    	//If not admin check if it is the order owner
    	if($db_rs['user_id']!=$_SESSION['userid']){
    		$owner = 0;
    	}

    }
	?>

</head>
<body>
<?php
	top_frame();
	if(!isset($owner)){
		/*---Content---*/
	 if($_SESSION['usertype']!='A'){ ?>
	<div id="nav">
		<span class="nav-title">Home</span> > <span class="nav-title"><a href="order_manage.php">Order Manage</a></span> > <span class="nav-title"><?php echo $order_id; ?></span>
	</div>
	 <?php }else{ ?>

	<div id="nav">
		<span class="nav-title">Home</span> > <span class="nav-title">Admin Control</span> > <span class="nav-title"><a href="order_manage.php">Order Manage</a></span> > <span class="nav-title"><?php echo $order_id; ?></span>
	</div>

	<?php 	} ?>



	<div id="order-detail">
		<label id="title">Order Information - <?php echo $order_id; ?></label>
		<div id="deliveryto">
			<label id="sub-title">Ship to</label></br>
			<label><?php echo $db2_rs['user_lname']." ".$db2_rs['user_fname']; ?></label></br>
			<label><?php echo $db_rs['order_address1']; ?></label></br>
			<label><?php echo $db_rs['order_address2']; ?></label></br>
			<label><?php echo $db_rs['order_address3']; ?></label></br>
		</div>

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
					
						$db3->query("SELECT * FROM OrderLine WHERE order_id = '$order_id'");
						
							while($db3_rs = $db3->fetch_array()){
								$tmp_pid = $db3_rs['product_id'];
								$db4->query("SELECT * FROM Product WHERE product_id = '$tmp_pid'");
								$db4_rs = $db4->fetch_array();
								echo "<tr><td><div id=\"cart-image-container\"><img src=\"images/product_images/".$db4_rs['product_image']."\" class=\"cart-image\"/></div></td>";
								echo "<td id=\"p-name\">".$db4_rs['product_name']."</td>";
								echo "<td>$".number_format($db3_rs['price'],2)."</td>";
								echo "<td>".$db3_rs['qty']."</td>";
								$subtotal = $db3_rs['price'] * $db3_rs['qty'];
								echo "<td><span>$".number_format($subtotal,2)."</span></td></tr>";
								$total_qty += $db3_rs['qty'];
							}

					

					?>
				</tbody>
				<tfoot>
					<tr><td colspan="6"><?php echo $total_qty; ?> item(s) in this order.</td></tr>
				</tfoot>
			</table>
		</div>
		<div id="payment">
			<label id="sub-title">Payment</label></br>
			<?php 
				switch($db1_rs['payment_type']){
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
			<label id="cardno">Card No. <?php echo $db1_rs['payment_cardno']; ?></label>
		</div>
		<div id="grandtotal">
			<span id="grandtotal-title">Grand Total&nbsp;&nbsp;&nbsp;&nbsp;</span>$<?php echo number_format($db1_rs['payment_amount'],2); ?>
		</div>
	</div>


<?php	

	}else{
		echo "Access Denied! You are not the owner of the order.";
	}
/*---Content---*/
	footer();
?>

</body>
</html>

