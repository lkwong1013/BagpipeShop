<?php include("basic.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="css/admin_template.css" type="text/css"/> 
	<title>Account Info - </title>
	<?php 
	heading(); 

	extract($_GET);
    $db1 = new DB();//Handle Account Information
    $db1->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
    $db1->query("SELECT * FROM User WHERE user_id = '$user_id'");
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
	/*---Login Name---*/
	if($('#loginname').val()==""){
		document.getElementById('loginname-warning').innerHTML = "*Must be filled!";
		$('#loginname').css('border', '2px solid red');
		valid = 0;
	}else if($('#loginname').val().length < 4){
		document.getElementById('loginname-warning').innerHTML = "*Login name must be larger than 4 character";
		$('#loginname').css('border', '2px solid red');
		valid = 0;
	}

	/*---Login Name---*/
	/*---Contact No---*/
	if($('#contactno').val()==""){
		document.getElementById('contactno-warning').innerHTML = "*Must be filled!";
		$('#contactno').css('border', '2px solid red');
		valid = 0;
	}
	/*---Contact No---*/
	/*---Email---*/
	if($('#email').val()==""){
		document.getElementById('email-warning').innerHTML = "*Must be filled!";
		$('#email').css('border', '2px solid red');
		valid = 0;
	}else{
		tmp_valid = chkValid_EmailFormat('email');//If there is an error, will return 0
		if(tmp_valid == 0){ //check if there is something have return or not.
			valid = 0;
		}
	}
	/*---Email---*/
	/*---First Name Last Name---*/
	if($('#lname').val()==""||$('#fname').val()==""){
		document.getElementById('name-warning').innerHTML = "*Must be filled!";
		if($('#lname').val()==""){
			$('#lname').css('border', '2px solid red');
		}
		if($('#fname').val()==""){
			$('#fname').css('border', '2px solid red');
		}
		valid = 0;
	}
	/*---First Name Last Name---*/
	if($('#pwd').val().length < 6 && $('#pwd').val().length > 0){
		document.getElementById('pwd-warning').innerHTML = "*Password length must be larger than 6 character!";
		$('#pwd').css('border', '2px solid red');
		valid = 0;
	}else if($('#pwd').val()!=$('#repwd').val()){
		document.getElementById('pwd-warning').innerHTML = "*Password not match!";
		$('#repwd').css('border', '2px solid red');
		valid = 0;
	}
	if($('#ori-loginname').val()!=$('#loginname').val()){ //Skip Checking the login name if there is no change
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
                     document.getElementById('loginname-warning').innerHTML = "*Login Name have been used!";
                     $('#loginname').css('border', '2px solid red');
                     valid = 0;
                    
                }else{
                    /*---Submit the Register---*/
                    if(valid == 1){
                            $.ajax({
                            type: 'post',
                            url: 'action_update_account.php',
                            data: $('#account-info').serialize(),
                            success: function (msg) {
                            switch(msg){
                                case "success":dspMsg('success','Account Updated!');
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
          xmlhttp.open("GET","chk_username.php?username="+$('#loginname').val(),true);
          xmlhttp.send();
      }else{
                    /*---Submit the Register---*/
                    if(valid == 1){
                            $.ajax({
                            type: 'post',
                            url: 'action_update_account.php',
                            data: $('#account-info').serialize(),
                            success: function (msg) {
                            switch(msg){
                                case "success":dspMsg('success','Account Updated!');
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
	 switch($user_type){
                            case "N":$type = "Normal";
                            break;
                            case "B":$type = "Bronze";
                            break;
                            case "S":$type = "Sliver";
                            break;
                            case "G":$type = "Gold";
                            break;
                            case "A":$type = "Admin";
                            break;                            
                            default:$type = "N/A";
                            break;
     }
?>
	<div id="nav">
		<span class="nav-title">Home</span> > <span class="nav-title">Admin Control</span> > <span class="nav-title"><a href="account_manage.php">Account Manage</a></span> > <span class="nav-title"><?php echo $db1_rs['user_id'] ?></span> 
	</div>
	<div id="account-modify"  class="admin-template">
		<label id="title">Account Info - <?php echo $user_id; ?></label>
		<form id="account-info" onSubmit="return accountUpdate()">
		<table>
			<tbody>
				<tr><td>Login Name</td><td><input type="text" name="loginname" id="loginname" value="<?php echo $user_loginname; ?>" class="editTextBox"/></td><td><span class="warning-msg" id="loginname-warning"></span></td></tr>
				<tr><td>Email</td><td><input type="text" name="email" id="email" value="<?php echo $user_email; ?>" class="editTextBox"/></td><td><span class="warning-msg" id="email-warning"></span></td></tr>
				<tr><td>Contact No</td><td><input type="text" name="contactno" id="contactno" value="<?php echo $user_contactno; ?>" class="editTextBox"/></td><td><span class="warning-msg" id="contactno-warning"></span></td></tr>
				<tr><td>Name</td><td><input type="text" name="fname" id="fname" value="<?php echo $user_fname; ?>" class="editTextBox-s"/><input type="text" name="lname" id="lname" value="<?php echo $user_lname; ?>" class="editTextBox-s"/></td><td><span class="warning-msg" id="name-warning"></span></td></tr>
				<tr>
					<td>Type</td><td><div class="basic-dropdown">
						<span class="current-value" id="current-type"><?php echo $type; ?></span>
						<ul><li id="type_N" onClick="type_select('N')">Normal</li>
						<li id="type_B" onClick="type_select('B')">Bronze</li>
						<li id="type_S" onClick="type_select('S')">Sliver</li>
						<li id="type_G" onClick="type_select('G')">Gold</li>
						<li id="type_A" onClick="type_select('A')">*Admin*</li>
						</ul></div></td></tr><input type="hidden" name="user_type" id="user_type" value="<?php echo $user_type; ?>"/>
				</tr>
				<tr><td>Address</td><td><input type="text" name="address1" id="address1" value="<?php echo $user_address1; ?>" class="editTextBox"/></td></tr>
				<tr><td></td><td><input type="text" name="address2" id="address2" value="<?php echo $user_address2; ?>" class="editTextBox"/></td></tr>
				<tr><td></td><td><input type="text" name="address3" id="address3" value="<?php echo $user_address3; ?>" class="editTextBox"/></td></tr>
				<tr><td>Reset Password</td><td><input type="password" name="pwd" id="pwd" class="editTextBox"/></td><td><span class="warning-msg" id="pwd-warning"></span></td></tr>
				<tr><td>Retype Password</td><td><input type="password" name="repwd" id="repwd" class="editTextBox"/></td></tr>
				<!--Point Function Disabled<tr><td>Point</td><td><input type="text" name="point" id="point" value="<?php echo $user_point; ?>" class="editTextBox"/></td><td><span class="warning-msg" id="point-warning"></span></td></tr>-->
				<tr><td></td><td><input type="submit" value="Update" class="basic-btn" /><a href="account_manage.php"><input type="button" value="Cancel" class="basic-btn"/></a></td></tr>
				<input type="hidden" name="ori-loginname" id="ori-loginname" value="<?php echo $user_loginname; ?>" />
				<input type="hidden" name="id" id="id" value="<?php echo $user_id; ?>" />
			</tbody>
		</table>
		</form>
	</div>
<?php	/*---Content---*/
}else{
    echo "<script>dspMsg('error','Access Denied!');</script>";
    echo "Accesd Denied!";
}
	footer();
?>

</body>
</html>

