<?php 
session_start();
include("basic.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="css/admin_template.css" type="text/css"/> 
	<title>Account Management</title>
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
    $db1 = new DB();//Handle Account Information
    $db1->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
    if(!isset($_GET['sorting'])){
        $db1->query("SELECT * FROM User ORDER BY user_id");
    }else{
        extract($_GET);
        $sql_order = "";
        switch($sorting){
            case "uid_desc": $sql_order = "user_id DESC";
            break;
            case "ulogin_desc": $sql_order = "user_loginname DESC";
            break;
            case "uname_desc": $sql_order = "user_lname DESC";
            break;  
            case "utype_desc": $sql_order = "user_type DESC";
            break;  
            case "uemail_desc": $sql_order = "user_email DESC";
            break;
            case "uid_asc": $sql_order = "user_id ASC";
            break;
            case "ulogin_asc": $sql_order = "user_loginname ASC";
            break;
            case "uname_asc": $sql_order = "user_lname ASC";
            break;  
            case "utype_asc": $sql_order = "user_type ASC";
            break;  
            case "uemail_asc": $sql_order = "user_email ASC";
            break;                     
        }
        $db1->query("SELECT * FROM User ORDER BY ".$sql_order);
    }
	
		/*---Content---*/
?>
	<div id="nav">
		<span class="nav-title">Home</span> > <span class="nav-title">Admin Control</span> > <span class="nav-title">Account Manage</span>
	</div>
    <div class="table-manage" id="account-manage">
        <table>
            <thead>
                <tr><td colspan="6" id="title"><label>Account List</label></td></tr>
                <tr><td>UID<a href="?sorting=uid_desc"><input type="image" src="images/sort_desc_fff.png" class="small-icon" style="float:right"/></a><a href="?sorting=uid_asc"><input type="image" src="images/sort_asc_fff.png" class="small-icon" style="float:right"/></a></td>
                <td>Login Name<a href="?sorting=ulogin_desc"><input type="image" src="images/sort_desc_fff.png" class="small-icon" style="float:right"/></a><a href="?sorting=ulogin_asc"><input type="image" src="images/sort_asc_fff.png" class="small-icon" style="float:right"/></a></td>
                <td>Name<a href="?sorting=uname_desc"><input type="image" src="images/sort_desc_fff.png" class="small-icon" style="float:right"/></a><a href="?sorting=uname_asc"><input type="image" src="images/sort_asc_fff.png" class="small-icon" style="float:right"/></a></td>
                <td>Type<a href="?sorting=utype_desc"><input type="image" src="images/sort_desc_fff.png" class="small-icon" style="float:right"/></a><a href="?sorting=utype_asc"><input type="image" src="images/sort_asc_fff.png" class="small-icon" style="float:right"/></a></td>
                <td>E-mail<a href="?sorting=uemail_desc"><input type="image" src="images/sort_desc_fff.png" class="small-icon" style="float:right"/></a><a href="?sorting=uemail_asc"><input type="image" src="images/sort_asc_fff.png" class="small-icon" style="float:right"/></a></td>
                <td></td></tr>
            </thead>
            <tbody>
                <?php
                    while($db1_rs=$db1->fetch_array()){
                        extract($db1_rs);
                        switch($user_type){
                            case "N":$user_type = "Normal";
                            break;
                            case "B":$user_type = "Bronze";
                            break;
                            case "S":$user_type = "Sliver";
                            break;
                            case "G":$user_type = "Gold";
                            break;
                            case "A":$user_type = "Admin";
                            break;                                
                            default:$user_type = "N/A";
                            break;
                        }
                        echo "<tr><td>$user_id</td><td>$user_loginname</td><td>$user_lname $user_fname</td><td>$user_type</td><td>$user_email</td><td><a href=\"account_modify.php?user_id=$user_id\"><input type=\"image\" class=\"small-icon\" src=\"images/edit.png\" value=\"Edit\" /></a></td></tr>";
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

