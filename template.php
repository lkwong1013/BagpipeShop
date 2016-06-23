<?php session_start(); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<link rel="stylesheet" href="css/template.css" type="text/css"/>
	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/template.js"></script>
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
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>ISD3 Template</title>
</head>

<body>
<div class="overlay">
</div>
<div class="overlay-container">
	<div id="login-container">
		<div id="login-content">
			<label id="login-title">Sign in with an account:</label></br>
			<p></p>
			<table id="login-form">
			<tr><td><input type="text" class="basic-textbox" placeholder="Username"/></td></tr>
			<tr><td><input type="password" class="basic-textbox" placeholder="Password"/></td></tr>
			<tr><td><input type="button" value="Submit" class="basic-btn"/>  <input type="button" value="Cancel" class="basic-btn" onclick="hideOverlay()"/></td></tr>
			</table>
		</div>
	</div>	
</div>
<div class="wrapper">
	<div class="wrapper-container">

		<header>
			<div class="logo">
				<img src="images/logo.jpg" id="logo"/>
			</div>
			<div id="login" onClick="dspLogin()">
				<input type="button" id="content" value="Login" />
			</div>
			<div id="item-search">
				<span id="content"><input type="text" id="search-textbox" name="search" placeholder="Search Product..."/> <input type="image" src="images/search.png" class="small-icon" value="Search"/></span>
			</div>
			<div id="shopping-cart" onClick="dspCart()">
				<span id="content">Shopping cart: Cart Total: <label class="amount">$0</lable></span>
				<div id="shopping-cart-info">
					<span id="title">RECENTLY ADDED ITEMS</span>
					<table id="cart-list">
					<thead><tr><td>#</td><td>Description</td><td>QTY.</td><td id="amount">Amount</td></tr></thead>
					<tbody>
					<tr><td>1</td><td>Flapper Valve</td><td>2</td><td id="amount">$1500.00</td></tr>
					<tr><td>2</td><td>Wallace Bagpipe Set 1</td><td>1</td><td id="amount">$20000.00</td></tr>
					</tbody>
					<tfoot>
					<tr><td colspan="2"></td><td colspan="2">Total: $21500.00</td></tr>
					<tr><td colspan="2"></td><td colspan="2"><input type="button" value="Checkout" id="checkout" /></td></tr>
					</tfoot>
					</table>
				</div><!---shopping-cart-info-->
			</div><!---shopping-cart-->

			<div id="menu">
				<ul>
					<li><a href="#">Home</a></li>
					<li><a href="#">Bagpipes</a>
						<ul>
							<li><a href="#">Wallace Bagpipes</a></li>
						</ul>
					</li>
					<li><a href="#">Reeds</a>
						<ul>
							<li><a href="#">Pipe Chanter Reeds</a></li>
						</ul>
					</li>
				</ul>
			</div><!---menu-->
		</header>
		<content>
			<div class="content-container">
				<span id="content">Wiki軟體是由軟體設計模式社群發展出來，用來書寫與討論模式語言。沃德·坎寧安於1995年3月25日成立了第一個Wiki網站：WikiWikiWeb，用來補充他自己經營的軟體設計模式網站。他發明了Wiki這個名字以及相關概念，並且實作了第一個Wiki引擎。坎寧安說自己是根據檀香山的Weekee Weekee(快點快點)公車取名的。這是他到檀香山學會的第一個夏威夷語。

坎寧安說Wiki的構想是來自他自己在1980年代晚期利用蘋果電腦HyperCard程式作出的一個小功能[4]。HyperCard類似名片整理程式，可用來紀錄人物與相關事物。HyperCard管理許多稱為「卡片」的資料，每張卡片上都可劃分欄位、加上圖片、有樣式的文字或按鈕等等，而且這些內容都可在查閱卡片的同時修改編輯。HyperCard類似於後來的網頁，但是缺乏一些重要特徵。

坎寧安認為原本的HyperCard程式很有用，但創造卡片與卡片之間的連結卻很困難。於是他不用HyperCard程式原本的創造連結功能，而改用「隨選搜尋」的方式自己增添了一個新的連結功能。使用者只要將連結輸入卡片上的一個特殊欄位，而這個欄位每一行都有一個按鈕。按下按鈕時如果卡片已經存在，按鈕就會帶使用者去那張卡片，否則就發出嗶聲，而繼續壓著按鈕不放，程式就會為使用者產生一張卡片。

坎寧安將這個程式與他自己寫的人事卡片展示給許多朋友看，往往會有人指出卡片之中的內容不太對，而他們也可以當場利用HyperCard初始的功能修正內容，以及利用坎寧安加入的新功能補充連結。

坎寧安後來在別處又寫了這樣的功能，而且這次他還增加了多使用者寫作功能。新功能之一是程式會在每一次任何一張卡片被更改時，自動在「最近更改」卡片上增加一個連往被更改卡片的連結。坎寧安自己常常看「最近更改」卡片，而且還會注意到空白的說明欄位會讓他想要描述一下更改的摘要[5]。
奧德·坎寧安和波·路夫（Bo Leuf）在《The Wiki Way: Quick Collaboration on the Web》一書中描述了Wiki概念的幾個本質特徵：

Wiki允許任何用戶在Wiki網站內剪輯任何頁面或新建頁面，不需要任何額外的附加元件，只需透過普通的網頁瀏覽器即可。
編輯Wiki頁面[編輯]
Wiki中用戶使用很多方式來編輯。通常需要透過文字標記式語言。
Wiki在一些需要內容管理系統的企業中得到了廣泛應用[6]、JotSpot和SocialText是創Wiki企業應用的先河。Wiki可以在高校教育環境中發揮積極的作用，但是直到2006年，Wiki應用於教育的案例在全球都比較少。Wiki除了被用來建立網站外，也被用作編寫部落格。Wiki在中小學教育方面，可以作為學生協助學習的平台。

實施[編輯]
Wiki軟體是一款執行Wiki的合作性軟體，允許使用常見的Web瀏覽器建立和修改網頁，被作為應用程式伺服器在多個網頁伺服器上運作。

導航[編輯]
在大多數頁面的文字，通常有大量的超文字連結到其他網頁。大多數Wiki有一個反向的功能，它顯示所有連結到一個給定頁面的頁面。</span>
			</div>
		</content>
		<footer>
			<div class="footer-container">
				<div id="payment">
					<span id="content">Payment Option</br><ul><li>VISA</li><li>EPS</li><li>AE</li></ul></span>
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
</body>
</html>