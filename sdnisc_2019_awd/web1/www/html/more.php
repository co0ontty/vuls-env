
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Awesome_Blog</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<!-- CuFon: Enables smooth pretty custom font rendering. 100% SEO friendly. To disable, remove this section -->
<script type="text/javascript" src="js/cufon-yui.js"></script>
<script type="text/javascript" src="js/cuf_run.js"></script>
<!-- CuFon ends -->
</head>
<body>

	<div class="main">
		<?php include 'menu/head.php';?>
		<br>
		<br>
		<br>
		<br>
		<div class="content">
			<div class="content_resize">
				<div class="mainbar">
					<ul>
					<div ><h3 >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="/more/money.php">赞助作者(为我赞助)</a></h3></div>
					<div ><h3 >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="/more/email.php">邮箱功能(为你发送邮件)</a></h3></div>
					<div ><h3 >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="/more/friend.php">友情链接(可以申请友链)</a></h3></div>
					<div ><h3 >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;今日访问量【0】</h3></div>
					
					<div ><h3 >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;更多功能还在开发中.....</h3></div>
					
					</ul>
				
				</div>
				<div class="sidebar">
					<div class="searchform">
						<form id="formsearch" name="formsearch" method="post" action="">
							<span><input name="editbox_search" class="editbox_search"
								id="editbox_search" maxlength="80" value="Search our ste:"
								type="text" /></span> <input name="button_search"
								src="images/search_btn.gif" class="button_search" type="image" />
						</form>
					</div>
					<div class="gadget">
						<h2 class="star">
							<span>Blog_</span> Menu
						</h2>
						<div class="clr"></div>
						<ul class="sb_menu">
							<?php include 'menu/head2.php'?>
						</ul>
					</div>
					<div class="gadget">
						<h2 class="star">
							<span>Introduce</span>
						</h2>
						<div class="clr"></div>
						<ul class="ex_menu">
							<?php include 'menu/professional_menu.php'?>
						</ul>
					</div>
				</div>
				<div class="clr"></div>
			</div>
		</div>
		<?php include 'menu/foot.php';?>
	</div>
</body>
</html>