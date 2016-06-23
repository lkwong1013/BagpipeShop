<?php 
session_start();
include("basic.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="css/admin_template.css" type="text/css"/> 
	<title>Product Management</title>
	<?php heading(); ?>
<?php
/*---Database---*/
    /*require_once("sql/sqlconnect.php");
    require_once("sql/DB_config.php");
    require_once("sql/sqlconnect.php");
    require_once("sql/sql_function.php");*/
    

/*---Database---*/
?>
<script type="text/javascript">
$(function () {
    $('#category-filter').on('change', function (e) {
		$('#cate-filter').submit();
		
	});
});
	
</script>
</head>
<body>
<?php
	top_frame();

    $db1 = new DB();//Handle Account Information
    $db1->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
    if(!isset($_GET['sorting'])){
	if($_POST['category-filter']=="all"){
		unset($_SESSION['admin-product-filter']);
	}else if($_POST['category-filter']!=""){
		$_SESSION['admin-product-filter'] = $_POST['category-filter'];
	}
		if($_SESSION['admin-product-filter']==""){
			$db1->query("SELECT a.*, b.brand_name FROM Product a, Brand b WHERE a.brand_id = b.brand_id ORDER BY product_id");
		}else{
			$tmp_category = $_SESSION['admin-product-filter'];
			$db1->query("SELECT a.*, b.brand_name FROM Product a, Brand b WHERE a.brand_id = b.brand_id AND a.product_category = '$tmp_category' ORDER BY product_id");
		}
    }else{
        extract($_GET);
        $sql_order = "";
        switch($sorting){
            case "pid_desc": $sql_order = "product_id DESC";
            break;
            case "pname_desc": $sql_order = "product_name DESC";
            break;
            case "pprice_desc": $sql_order = "product_price DESC";
            break;  
            case "pstock_desc": $sql_order = "product_stock DESC";
            break;  
            case "pcategory_desc": $sql_order = "product_category DESC";
            break;
            case "pbrand_desc": $sql_order = "brand_name DESC";
            break;            
            case "pid_asc": $sql_order = "product_id ASC";
            break;
            case "pname_asc": $sql_order = "product_name ASC";
            break;
            case "pprice_asc": $sql_order = "product_price ASC";
            break;  
            case "pstock_asc": $sql_order = "product_stock ASC";
            break;  
            case "pcategory_asc": $sql_order = "product_category ASC";
            break;     
            case "pbrand_asc": $sql_order = "brand_name ASC";
            break;              
        }
		if($_POST['category-filter']=="all"){
			unset($_SESSION['admin-product-filter']);
		}else if($_POST['category-filter']!=""){
			$_SESSION['admin-product-filter'] = $_POST['category-filter'];
		}
		if($_SESSION['admin-product-filter']==""){
			$db1->query("SELECT a.*, b.brand_name FROM Product a, Brand b WHERE a.brand_id = b.brand_id ORDER BY ".$sql_order);
		}else{
			$tmp_category = $_SESSION['admin-product-filter'];
			$db1->query("SELECT a.*, b.brand_name FROM Product a, Brand b WHERE a.brand_id = b.brand_id AND a.product_category = '$tmp_category' ORDER BY ".$sql_order);
		}
    }
	
		/*---Content---*/
?>
	<div id="nav">
		<span class="nav-title">Home</span> > <span class="nav-title">Admin Control</span> > <span class="nav-title">Product Manage</span>
	</div>
    <div class="table-manage" id="product-manage">
        <div id="manage-action">
			<form id="cate-filter" action="product_manage.php" method="POST">
			<a href="new_product.php"><span class="manage-action"><input type="image" src="images/plus.png" class="small-icon" /><label> Add new product</label></span></a>
            <select id="category-filter" name="category-filter">
                <option>Category...</option>
				<option value="all">All</option>
				<option value="bagpipe">Bagpipe</option>
				<option value="reed">Reed</option>
				<option value="pipe bag">Pipe Bag</option>
				<option value="chanter">Chanter</option>
				<option value="accessories">Accessories</option>
            </select>
			</form>
        </div>
        <table>
            <thead>
                <tr><td colspan="6" id="title"><label>Product List</label></td></tr>
                <tr><td>PID<a href="?sorting=pid_desc"><input type="image" src="images/sort_desc_fff.png" class="small-icon" style="float:right"/></a><a href="?sorting=pid_asc"><input type="image" src="images/sort_asc_fff.png" class="small-icon" style="float:right"/></a></td>
                <td>Product Name<a href="?sorting=pname_desc"><input type="image" src="images/sort_desc_fff.png" class="small-icon" style="float:right"/></a><a href="?sorting=pname_asc"><input type="image" src="images/sort_asc_fff.png" class="small-icon" style="float:right"/></a></td>
                <td>Price<a href="?sorting=pprice_desc"><input type="image" src="images/sort_desc_fff.png" class="small-icon" style="float:right"/></a><a href="?sorting=pprice_asc"><input type="image" src="images/sort_asc_fff.png" class="small-icon" style="float:right"/></a></td>
                <!--Stock function disabled <td>Stock<a href="?sorting=pstock_desc"><input type="image" src="images/sort_desc_fff.png" class="small-icon" style="float:right"/></a><a href="?sorting=pstock_asc"><input type="image" src="images/sort_asc_fff.png" class="small-icon" style="float:right"/></a></td> Stock function disabled-->
                <td>Brand<a href="?sorting=pbrand_desc"><input type="image" src="images/sort_desc_fff.png" class="small-icon" style="float:right"/></a><a href="?sorting=pbrand_asc"><input type="image" src="images/sort_asc_fff.png" class="small-icon" style="float:right"/></a></td>
                <td></td></tr>
            </thead>
            <tbody>
                <?php
                    while($db1_rs=$db1->fetch_array()){
                        extract($db1_rs);
                        if($product_status=='0'){
                            echo "<tr><td>$product_id</td><td>$product_name</td><td>$product_price</td><td>$brand_name</td><td><a href=\"product_modify.php?product_id=$product_id\"><input type=\"image\" class=\"small-icon\" src=\"images/edit.png\" value=\"Edit\" /></a> <a href=\"product_delete.php?product_id=$product_id\"><input type=\"image\" class=\"small-icon\" src=\"images/delete.png\" value=\"Edit\" /></a></td></tr>";
                        }
                    }
                ?>
            </tbody>
            <tfoot>
                <tr><td colspan="6"><?php 
                    $db1_cnt=$db1->get_num_rows(); 
                    echo "Showing ".$db1_cnt." records."; ?>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
    
<?php	/*---Content---*/
	footer();
?>

</body>
</html>

