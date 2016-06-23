<?php 
session_start();
include("basic.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="css/admin_template.css" type="text/css"/> 
	<title>Brand Management</title>
	<?php heading(); ?>
<?php
/*---Database---*/
    /*require_once("sql/sqlconnect.php");
    require_once("sql/DB_config.php");
    require_once("sql/sqlconnect.php");
    require_once("sql/sql_function.php");*/
    

/*---Database---*/
?>
</head>
<body>
<?php
	top_frame();
if($_SESSION['usertype']=='A'){
    $db1 = new DB();//Handle Brand Information
    $db1->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
    if(!isset($_GET['sorting'])){
        $db1->query("SELECT * FROM Brand ORDER BY brand_id");
    }else{
        extract($_GET);
        $sql_order = "";
        switch($sorting){
            case "bid_desc": $sql_order = "brand_id DESC";
            break;
            case "bname_desc": $sql_order = "brand_name DESC";
            break;
            case "bid_asc": $sql_order = "brand_id ASC";
            break;
            case "bname_asc": $sql_order = "brand_name ASC";
            break;
                   
        }
        $db1->query("SELECT * FROM Brand ORDER BY ".$sql_order);
    }
	
		/*---Content---*/
?>
	<div id="nav">
		<span class="nav-title">Home</span> > <span class="nav-title">Admin Control</span> > <span class="nav-title">Brand Manage</span>
	</div>
    <div class="table-manage" id="brand-manage">
        <table>
            <thead>
                <tr><td colspan="6" id="title"><label>Brand List</label></td></tr>
                <tr><td>BID<a href="?sorting=bid_desc"><input type="image" src="images/sort_desc_fff.png" class="small-icon" style="float:right"/></a><a href="?sorting=bid_asc"><input type="image" src="images/sort_asc_fff.png" class="small-icon" style="float:right"/></a></td>
                <td>Brand Name<a href="?sorting=bname_desc"><input type="image" src="images/sort_desc_fff.png" class="small-icon" style="float:right"/></a><a href="?sorting=bname_asc"><input type="image" src="images/sort_asc_fff.png" class="small-icon" style="float:right"/></a></td>
                <td></td></tr>
            </thead>
            <tbody>
                <?php
                    while($db1_rs=$db1->fetch_array()){
                        extract($db1_rs);
                        echo "<tr><td>$brand_id</td><td>$brand_name</td><td><a href=\"brand_modify.php?brand_id=$brand_id\"><input type=\"image\" class=\"small-icon\" src=\"images/edit.png\" value=\"Edit\" /></a></td></tr>";
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
    
<?php	
}else{
    echo "<script>dspMsg('error','Access Denied!');</script>";
    echo "Accesd Denied!";
}
/*---Content---*/
	footer();
?>

</body>
</html>

