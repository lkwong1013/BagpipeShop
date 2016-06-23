<?php include("basic.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="css/admin_template.css" type="text/css"/> 
	<title>Brand Info - </title>
	<?php heading(); 
	extract($_GET);
    $db1 = new DB();//Handle Brand Information
    $db1->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
    $db1->query("SELECT * FROM Brand WHERE brand_id = '$brand_id'");
    $db1_rs = $db1->fetch_array();
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
	/*---Brand Name---*/
	if($('#brandname').val()==""){
		document.getElementById('brandname-warning').innerHTML = "*Must be filled!";
		$('#brandname').css('border', '2px solid red');
		valid = 0;
	}

	/*---Brand Name---*/

	if($('#ori-brandname').val()!=$('#brandname').val()){ //Skip Checking the brand name if there is no change
          if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp=new XMLHttpRequest();
          } else { // code for IE6, IE5
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
          }
          xmlhttp.onreadystatechange=function() {
            if (xmlhttp.readyState==4 && xmlhttp.status==200) {
                //alert(xmlhttp.responseText);
                if(xmlhttp.responseText=="found"){
                     document.getElementById('brandname-warning').innerHTML = "*Brand Name have been used!";
                     $('#brandname').css('border', '2px solid red');
                     valid = 0;
                    
                }else{
                    /*---Submit the Register---*/
                    if(valid == 1){
                            $.ajax({
                            type: 'post',
                            url: 'action_update_brand.php',
                            data: $('#brand-info').serialize(),
                            success: function (msg) {
                            switch(msg){
                                case "success":dspMsg('success','Brand Updated!');
                                break;
                                case "sql-error":dspMsg('error','SQL Error!Please contact Administrator');
                                break;
                                //Debug
                                default:dspMsg('attention',msg);
                                break;
                            }
                            },
                          });
                     }
                    /*---Submit the Register---*/
                }
            }
          }
          xmlhttp.open("GET","chk_brandname.php?brandname="+$('#brandname').val(),true);
          xmlhttp.send();
      }else{
                    /*---Submit the Register---*/
                    if(valid == 1){
                            $.ajax({
                            type: 'post',
                            url: 'action_update_brand.php',
                            data: $('#brand-info').serialize(),
                            success: function (msg) {
                            switch(msg){
                                case "success":dspMsg('success','Brand Updated!');
                                break;
                                case "sql-error":dspMsg('error','SQL Error!Please contact Administrator');
                                break;
                                //Debug
                                default:dspMsg('attention',msg);
                                break;
                            }
                            },
                          });
                     }
                    /*---Submit the Register---*/
      }
	/**///End Valid
	
          e.preventDefault();
        });
      });
</script>
</head>
<body>
<?php
	top_frame();
if($_SESSION['usertype']=='A'){  
	extract($db1_rs);
		/*---Content---*/

?>
	<div id="nav">
		<span class="nav-title">Home</span> > <span class="nav-title">Admin Control</span> > <span class="nav-title"><a href="brand_manage.php">Brand Manage</a></span> > <span class="nav-title"><?php echo $db1_rs['brand_id'] ?></span> 
	</div>
	<div id="brand-modify"  class="admin-template">
		<label id="title">Brand Info - <?php echo $brand_id; ?></label>
		<form id="brand-info" onSubmit="return accountUpdate()">
		<table>
			<tbody>
				<tr><td>Brand Name</td><td><input type="text" name="brandname" id="brandname" value="<?php echo $brand_name; ?>" class="editTextBox"/></td><td><span class="warning-msg" id="brandname-warning"></span></td></tr>
				<tr><td>Description</td><td><textarea name="brand_desc" class="editTextArea"><?php echo $brand_desc; ?></textarea></td><td></td></tr>
				<input type="hidden" name="ori-brandname" id="ori-brandname" value="<?php echo $brand_name; ?>" />
				<input type="hidden" name="id" id="id" value="<?php echo $brand_id; ?>" />
				<tr><td></td><td><input type="submit" value="Update" class="basic-btn" /><a href="brand_manage.php"><input type="button" value="Cancel" class="basic-btn"/></a></td></tr>
			</tbody>
		</table>
		</form>
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

