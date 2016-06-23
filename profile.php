<?php 
session_start();
include("basic.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="css/admin_template.css" type="text/css"/> 
	<title>My Profile</title>
	<?php heading(); 
	extract($_GET);
    $db1 = new DB();//Handle Account Information
    $db1->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
    $tmp_uid = $_SESSION['userid'];
    $db1->query("SELECT * FROM User WHERE user_id = '$tmp_uid'");
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

                    /*---Submit the Register---*/
                    if(valid == 1){
                            $.ajax({
                            type: 'post',
                            url: 'action_update_profile.php',
                            data: $('#account-info').serialize(),
                            success: function (msg) {
                            switch(msg){
                                case "success":dspMsg('success','Profile Updated!');
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
      
          e.preventDefault();
        });
      });
</script>
</head>
<body>
<?php
	top_frame();
	extract($db1_rs);
		/*---Content---*/
?>
	<div id="nav">
		<span class="nav-title">Home</span> > <span class="nav-title">My Profile</span>
	</div>
	<div id="account-modify"  class="admin-template">
		<label id="title">My Profile</label>
		<form id="account-info" onSubmit="return accountUpdate()">
		<table>
			<tbody>
				<tr><td>Login Name</td><td><span class="user-data"><?php echo $user_loginname; ?></span></td><td></td></tr>
				<tr><td>Email</td><td><input type="text" name="email" id="email" value="<?php echo $user_email; ?>" class="editTextBox"/></td><td><span class="warning-msg" id="email-warning"></span></td></tr>
				<tr><td>Contact No</td><td><input type="text" name="contactno" id="contactno" value="<?php echo $user_contactno; ?>" class="editTextBox"/></td><td><span class="warning-msg" id="contactno-warning"></span></td></tr>
				<tr><td>Name</td><td><input type="text" name="fname" id="fname" value="<?php echo $user_fname; ?>" class="editTextBox-s"/><input type="text" name="lname" id="lname" value="<?php echo $user_lname; ?>" class="editTextBox-s"/></td><td><span class="warning-msg" id="name-warning"></span></td></tr>
				<tr><td>Address</td><td><input type="text" name="address1" id="address1" value="<?php echo $user_address1; ?>" class="editTextBox"/></td></tr>
				<tr><td></td><td><input type="text" name="address2" id="address2" value="<?php echo $user_address2; ?>" class="editTextBox"/></td></tr>
				<tr><td></td><td><input type="text" name="address3" id="address3" value="<?php echo $user_address3; ?>" class="editTextBox"/></td></tr>
				<tr><td>Reset Password</td><td><input type="password" name="pwd" id="pwd" class="editTextBox"/></td><td><span class="warning-msg" id="pwd-warning"></span></td></tr>
				<tr><td>Retype Password</td><td><input type="password" name="repwd" id="repwd" class="editTextBox"/></td></tr>
				<tr><td></td><td><input type="submit" value="Update" class="basic-btn" onclick="accountUpdate()" /></td></tr>
				<input type="hidden" name="ori-loginname" id="ori-loginname" value="<?php echo $user_loginname; ?>" />
				<input type="hidden" name="id" id="id" value="<?php echo $user_id; ?>" />
			</tbody>
		</table>
		</form>
	</div>
<?php	/*---Content---*/
	footer();
?>

</body>
</html>

