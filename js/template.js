 function detectmob() { 
 if( navigator.userAgent.match(/Android/i)
 || navigator.userAgent.match(/webOS/i)
 || navigator.userAgent.match(/iPhone/i)
 || navigator.userAgent.match(/iPad/i)
 || navigator.userAgent.match(/iPod/i)
 || navigator.userAgent.match(/BlackBerry/i)
 || navigator.userAgent.match(/Windows Phone/i)
 ){
    return true;
  }
 else {
    return false;
  }
}

function dspLogin(){
	$('.nonclick-overlay').css('display', 'block');
	$('.overlay-container').css('display', 'block');
	document.getElementById('overlay-container').innerHTML = "";//Reset div content
	var html_statment = "<div id= \"login-container\">";
	html_statment += "<div id=\"login-content\"><label id=\"login-title\">Sign in with an account:</label></br><p></p>";
	html_statment += "<form id=\"login\" onSubmit=\"return chkLogin()\" action=\"\"><table id=\"login-form\">";
	html_statment += "<tr><td><input type=\"text\" class=\"basic-textbox\" id=\"username\" name=\"username\" placeholder=\"Username\"/><span class=\"warning-msg\" id=\"username-warning\"></span></td></tr>";
	html_statment += "<tr><td><input type=\"password\" class=\"basic-textbox\" id=\"pwd\" name=\"pwd\" placeholder=\"Password\"/><span class=\"warning-msg\" id=\"pwd-warning\"></span></br><span class=\"warning-msg\" id=\"login-warning\"></span></td></tr>";
	html_statment += "<tr><td><input type=\"submit\" value=\"Submit\" class=\"basic-btn\" onClick=\"chkLogin()\"/>  <input type=\"button\" value=\"Cancel\" id=\"btn-Cancel\" class=\"basic-btn\" onclick=\"hideOverlay(0)\"/></td></tr>";
	html_statment += "<tr><td>Do not have an account ? <a href=\"#\" onclick=\"dspRegister()\">Register</a> Now</td></tr>";
	html_statment += "</table></form></div></div>";
	document.getElementById('overlay-container').innerHTML = html_statment;

	
}

function dspNewBrand(){
	clearOverlay();
	$('.overlay').css('display', 'block');
	$('.overlay-container').css('display', 'block');
	document.getElementById('overlay-container').innerHTML = "";//Reset div content
	var html_statment = "<div id= \"newbrand-container\">";
	html_statment += "<div id=\"newbrand-content\"><span id=\"heading\"><input type= \"image\"src=\"images/back_fff.png\" class=\"small-icon\" onClick=\"hideOverlay(0)\"/> <label id=\"newbrand-title\">Add new brand</label></br><p></p>";
	html_statment += "<form id=\"newbrand\"><table id=\"newbrand-form\">";
	html_statment += "<tr><td>Name</td><td class=\"content\"><input type=\"text\" class=\"editTextBox\" name=\"brandname\" id=\"brandname\" /></td><td><span class=\"warning-msg\" id=\"brandname-warning\"></span></td></tr>";
	html_statment += "<tr><td>Description</td><td class=\"content\"><textarea id=\"description\" name=\"description\" class=\"editTextArea\"></textarea></td><td><span class=\"warning-msg\" id=\"email-warning\"></span></td></tr>";
	html_statment += "<tr><td></td><td><input type=\"button\" name=\"update\" value=\"Submit\" class=\"btnNewBrand\" onclick=\"submitNewBrand()\"/> <input type=\"button\" name=\"cancel\" value=\"Cancel\" class=\"btnNewBrand\" onClick=\"hideOverlay(0)\"/></td></tr>"
	html_statment += "</table></form></div></div>";
	document.getElementById('overlay-container').innerHTML = html_statment;
}

function chkLogin(){
	/*---Reset warning Message---*/
	var s = document.getElementsByClassName('warning-msg');
	for(var i=0; i < s.length;i++){
		s[i].innerHTML = "";
	}
	$('input[type="text"]').css('border', '0');
	$('input[type="password"]').css('border', '0');
	/*---Reset warning Message---*/
	var valid = 1;
	if($('#username').val()==""){
		document.getElementById('username-warning').innerHTML = "*Must be filled!";
		$('#username').css('border', '2px solid red');
		valid = 0;
	}
	if($('#pwd').val()==""){
		document.getElementById('pwd-warning').innerHTML = "*Must be filled!";
		$('#pwd').css('border', '2px solid red');
		valid = 0;
	}
	if(valid == 1){
		$.ajax({
            type: 'post',
            url: 'action_login.php',
            data: $('#login').serialize(),
            success: function (msg) {
			switch(msg){
				case "success":dspMsg('success','Welcome Back!');
				break;
				case "user-failed":dspMsg('error','Login Failed! User Name not found!');
				break;
				case "pwd-failed":dspMsg('error','Login Failed! Password incorrect!');
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
	return false;
}
/*----Register Overlay----*/
function dspRegister(){
	clearOverlay();
	$('.overlay').css('display', 'block');
	$('.overlay-container').css('display', 'block');
	document.getElementById('overlay-container').innerHTML = "";//Reset div content
	var html_statment = "<div id= \"register-container\">";
	html_statment += "<div id=\"register-content\"><label id=\"register-title\">Register Account</label></br><p></p>";
	html_statment += "<form id=\"register\"><table id=\"register-form\">";
	html_statment += "<tr><td>Login name</td><td class=\"content\"><input type=\"text\" class=\"basic-textbox\" name=\"loginname\" id=\"loginname\" /></td><td><span class=\"warning-msg\" id=\"loginname-warning\"></span></td></tr>";
	html_statment += "<tr><td>E-mail</td><td class=\"content\"><input type=\"text\" class=\"basic-textbox\" name=\"email\" id=\"email\" /></td><td><span class=\"warning-msg\" id=\"email-warning\"></span></td></tr>";
	html_statment += "<tr><td>Contact No.</td><td class=\"content\"><input type=\"text\" class=\"basic-textbox\" name=\"contactno\" id=\"contactno\" /></td><td><span class=\"warning-msg\" id=\"contactno-warning\"></span></td></tr>";
	html_statment += "<tr><td>Name</td><td class=\"content\"><input type=\"text\" class=\"basic-textbox-s\" name=\"fname\" id=\"fname\" placeholder=\"First Name\"/><input type=\"text\" class=\"basic-textbox-s\" name=\"lname\" id=\"lname\" placeholder=\"Last Name\"/></td><td><span class=\"warning-msg\" id=\"name-warning\"></span></td></tr>";
	html_statment += "<tr><td>Password</td><td class=\"content\"><input type=\"password\" id=\"pwd\" name=\"pwd\" class=\"basic-textbox\" /></td><td><span class=\"warning-msg\" id=\"pwd-warning\"></span></td></tr>";
	html_statment += "<tr><td>Re-enter Password</td><td class=\"content\"><input type=\"password\" id=\"repwd\" name=\"repwd\" class=\"basic-textbox\" /></td><td></td></tr>";
	html_statment += "<tr><td></td><td class=\"content\"><input type=\"button\" value=\"Submit\" class=\"basic-btn\" onClick=\"registerSubmit()\"/>  <input type=\"button\" value=\"Cancel\" id=\"btn-Cancel\" class=\"basic-btn\" onclick=\"hideOverlay(0)\"/></td><td></td></tr>";
	html_statment += "</table></form></div></div>";
	document.getElementById('overlay-container').innerHTML = html_statment;
}
function submitNewBrand(){
	valid = 1;
	/*---Reset warning Message---*/
	var s = document.getElementsByClassName('warning-msg');
	for(var i=0; i < s.length;i++){
		s[i].innerHTML = "";
	}
	$('#overlay input[type="text"]').css('border', '0');
	/*---Reset warning Message---*/
	if($('#brandname').val()==""){
		document.getElementById('brandname-warning').innerHTML = "*Must be filled!";
		$('#brandname').css('border', '2px solid red');
		valid = 0;
	}
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
		         document.getElementById('brandname-warning').innerHTML = "*Brand name Duplicated!";
		         $('#brandname').css('border', '2px solid red');
		         valid = 0;
		        
		    }else{
				/*---Submit the New Brand---*/
			    if(valid == 1){
			    	
			            $.ajax({
			            type: 'post',
			            url: 'action_newbrand.php',
			            data: $('#newbrand').serialize(),
			            success: function (msg) {
			            switch(msg){
			                case "success":dspMsg('success','New Brand Added!');
			                break;
			                case "sql-error":dspMsg('error','SQL Error!Please contact Administrator');
			                break;
			                //Debug
			                default:dspMsg('attention',msg);
			                break;
			            }
			            },
			          });
			          //alert("Test");  
			     }
			    /*---Submit the New Brand---*/
			}
		}
	}
	  xmlhttp.open("GET","chk_brandname.php?brandname="+$('#brandname').val(),true);
	  xmlhttp.send();
}
function registerSubmit(){
	/*---Reset warning Message---*/
	var s = document.getElementsByClassName('warning-msg');
	for(var i=0; i < s.length;i++){
		s[i].innerHTML = "";
	}
	$('input[type="text"]').css('border', '0');
	$('input[type="password"]').css('border', '0');
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
       /* var tmp_name = $('#loginname').val();
		valid = chkUsername(tmp_name);*/

    
    
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
	if($('#pwd').val()==""){
		document.getElementById('pwd-warning').innerHTML = "*Must be filled!";
		$('#pwd').css('border', '2px solid red');
		valid = 0;
	}
	if($('#pwd').val().length < 6){
		document.getElementById('pwd-warning').innerHTML = "*Password length must be larger than 6 character!";
		$('#pwd').css('border', '2px solid red');
		valid = 0;
	}else if($('#pwd').val()!=$('#repwd').val()){
		document.getElementById('pwd-warning').innerHTML = "*Password not match!";
		$('#repwd').css('border', '2px solid red');
		valid = 0;
	}


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
                            url: 'action_register.php',
                            data: $('#register').serialize(),
                            success: function (msg) {
                            switch(msg){
                                case "success":dspMsg('success','Thank you for joining us!');
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
	/**///End Valid
}
/*----Register Overlay----*/
function clearOverlay(){
	document.getElementById('overlay-container').innerHTML = "";//Reset div content
}
function hideOverlay(reload){
	$('.overlay').css('display', 'none');
	$('.nonclick-overlay').css('display', 'none');
	$('.overlay-container').css('display', 'none');
	document.getElementById('overlay-container').innerHTML = "";//Reset div content
	if(reload==1){
		location.reload();
	}
}

function dspCart(){

		$('#shopping-cart-info').css('display', 'block');

}
function dspMsg(type,msg){
	clearOverlay();
	$('.nonclick-overlay').css('display', 'block');
	$('.overlay-container').css('display', 'block');
	document.getElementById('overlay-container').innerHTML = "";//Reset div content
	var html_statment = "";
	switch (type){
		case "success":	html_statment += "<div id= \"message-container\" style=\"background-color:#8ec127\">";
						html_statment += "<div id=\"message-content\" style=\"background-color:#8ec127\"><label id=\"title\">Success!</label></br><p></p>";
						break;
		case "error":  html_statment += "<div id= \"message-container\" style=\"background-color:#db2d00\">";
						html_statment += "<div id=\"message-content\"  style=\"background-color:#db2d00\"><label id=\"title\">Error!</label></br><p></p>";
						break;
		case "attention":   html_statment += "<div id= \"message-container\" style=\"background-color:#0040db\">";
							html_statment += "<div id=\"message-content\" style=\"background-color:#0040db\"><label id=\"title\">Attention!</label></br><p></p>";
							break;
		default: alert("ERROR");

	}

	html_statment += "<span id=\"content\">"+msg+"</span>";
	html_statment += "<input type=\"button\" value=\"OK!\" id=\"btn-ok\" class=\"basic-btn\" onClick=\"hideOverlay(1)\">";
	html_statment += "</div></div>";
	document.getElementById('overlay-container').innerHTML = html_statment;
}
function discount_select(rate){
	document.getElementById('product_discount').value = rate;
	document.getElementById('current-discount').innerHTML = document.getElementById('discount'+rate).innerHTML;
}
function type_select(type){
	document.getElementById('user_type').value = type;
	document.getElementById('current-type').innerHTML = document.getElementById('type_'+type).innerHTML;
}
function edit_Product(pid){
	$('.overlay').css('display', 'block');
	$('.overlay-container').css('display', 'block');	
	document.getElementById('overlay-container').innerHTML = "";//Reset div content
    var get_name ="ABC";
    var get_price = "";
    var get_discount = "";
    /*----Get product data from DB---*/
            $.ajax({
            type: 'post',
            url: 'get_productdata_lite.php',
            data: {pid:pid},
            success: function (msg) {
                //Debug
                var obj = JSON.parse(msg);
                var get_name = obj[0];
                var get_price = obj[1];
                if(obj[2] > 0){
                    var get_discount = obj[2];
                }else{
                    var get_discount = "";   
                }
                //dspMsg('attention',obj[0]);
                
                	var html_statment = "<div id= \"prodedit-container\">"
                        + "<div id= \"prodedit-content\"><span id=\"heading\"><input type= \"image\"src=\"images/back_fff.png\" class=\"small-icon\" onClick=\"hideOverlay(0)\"/>  <label id=\"product-name\">" + get_name + "</label></span>"
                        + "<form id=\"update_productlite\" onSubmit=\"return product_liteSubmit()\"><table>"
                        + "<tr><td>Product Name</td><td><input type=\"text\" name=\"product_name\" id=\"product_name\" value=\""+ get_name +"\" class=\"editTextBox\"/></td><td><span class=\"warning-msg\" id=\"productname-warning\"></span></td></tr>"
                        + "<tr><td>Price($)</td><td><input type=\"text\" name=\"price\" value=\""+ get_price +"\" id=\"price\" class=\"editTextBox\"/></td><td><span class=\"warning-msg\" id=\"price-warning\"></span></td></tr>"
                        + "<tr><td>Discount</td><td><div class=\"basic-dropdown\">"//Discount Dropdown list
                        + "<span class=\"current-value\" id=\"current-discount\">"+ get_discount +"0%</span>"
                        + "<ul><li id=\"discount0\" onClick=\"discount_select(0)\">0%</li>"
                        + "<li id=\"discount9\" onClick=\"discount_select(9)\">90%</li>"
                        + "<li id=\"discount8\" onClick=\"discount_select(8)\">80%</li>"
                        + "<li id=\"discount7\" onClick=\"discount_select(7)\">70%</li>"
                        + "<li id=\"discount6\" onClick=\"discount_select(6)\">60%</li>"
                        + "<li id=\"discount5\" onClick=\"discount_select(5)\">50%</li>"
                        + "</ul></div></td></tr><input type=\"hidden\" name=\"product_discount\" id=\"product_discount\" value=\""+ obj[2] +"\"/>"
                        /*+ "<tr><td>Image</td><td><img src=\"images/empty_pic.png\" class=\"empty-pic\"/></br>"
                        + "<input type=\"file\" name=\"product_image\" class=\"fileUploadBox\"/>"
                        + "<div class=\"fake-upload\"><img src=\"images/upload.png\" /></div></td></tr>"*/
                        + "<input type=\"hidden\" name=\"pid\" value=\""+pid+"\"/>"
                        + "<tr><td></td><td><input type=\"button\" name=\"update\" value=\"Update\" class=\"btnUpdateProduct\" onClick=\"product_liteSubmit()\"/> <input type=\"button\" name=\"cancel\" value=\"Cancel\" class=\"btnUpdateProduct\" onClick=\"hideOverlay(0)\"/><a href=\"product_modify.php?product_id="+pid+"\"><input type=\"button\" name=\"full-modify\" value=\"Full Modify\" class=\"btnUpdateProduct\" /></a></td></tr>"
                        + "</table></form></div>";
                        document.getElementById('overlay-container').innerHTML = html_statment;
            },
          });
    /*----Get product data from DB---*/

}
function product_liteSubmit(){
    var valid = 1;
    /*---Product Name---*/
	if($('#product_name').val()==""){
		document.getElementById('productname-warning').innerHTML = "*Must be filled!";
		$('#product_name').css('border', '2px solid red');
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
    if(valid == 1){
        /*---Update the product---*/
        $.ajax({
            type: 'post',
            url: 'action_update_productlite.php',
            data: $('#update_productlite').serialize(),
            success: function (msg) {
               switch(msg){
                case "success":dspMsg('success','Product Updated!');
                break;
                case "sql-error":dspMsg('error','SQL Error!Please contact Administrator');
                break;
                //Debug
                default:dspMsg('attention',msg);
                break;
                }
                
            }
        });
        /*---Update the product---*/
    }

}
function chkValid_EmailFormat(id){
	var source = $('#'+id).val();
			var email_patt = /^(\d|\w)+@(\d|\w)+\.\w+$/;
			if (source.match(email_patt)==null){
				$('#'+id).css('border', '2px solid red');
				document.getElementById(id+'-warning').innerHTML = "*It is not a valid E-mail format!";
				return 0;
			}else{
				//return 1;
			}
}
function chkValid_NumberOnly(id){
	var source = $('#'+id).val();
			var num_patt = /^[0-9]+$/;
			if (source.match(num_patt)==null){
				$('#'+id).css('border', '2px solid red');
				document.getElementById(id+'-warning').innerHTML = "*Number Only!";
				return 0;
			}else{
				//return 1;
			}
}
function chkValid_CardFormat(id){
	var source = $('#'+id).val();
			var num_patt = /^(?:\d+-){3}\d+$/;
			if (source.match(num_patt)==null){
				$('#'+id).css('border', '2px solid red');
				document.getElementById(id+'-warning').innerHTML = "*It is not a valid format!!";
				return 0;
			}else{
				//return 1;
			}
}
function chkValid_DollarFormat(id){
	var source = $('#'+id).val();
			var num_patt = /^[0-9]+.?[0-9]{1,2}?$/;
			if (source.match(num_patt)==null){
				$('#'+id).css('border', '2px solid red');
				document.getElementById(id+'-warning').innerHTML = "*It is not a valid format!(Ex:14.99, 14, 14.9)";
				return 0;
			}else{
				//return 1;
			}
}
function getBrandList(){
	var brandname = $('#brand').val();
	//$("div.basic-dropdown:hover > ul").toggleClass("hover");
    $.ajax({
	    type: 'post',
	    url: 'get_brandlist.php',
	    data: {brandname: brandname},
	    success: function (msg) {
			//alert(msg);
			msg = msg.replace("{","");
			msg = msg.replace("}","");
			msg = msg.replace(/"/g,"");
			res = msg.split(",");
			document.getElementById("brand-list").innerHTML = "";
			//alert(res.length);
			if(res.length>0){
				for(var i=0;i<res.length;i++){
					
					item = res[i].split(":");
					if(item[0]!="[]"||item[0]!=""){
						document.getElementById("brand-list").innerHTML += "<li id="+item[1]+" onClick=\"brandSelect('"+item[1]+"')\">"+item[0]+"<li>";	
					}
					item.length = 0;
					document.getElementById("brand-list").innerHTML = document.getElementById("brand-list").innerHTML.replace("<li></li>","");//Clear the empty <li>
					document.getElementById("brand-list").innerHTML = document.getElementById("brand-list").innerHTML.replace("[]","");//Clear the empty <li>

				}
			}
	        //dspMsg('attention',res.length);

	    },
  });
}
function brandSelect(id){
	document.getElementById("brand").value = document.getElementById(id).innerHTML;
	document.getElementById("brandid").value = id;
}
function category_select(id){
	document.getElementById("current-category").innerHTML = document.getElementById("cate_"+id).innerHTML;
	document.getElementById("category").value = document.getElementById("cate_"+id).innerHTML;
}
function hideDropDown(){
	//$('div.basic-dropdown > ul').css('display','none');
}

function addToCart(pid){
	if($('#product-qty').val()==null){
		qty = 1;
	}else{
		qty = $('#product-qty').val();
	}
	
    $.ajax({
	    type: 'post',
	    url: 'action_addtocart.php',
	    data: {pid:pid,qty:qty},
	    success: function (msg) {
	    	switch(msg){
	    		case "login-first":dspMsg('error','Please login first!');
	    		break;
	    		default:dspMsg('attention', qty+'x &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'+msg+' <img src=\'images/added.png\' style=\'height:50px;width:50px;vertical-align:middle\' />');
	    		break;

	    	}
	    },
  	});

}

function delFromCart(pid){
	    $.ajax({
	    type: 'post',
	    url: 'action_delfromcart.php',
	    data: {pid:pid},
	    success: function (msg) {
	    	switch(msg){
	    		default:location.reload();
	    		break;

	    	}
	    },
  	});
}

function updateCartQty(pid,calc){
	var qty = document.getElementById('qty-'+pid).value;
	qty = parseInt(qty);
	switch(calc){
		case "plus":qty += 1;
		break;
		case "minus":
			if(qty > 1){
				qty -= 1;
			}
		break;
		default:qty = qty;
		break;
	}

	if(qty != "" || qty >= 0){
	$.ajax({
	    type: 'post',
	    url: 'action_updatecartqty.php',
	    data: {pid:pid,qty:qty},
	    success: function (msg) {
	    	//msg return subtotal
			//document.getElementById('subtotal'+pid).innerHTML = msg;
			location.reload();
	    },
  	});

	}else{
		//alert("NUll");
	}

}

function dspDeliveryAdd(){
	if($('#auth').val() == ""){
 		dspLogin();
 	}else{
 		$('#order-checkout').css('display', 'block');
		$('#submit-btn').css('display', 'block');
		$('#checkout-btn').css('display', 'none');	
	}

}

function clrDeliveryAdd(){
	$('#address1').val("");
	$('#address2').val("");
	$('#address3').val("");
}

function paymentSelected(type){
	/*---Reset Payment Select---*/
	$('div.payment-method').css('border', '3px solid #fff');
	/*---Reset Payment Select---*/
	$('#payment').val(type);
	$('#'+type).css('border', '3px solid #00aedb');
}

function confirmOrder(){
	/*---Reset warning Message---*/
	var s = document.getElementsByClassName('warning-msg-red');
	for(var i=0; i < s.length;i++){
		s[i].innerHTML = "";
	}
	$('input[type="text"]').css('border', '2px solid #000');
	$('#payment-method-container').css('border', '0');
	/*---Reset warning Message---*/
    var valid = 1;
    /*---Payment Method---*/
	if($('#payment').val()==""){
		document.getElementById('payment-method-warning').innerHTML = "*Must be selected!";
		$('#payment-method-container').css('border', '2px solid red');
		valid = 0;
	}
	/*---Payment Method---*/
	/*--Billing-Address---*/
	if($('#bill-address1').val()==""&& $('#bill-address2').val()==""&& $('#bill-address3').val()==""){
		document.getElementById('bill-address-warning').innerHTML = "*Billing Address is required!";
		//$('#address1').css('border', '2px solid red');
		valid = 0;
	}
	/*--Billing Address---*/
	/*--Address---*/
	if($('#address1').val()==""&& $('#address2').val()==""&& $('#address3').val()==""){
		document.getElementById('address-warning').innerHTML = "*Must be filled!";
		$('#address1').css('border', '2px solid red');
		valid = 0;
	}
	/*--Address---*/
	/*--Cardno---*/
	if($('#cardno').val()==""){
		document.getElementById('cardno-warning').innerHTML = "*Must be filled!";
		$('#cardno').css('border', '2px solid red');
		valid = 0;
	}else{
		tmp_valid = chkValid_CardFormat('cardno');//If there is an error, will return 0
		if(tmp_valid == 0){ //check if there is something have return or not.
			valid = 0;
		}
	}
	/*--Cardno---*/	
	if(valid==1){
		$("form").submit();
	}

}

function submitPurchase(){
	$.ajax({
	    type: 'post',
	    url: 'action_purchase.php',
	    data: $('#order').serialize(),
	    success: function (msg) {
	    	//msg return subtotal
			//document.getElementById('subtotal'+pid).innerHTML = msg;
			switch(msg){
                case "sql-error":dspMsg('error','SQL Error!Please contact Administrator');
                break;
                case "success":dspMsg('success','Your product(s) will be ship as soon as possible');
                break;
                default:dspMsg('attention',msg);
                break;
            }
	    },
  	});
}

function searchProduct(){
	var keyword = $('#search-textbox').val();
	window.location = "product_list.php?search="+keyword;

}

function plusQty(){
    var qty = document.getElementById('product-qty').value;
    qty = parseInt(qty);
    document.getElementById('product-qty').value = qty + 1;
    //$('#product-qty').val = $('#product-qty').val+1;
}
function minusQty(){
    var qty = document.getElementById('product-qty').value;
        qty = parseInt(qty);
    if(qty > 1){
        document.getElementById('product-qty').value = qty - 1;
    }
    //$('#product-qty').val = $('#product-qty').val+1;
}


function delProduct(pid){
	$.ajax({
	    type: 'post',
	    url: 'action_disable_product.php',
	    data: {pid:pid},
	    success: function (msg) {
	    	//msg return subtotal
			//document.getElementById('subtotal'+pid).innerHTML = msg;
			switch(msg){
                case "sql-error":dspMsg('error','SQL Error!Please contact Administrator');
                break;
                case "success":dspMsg('success','Product Deleted!');
                break;
                default:dspMsg('attention',msg);
                break;
            }
	    },
  	});
	}

