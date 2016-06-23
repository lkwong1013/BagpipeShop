<?php include("basic.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="css/admin_template.css" type="text/css"/> 
	<title>Product Modify</title>
	<?php heading(); 
	extract($_GET);
	/*---Database---*/
	include("sql/sqlconnect.php");
   	require_once("sql/DB_config.php");
	require_once("sql/sqlconnect.php");
    require_once("sql/sql_function.php");
	
	$db = new DB();//Handle Brand List
	$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
	$db->query("SELECT * FROM Brand ORDER BY brand_name");
	$db1 = new DB();//Handle Product Info
	$db1->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
	$db1->query("SELECT a.*, b.brand_name FROM Product a,Brand b WHERE product_id = '$product_id' AND a.brand_id = b.brand_id");
	/*---Database---*/
	?>
<script type="text/javascript">
$(function () {
    $('form').on('submit', function (e) {
	/*---Reset warning Message---*/
	var s = document.getElementsByClassName('warning-msg');
	for(var i=0; i < s.length;i++){
		s[i].innerHTML = "";
	}
	$('input[type="text"]').css('border', '2px solid #000');
	/*---Reset warning Message---*/
	var valid = 1;
	/*---Product Name---*/
	if($('#productname').val()==""){
		document.getElementById('productname-warning').innerHTML = "*Must be filled!";
		$('#productname').css('border', '2px solid red');
		valid = 0;
    }

	/*---Product Name---*/
	/*---Price---*/
	if($('#price').val()==""){
		document.getElementById('price-warning').innerHTML = "*Must be filled!";
		$('#price').css('border', '2px solid red');
		valid = 0;
	}else{
		tmp_valid = chkValid_DollarFormat('price');//If there is an error, will return 0
		if(tmp_valid == 0){ //check if there is something have return or not.
			valid = 0;
        }
    }
	/*---Price---*/
  	/*---Stock---*/

		tmp_valid = chkValid_NumberOnly('stock');//If there is an error, will return 0
		if(tmp_valid == 0){ //check if there is something have return or not.
			valid = 0;
        }
  
	/*---Stock---*/  
					var formData = new FormData($(this)[0]);
                    /*---Submit the Register---*/
                    if(valid == 1){

						var formObj = $(this);
					    var formURL = formObj.attr("action");
					    var formData = new FormData(this);
					    $.ajax({
					        url: "action_update_product.php",
					  		type: 'POST',
					        data:  formData,
						    mimeType:"multipart/form-data",
						    contentType: false,
					        cache: false,
					        processData:false,
					    success: function(data, textStatus, jqXHR){
					 		switch(data){
					 			case "success":dspMsg('success','Product Updated!');
					 			break;
					 			case "sql-error":dspMsg('error','SQL Error!Please contact Administrator');
					 			break;
					 			default:dspMsg('attention',data);
					 			break;

					 		}
					    },
					     error: function(jqXHR, textStatus, errorThrown) 
					     {
							alert(textStatus);	
					     }          
					    });
                     }
                    /*---Submit the Register---*/
    
	
          e.preventDefault();
        });
      });
</script>
</head>
<body>
<?php
	top_frame();
	$db1_rs = $db1->fetch_array();
	extract($db1_rs);
?>
	<div id="nav">
		<span class="nav-title">Home</span> > <span class="nav-title">Admin Control</span> > <span class="nav-title"><a href="product_manage.php">Product Manage</a></span> > <span class="nav-title"><?php echo $product_id; ?></span> 
	</div>
	<div id="product-modify" class="admin-template">
		<label id="title">Product Modify - <?php echo $product_id; ?></label>
		<form id="product-info" enctype="multipart/form-data" method="post">
		<table>
			<tbody>
				<tr><td>Product Name</td><td><input type="text" name="productname" id="productname" class="editTextBox" value="<?php echo $product_name; ?>"/></td>
                    <td><span class="warning-msg" id="productname-warning"></span></td></tr>
				<tr><td>Brand</td>
					<td>
						<div class="basic-dropdown" id="text-style">
							
							<input type="text" name="brand" id="brand" class="editTextBox" onkeyup="getBrandList()" value="<?php echo $brand_name; ?>"/>
		                       <ul id="brand-list">
		                       	<?php
		                       		while($db_rs=$db->fetch_array()){
		                       			//extract($db_rs);
		                       			$tmp_brandid = $db_rs['brand_id'];
		                       			$tmp_brandname = $db_rs['brand_name'];
		                       			echo "<li onClick=\"brandSelect('".$tmp_brandid."')\" id=\"$tmp_brandid\">$tmp_brandname</li>";
		                       		}
		                       	?>
		                       </ul>
						</div>
					</td><input type="hidden" name="brandid" id="brandid" value="<?php echo $brand_id; ?>"/>
                    <td><span class="manage-action" onClick="dspNewBrand()"><img src="images/plus.png" class="small-icon" /><label> New Brand</label></span><span class="warning-msg" id="brand-warning"></span></td></tr>
				<tr><td>Price</td><td><input type="text" name="price" id="price" class="editTextBox" value="<?php echo $product_price; ?>"/></td>
                    <td><span class="warning-msg" id="price-warning"></span></td></tr>
				<tr>
					<td>Discount</td>
                    <td>
                        <div class="basic-dropdown">
                        <?php
                        if($product_discount>0){
                        	$dsp_discountrate = $product_discount."0%";
                        }else{
                        	$dsp_discountrate = "0%";
                        }
                        ?>
	                       <span class="current-value" id="current-discount"><?php echo $dsp_discountrate; ?></span>
	                       <ul>
								<li id="discount0" onClick="discount_select(0)">0%</li>
                               <li id="discount9" onClick="discount_select(9)">90%</li>
	                           <li id="discount8" onClick="discount_select(8)">80%</li>
	                           <li id="discount7" onClick="discount_select(7)">70%</li>
	                           <li id="discount6" onClick="discount_select(6)">60%</li>
	                           <li id="discount5" onClick="discount_select(5)">50%</li>
	                       </ul>
                        </div>
                    </td></tr><input type="hidden" name="product_discount" id="product_discount" value="<?php echo $product_discount; ?>"/>
				</tr>
				<!--Stock Function Disabled--><input type="hidden" name="stock" id="stock" value="<?php echo $product_stock; ?>"/><!--Stock Function Disabled-->
				<tr><td>Description</td><td><textarea name="description" id="description" class="editTextArea"><?php echo $product_desc; ?></textarea></td></tr>
				<tr><td>Category</td><td>
						<div class="basic-dropdown">
	                       <span class="current-category" id="current-category">
								<?php if($product_category!=""){
											echo $product_category;
										}else{ 
											echo "Select category...";
										} ?>
						   </span>
	                       <ul>
								<li id="cate_bagpipe" onClick="category_select('bagpipe')">Bagpipe</li>
                               <li id="cate_reed" onClick="category_select('reed')">Reed</li>
	                           <li id="cate_pipebag" onClick="category_select('pipebag')">Pipe Bag</li>
	                           <li id="cate_chanter" onClick="category_select('chanter')">Chanter</li>
	                           <li id="cate_accessories" onClick="category_select('accessories')">Accessories</li>
	                       </ul>
                        </div>
				<input type="hidden" name="category" id="category" class="editTextBox" value="<?php echo $product_category; ?>"/>
				</td>
                    <td><span class="warning-msg" id="point-warning"></span></td></tr>
                <tr><td>Image</td>
                <td>
                	<div class="product-image">
						<div class="image-content">
							<img src="images/product_images/<?php echo $product_image; ?>" />
						</div>
					</div>
                	<input type="file" name="product_image" class="fileUploadBox" id="product-modify-image"/>
                </td></tr>
                <input type="hidden" name="pid" value="<?php echo $product_id; ?>" />
                <input type="hidden" name="image" value="<?php echo $product_image; ?>" />
				<tr><td></td><td><input type="submit" value="Update" class="basic-btn" onclick="" /><a href="product_manage.php"><input type="button" value="Cancel" class="basic-btn"/></a></td></tr>
			</tbody>
		</table>

		</form>
	</div>
<?php	/*---Content---*/
	footer();
?>

</body>
</html>

