<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>
<head>
<title>Awesome_Blog</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<!-- CuFon: Enables smooth pretty custom font rendering. 100% SEO friendly. To disable, remove this section -->
<script type="text/javascript" src="js/cufon-yui.js"></script>
<script type="text/javascript" src="js/cuf_run.js"></script>
<link href="css/style2.css" rel="stylesheet">
<link href="css/media.css" rel="stylesheet">
<!-- CuFon ends -->
</head>
<body>
<div class="main"><?php include 'menu/head.php'?> <br>
<br>
<br>
<br>
<div class="content">
<div class="content_resize">
<div class="mainbar">
<?php
$a_id = $_GET['a_id'];
include 'config/article_db.php';
$article_db = new  ARTICLE_DB();
$result = $article_db->mysql_db2($a_id);
$row = mysqli_fetch_array($result);
?>
<div class="ibody"><article>
<div class="index_about">
<h2 class="c_titile"><?php echo $row['a_title'];?></h2>
<p class="box_c"><span class="d_time">发布时间：<?php echo $row['a_adddate'];?></span><span>编辑：<?php echo $row['a_adduser'];?></span><span>浏览（<?php echo $row['a_visit'];?>）</span><span>评论（<?php echo $row['a_comment'];?>）</span>
</p>
<ul class="infos">
<?php echo $row['a_text'];?>
</ul>
<div class="keybq">
<p><span>关键字词</span>：<?php echo $row['a_type']; ?></p>
</div>
<div class="nextinfo">

</div>
<div class="otherlink">
<h2>相关文章</h2>
<ul>
<!--	<li><a href="/news/s/2013-07-25/524.html" title="现在，我相信爱情！">现在，我相信爱情！</a></li>-->
<!--	<li><a href="/newstalk/mood/2013-07-24/518.html" title="我希望我的爱情是这样的">我希望我的爱情是这样的</a></li>-->
<!--	<li><a href="/newstalk/mood/2013-07-02/335.html"-->
<!--		title="有种情谊，不是爱情，也算不得友情">有种情谊，不是爱情，也算不得友情</a></li>-->
<!--	<li><a href="/newstalk/mood/2013-07-01/329.html" title="世上最美好的爱情">世上最美好的爱情</a></li>-->
<!--	<li><a href="/news/read/2013-06-11/213.html" title="爱情没有永远，地老天荒也走不完">爱情没有永远，地老天荒也走不完</a></li>-->
<!--	<li><a href="/news/s/2013-06-06/24.html" title="爱情的背叛者">爱情的背叛者</a></li>-->
</ul>
</div>
</div>
</article></div>

</div>
<div class="sidebar">
<div class="searchform">
<form id="formsearch" name="formsearch" method="post" action=""><span><input
	name="editbox_search" class="editbox_search" id="editbox_search"
	maxlength="80" value="Search our ste:" type="text" /></span> <input
	name="button_search" src="images/search_btn.gif" class="button_search"
	type="image" /></form>
</div>
<div class="gadget">
<h2 class="star"><span>Blog_</span> Menu</h2>
<div class="clr"></div>
<ul class="sb_menu">
<?php include 'menu/head2.php'?>
</ul>
</div>
<div class="gadget">
<h2 class="star"><span>Introduce</span></h2>
<div class="clr"></div>
<ul class="ex_menu">
<?php include 'menu/professional_menu.php'?>
</ul>
</div>
</div>
<div class="clr"></div>
</div>
</div>

<?php include 'menu/foot.php'?></div>
</body>
</html>
