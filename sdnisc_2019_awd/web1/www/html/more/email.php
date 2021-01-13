<?php ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Awesome_Blog</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<!-- CuFon: Enables smooth pretty custom font rendering. 100% SEO friendly. To disable, remove this section -->
<script type="text/javascript" src="../js/cufon-yui.js"></script>
<script type="text/javascript" src="../js/cuf_run.js"></script>
<!-- CuFon ends -->
</head>
<body>

	<div class="main">
		<?php include '../menu/head.php';?>
		<br>
		<br>
		<br>
		<br>
		<div class="content">
			<div class="content_resize">
				<div class="mainbar">
				<h3 >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;本功能属于测试版，由于服务器资源有限，暂不支持附件发送，可发送文本<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;内容，发送到QQ邮箱
				可能会被系统拦截但不影响查看。更多功能即将完善，请继续支持。</h3>
				<form  action="sendmail.php" method="post">
	<p align="center"><span style="color: red">*</span>收件人：<input type="text" name="smtpemailto" /></p>
	<p align="center"><span style="color: red">*</span>标&nbsp;&nbsp;题：<input type="text" name="mailtitle" /></p>
	<p align="center"><span style="color: red">*</span>内&nbsp;&nbsp;容：<textarea name="mailcontent" cols="50" rows="5"></textarea></p>
	<p align="center"><input type="submit" value="发送邮件"  /></p>
</form>
					
					
					
				</div>
				<div class="sidebar">
					<div class="searchform">
						<form id="formsearch" name="formsearch" method="post" action="">
							<span><input name="editbox_search" class="editbox_search"
								id="editbox_search" maxlength="80" value="Search our ste:"
								type="text" /></span> <input name="button_search"
								src="../images/search_btn.gif" class="button_search" type="image" />
						</form>
					</div>
					<div class="gadget">
						<h2 class="star">
							<span>Blog_</span> Menu
						</h2>
						<div class="clr"></div>
						<ul class="sb_menu">
							<?php include '../menu/head2.php'?>
						</ul>
					</div>
					<div class="gadget">
						<h2 class="star">
							<span>Introduce</span>
						</h2>
						<div class="clr"></div>
						<ul class="ex_menu">
							<?php include '../nemu/professional_menu.php'?>
						</ul>
					</div>
				</div>
				<div class="clr"></div>
			</div>
		</div>
		<?php include '../menu/foot.php';?>
	</div>
</body>
</html>