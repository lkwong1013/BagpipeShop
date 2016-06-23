<?php 
session_start();
include("basic.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="css/admin_template.css" type="text/css"/> 
	<title>Order Management</title>
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

    $db1 = new DB();//Handle Order Information
    $db1->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
    if(!isset($_GET['sorting'])){
    
    if($_SESSION['usertype']=='A'&&$_GET['admin']==1){
	   $db1->query("SELECT a.*, b.user_loginname, c.payment_amount FROM `Order` a, User b, Payment c WHERE a.user_id = b.user_id AND a.payment_id = c.payment_id ORDER BY order_id");
    }else{
        $tmp_uid = $_SESSION['userid'];
        $db1->query("SELECT a.*, b.user_loginname, c.payment_amount FROM `Order` a, User b, Payment c WHERE a.user_id = b.user_id AND a.payment_id = c.payment_id AND a.user_id = '$tmp_uid' ORDER BY order_id");
    }

    }else{
        extract($_GET);
        $sql_order = "";
        switch($sorting){
            case "oid_desc": $sql_order = "order_id DESC";
            break;
            case "odate_desc": $sql_order = "order_date DESC";
            break;
            case "otime_desc": $sql_order = "order_time DESC";
            break;  
            case "ouname_desc": $sql_order = "user_loginname DESC";
            break;  
            case "oamount_desc": $sql_order = "payment_amount DESC";
            break;           
            case "oid_asc": $sql_order = "order_id ASC";
            break;
            case "odate_asc": $sql_order = "order_date ASC";
            break;
            case "otime_asc": $sql_order = "order_time ASC";
            break;  
            case "ouname_asc": $sql_order = "user_loginname ASC";
            break;  
            case "oamount_asc": $sql_order = "payment_amount ASC";
            break;                   
        }

			$db1->query("SELECT a.*, b.user_loginname, c.payment_amount FROM `Order` a, User b, Payment c WHERE a.user_id = b.user_id AND a.payment_id = c.payment_id ORDER BY ".$sql_order);
    }
	
		/*---Content---*/
?>
    <!---Admin Mode-->
    <?php if($_SESSION['user_type']=='A'){ ?>
	<div id="nav">
		<span class="nav-title">Home</span> > <span class="nav-title">Admin Control</span> > <span class="nav-title">Order Manage</span>
	</div>
    <?php } ?>
    <!---Admin Mode-->
    <div class="table-manage" id="order-manage">
        <table>
            <thead>
                <tr><td colspan="6" id="title"><label>Order List</label></td></tr>
                <tr><td>OID<a href="?sorting=oid_desc"><input type="image" src="images/sort_desc_fff.png" class="small-icon" style="float:right"/></a><a href="?sorting=oid_asc"><input type="image" src="images/sort_asc_fff.png" class="small-icon" style="float:right"/></a></td>
                <td>Date<a href="?sorting=odate_desc"><input type="image" src="images/sort_desc_fff.png" class="small-icon" style="float:right"/></a><a href="?sorting=odate_asc"><input type="image" src="images/sort_asc_fff.png" class="small-icon" style="float:right"/></a></td>
                <td>Time<a href="?sorting=otime_desc"><input type="image" src="images/sort_desc_fff.png" class="small-icon" style="float:right"/></a><a href="?sorting=otime_asc"><input type="image" src="images/sort_asc_fff.png" class="small-icon" style="float:right"/></a></td>
                <td>User Name<a href="?sorting=ouname_desc"><input type="image" src="images/sort_desc_fff.png" class="small-icon" style="float:right"/></a><a href="?sorting=ouname_asc"><input type="image" src="images/sort_asc_fff.png" class="small-icon" style="float:right"/></a></td>
                <td>Amount<a href="?sorting=oamount_desc"><input type="image" src="images/sort_desc_fff.png" class="small-icon" style="float:right"/></a><a href="?sorting=oamount_asc"><input type="image" src="images/sort_asc_fff.png" class="small-icon" style="float:right"/></a></td>
                <td></td></tr>
            </thead>
            <tbody>
                <?php
                    while($db1_rs=$db1->fetch_array()){
                        extract($db1_rs);
                        echo "<tr><td>$order_id</td><td>$order_date</td><td>$order_time</td><td>$user_loginname</td><td>$ $payment_amount</td><td><a href=\"order_detail.php?order_id=$order_id\"><input type=\"image\" class=\"small-icon\" src=\"images/edit.png\" value=\"Edit\" /></a></td></tr>";
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

