<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>
<head>
<title>Awesome_Blog</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<!-- CuFon: Enables smooth pretty custom font rendering. 100% SEO friendly. To disable, remove this section -->
<script type="text/javascript" src="js/cufon-yui.js"></script>
<script type="text/javascript" src="js/cuf_run.js"></script>
<link href="css/index.css" rel="stylesheet">
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
<div class="article">
<?php
include 'config/article_db.php';
$article_db = new  ARTICLE_DB();
$result = $article_db->mysql_db();
?>
<?php while($row = mysqli_fetch_array($result)){ ?>
<div class="blogs">
<h3><a href="article_show_All.php?a_id=<?php echo $row['a_id'];?>" target="_blank"><?php echo $row['a_title']; ?></a></h3>
<figure> <img src="<?php echo $row['a_photo'];?>" width="100" height="100"></figure>
<?php echo $row['a_begin'];?>
<a href="article_show_All.php?a_id=<?php echo $row['a_id'];?>" target="_blank"
	class="readmore">阅读全文&gt;&gt;</a>
<p class="autor"><span>作者：<?php echo $row['a_adduser'];?></span><span>分类：【<a href="/"><?php echo $row['a_type'];?></a>】
 </span><span>浏览（<?php echo $row['a_visit'];?>） </span><span>评论（<?php echo $row['a_comment'];?>） </span></p>
<div class="dateview" align="center"><?php echo $row['a_adddate'];?></div>
</div>
<?php 
  } 
?>

</div>
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
