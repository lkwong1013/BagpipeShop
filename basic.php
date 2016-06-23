<?php session_start(); 
	include("sql/sqlconnect.php");
   	require_once("sql/DB_config.php");
	require_once("sql/sqlconnect.php");
    require_once("sql/sql_function.php");

?>
<?php
function heading(){

	?>

	<link rel="stylesheet" href="css/template.css" type="text/css"/>
	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/template.js"></script>
	<script type="text/javascript" src="js/jquery.dropdownPlain.js"></script>
	<script type="text/javascript">
	/*---Window Resize---*/
	$(window).load(function() {
		var width = $(window).width()*0.8; 
		var height = $(window).height(); 
		var footer_height = $(".footer-container").height(); 
		var content_height = $(".content-container").height(); 
   		if(detectmob()==true){
   	 		$('.wrapper-container').css('min-width', width+'px');
   		}else{
			$(".wrapper-container").width(width);
    	}
   	$('.wrapper-container').css('min-height', height+'px');
   	var tmp_height = height-footer_height;
   //	alert(tmp_height);

   	$('.content-container').css('min-height', tmp_height+'px');

 	});

	$(window).resize(function() {
		var width = $(window).width()*0.8; 
		var height = $(window).height(); 
		var header_height = $("header").height(); 
		$('.wrapper-container').css('min-height', height+'px');
 	});
 	/*---Window Resize---*/
 	$(window).click( function(event){
  	 var clicked = $(this.value); // jQuery wrapper for clicked element
  	 //console.log(clicked);
  	// alert(clicked);
	});

	</script>

<?php }
function top_frame(){ 
Global $_DB;
/*---Bagpipe Brand---*/
	$db = new DB();
	$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
	$db->query("SELECT DISTINCT(a.brand_id),b.brand_name FROM Product a, Brand b WHERE a.brand_id = b.brand_id AND a.product_category = 'Bagpipe' AND a.product_status = '0'");
/*---Bagpipe Brand---*/
/*---Reeds Brand---*/
	$db1 = new DB();
	$db1->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
	$db1->query("SELECT DISTINCT(a.brand_id),b.brand_name FROM Product a, Brand b WHERE a.brand_id = b.brand_id AND a.product_category = 'Reed' AND a.product_status = '0'");
/*---Reeds Brand---*/
/*---Pipe Bags Brand---*/
	$db2 = new DB();
	$db2->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
	$db2->query("SELECT DISTINCT(a.brand_id),b.brand_name FROM Product a, Brand b WHERE a.brand_id = b.brand_id AND a.product_category = 'Pipe Bag' AND a.product_status = '0'");
/*---Pipe Bags  Brand---*/
/*---Chanter Brand---*/
	$db3 = new DB();
	$db3->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
	$db3->query("SELECT DISTINCT(a.brand_id),b.brand_name FROM Product a, Brand b WHERE a.brand_id = b.brand_id AND a.product_category = 'Chanter' AND a.product_status = '0'");
/*---Chanter Brand---*/
/*---Accessories sBrand---*/
	$db4 = new DB();
	$db4->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
	$db4->query("SELECT DISTINCT(a.brand_id),b.brand_name FROM Product a, Brand b WHERE a.brand_id = b.brand_id AND a.product_category = 'Accessories' AND a.product_status = '0'");
/*---Accessories Brand---*/
/*---Product Info---*/
	$db5 = new DB();
	$db5->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);

	/*---Calculate total amount---*/
		for($i=0;$i<count($_SESSION['cart_pid']);$i++){
			$tmp_pid = $_SESSION['cart_pid'][$i];
			$db5->query("SELECT * FROM Product WHERE product_id = '$tmp_pid' AND product_status='0'");
			$db5_rs = $db5->fetch_array();
			if($db5_rs['product_discount']>0){
				$tmp_price = $db5_rs['product_price'] * $db5_rs['product_discount'] /10;
				$tmp_price *= $_SESSION['cart_qty'][$i];
				$discount = 1;
			}else{
				$tmp_price = $db5_rs['product_price'];	
				$tmp_price *= $_SESSION['cart_qty'][$i];	
			}
			$total_amount += $tmp_price;
	}
	/*---Calculate total amount---*/
/*---Product Info---*/
	?>
<div class="overlay" onClick="hideOverlay()">
</div>
<div class="nonclick-overlay">
</div>
<div id="overlay-container" class="overlay-container">

</div>
<div class="wrapper">
	<div class="wrapper-container">
	<input type="hidden" id="auth" value="<?php echo $_SESSION['usertype'] ?>" /><!--Authorize Check for JS using user type-->
		<header>
			<div class="logo">
				<img src="images/logo.jpg" id="logo"/>
			</div>
			<div id="login">
				<?php if(!isset($_SESSION['userid'])){?>
					<input type="button" id="content" value="Login" onClick="dspLogin()"/></br>
					<span id="register" onClick="dspRegister()">Register Now!</span>
				<?php }else{?>
						<span id="user-info">Hello! <?php echo $_SESSION['userlname']; ?> <a href="profile.php"><input type="image" class="small-icon" src="images/user.png" value="Edit" /></a> <a href="order_manage.php"><input type="image" class="small-icon" src="images/order.png" value="View Order" /></a></span> <a href="action_logout.php"><input type="button" id="content" value="Logout" /></a>
				<?php }	?>
			</div>

			<div id="item-search">
				<span id="content"><input type="text" id="search-textbox" name="search" placeholder="Search Product..."/> <input type="image" src="images/search.png" class="small-icon" value="Search" onClick="searchProduct()"/></span>
			</div>
			<div id="shopping-cart" onClick="dspCart()">
				<a href="shopping_cart.php"><span id="content">Shopping cart: Cart Total: <label class="amount">$<?php echo number_format($total_amount); ?></lable></span></a>
				<div id="shopping-cart-info">
					
					<table id="cart-list">
					<thead>
					<tr><td colspan="4" id="title"><span>RECENTLY ADDED ITEMS</span></td></tr>
					<tr><td>#</td><td>Description</td><td>QTY.</td><td id="amount">Amount</td></tr></thead>
					<tbody>
					<?php
						$total_amount = 0;
						for($i=0;$i<count($_SESSION['cart_pid']);$i++){
							$discount = 0;
							$tmp_pid = $_SESSION['cart_pid'][$i];
							$db5->query("SELECT * FROM Product WHERE product_id = '$tmp_pid'");
							$db5_rs = $db5->fetch_array();
							if($db5_rs['product_status']=='0'){
								$tmp_name = $db5_rs['product_name'];
								if($db5_rs['product_discount']>0){
									$tmp_price = $db5_rs['product_price'] * $db5_rs['product_discount'] /10;
									$tmp_price *= $_SESSION['cart_qty'][$i];
									$discount = 1;
								}else{
									$tmp_price = $db5_rs['product_price'];
									$tmp_price *= $_SESSION['cart_qty'][$i];		
								}
								$total_amount += $tmp_price;
								$count = $i+1;
								echo "<tr><td>".$count."</td><td>".$tmp_name."</td>";
								echo "<td>".$_SESSION['cart_qty'][$i]."</td>";
								if($discount==1){
									echo "<td id=\"amount\" style=\"color:red\">$".number_format($tmp_price,2)."</td></tr>";
								}else{
									echo "<td id=\"amount\">$".number_format($tmp_price,2)."</td></tr>";
								}
							}//END IF($db5_rs['product_status']=='0')
							
						}
					?>
					</tbody>
					<tfoot>
					<tr><td colspan="4">Total: $<?php echo number_format($total_amount,2); ?></td></tr>
					<tr><td colspan="2"></td><td colspan="2"><a href="shopping_cart.php"><input type="button" value="Checkout" id="checkout" /></a></td></tr>
					</tfoot>
					</table>
				</div><!---shopping-cart-info-->
			</div><!---shopping-cart-->

			<div id="menu">
				<ul class="dropdown">
					<li><a href="index.php">Home</a></li>
					<li><a href="product_list.php?category=bagpipe">Bagpipes</a>
						<ul>
						<?php while($db_rs = $db->fetch_array()){
							$tmp_id = $db_rs['brand_id'];
							$tmp_name = $db_rs['brand_name'];							
							echo "<li><a href=\"product_list.php?brandid=$tmp_id&category=bagpipe\">$tmp_name</a></li>";		
								}						
						?>
						</ul>
					</li>
					<li><a href="product_list.php?category=reed">Reeds</a>
						<ul>
						<?php while($db1_rs = $db1->fetch_array()){
							$tmp_id = $db1_rs['brand_id'];
							$tmp_name = $db1_rs['brand_name'];							
							echo "<li><a href=\"product_list.php?brandid=$tmp_id&category=reed\">$tmp_name</a></li>";		
								}						
						?>
						</ul>
					</li>
					<li><a href="product_list.php?category=pipe%20bag">Pipe Bags</a>
						<ul>
						<?php while($db2_rs = $db2->fetch_array()){
							$tmp_id = $db2_rs['brand_id'];
							$tmp_name = $db2_rs['brand_name'];							
							echo "<li><a href=\"product_list.php?brandid=$tmp_id&category=pipe%20bag\">$tmp_name</a></li>";		
								}						
						?>
						</ul>
					</li>
					<li><a href="product_list.php?category=chanter">Chanter</a>
						<ul>
						<?php while($db3_rs = $db3->fetch_array()){
							$tmp_id = $db3_rs['brand_id'];
							$tmp_name = $db3_rs['brand_name'];							
							echo "<li><a href=\"product_list.php?brandid=$tmp_id&category=chanter\">$tmp_name</a></li>";		
								}						
						?>
						</ul>
					</li>		
					<li><a href="product_list.php?category=accessories">Accessories</a>
						<ul>
						<?php while($db4_rs = $db4->fetch_array()){
							$tmp_id = $db4_rs['brand_id'];
							$tmp_name = $db4_rs['brand_name'];							
							echo "<li><a href=\"product_list.php?brandid=$tmp_id&category=accessories\">$tmp_name</a></li>";		
								}						
						?>
						</ul>
					</li>
					<!--<li><a href="#?admin=1">*Admin Mode*</a></li>-->
					<?php if($_SESSION['usertype']=="A"){ ?>
					<li><a href="">*Admin Control*</a>
						<ul>
							<li><a href="account_manage.php">Account Manage</a></li>
							<li><a href="product_manage.php">Product Manage</a></li>
							<li><a href="order_manage.php?admin=1">Order Manage</a></li>
							<li><a href="brand_manage.php">Brand Manage</a></li>
						</ul>
					</li>
					<?php } ?>
				</ul>
			</div><!---menu-->
		</header>
		<content>
			<div class="content-container">
	<?php
}
function footer(){
	?>
			</div>
	</content>
	<footer>
			<div class="footer-container">
				<div id="payment">
					<span id="content">Payment Option</br></br><img src="images/visa.png" class="footer-icon"/> <img src="images/ae.png" class="footer-icon"/> <img src="images/master-card.png" class="footer-icon"/> <img src="images/discover.png" class="footer-icon"/></span>
				</div>
				<div id="contact">
					<span id="content">Contact Us</br><ul><li>E-Mail: <a>a1234@gmail.com</a></li><li>Tel: 2555 4568</li><li>Fax: 2566 6467</li></ul></span>
				</div>
				<div id="author">
					<span id="content">Powered by SAMAXXW</span>
				</div>
			</div>
		</footer>
	</div>

</div>
<?php
}


?>
