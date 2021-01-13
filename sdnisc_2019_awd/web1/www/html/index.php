<?php ?>
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
					<div class="article">
						<p>
							<span class="date">2017-1-19</span> 1
						</p>
						<h2>
							<span>自己写的博客，有兴趣的朋友可以互相交流</span> 
						</h2>
						<div class="clr"></div>
						<img src="images/img2.jpg" width="625" height="205" alt="image" />
						<p></p>
						
					</div>
					
					<div class="article">
						<p>
							<span class="date">2017-1-20</span> 2
						</p>
						<h2>
							<span>Tucao & Everyday</span>
						</h2>
						<div class="clr"></div>
						<img src="images/psb.jpg" width="625" height="205" alt="image" />
						<p>最好的生活是用心甘情愿的态度，过随遇而安的生活。</p>
						<p class="spec">
							<a href="article_show_List.php" class="rm">更多文章 &raquo;</a>
						</p>
					</div>
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