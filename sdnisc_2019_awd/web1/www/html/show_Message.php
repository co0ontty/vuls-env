
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
<script type="text/javascript">
function validate(){
	alert("456");
	var name = document.getElementById("m_name");
	var text = document.getElementById("m_text");
	var verification = document.getElementById("verification");
	if(username.value==""){
//		document.getElementById("UN_status").innerHTML = "账号未填写！";
		alert("ID未填写！");
		m_name.focus();
		return false;
	}
	if(password.value==""){
//		document.getElementById("PW_status").innerHTML = "密码未填写！";
		alert("内容未填写！");
		m_text.focus();
		return false;
	}
	return true;
}
}
</script>
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
						<div class="article">
							<div class="clr" align="center">
								<h2>
									留言板
								</h2>
							</div>
							<form action="message_save.php" method="post"
								id="sendemail" >
								<ol>
									<li><label for="name"><span style="color: red">*</span>你的ID</label>
										<input id="m_name" name="m_name" class="text" rows="3"/></li>
									<li><label for="message"><span style="color: red">*</span>你的留言</label>
										<textarea id="m_text" name="m_text" rows="4" cols="30"></textarea>
									</li>
									<li><input type="image" name="imageField" id="imageField"
										src="images/submit.gif" class="send" />
										<div class="clr"></div></li>
								</ol>
							</form>
						</div>

						<br>
						<h2>
							<span>最近的留言</span> 
						</h2>
						<?php
								include 'config/message_db.php';
								$message_db = new  MESSAGE_DB();
								$result = $message_db->mysql_db();
								?>
								<?php while($row = mysqli_fetch_array($result)){ ?>
							<div class="comment">
								<a href="#"><img src="<?php echo $row['m_photo'];?>" width="40"
									height="40" alt="user" class="userpic" /></a>
								<p>
									<a href="#"><?php echo $row['m_name'];?></a> &nbsp;留言时间:<br /><?php echo $row['m_addtime'];?>
								</p>
								<p><?php echo $row['m_text'];?>.</p>
							</div>
								<?php 
  								} 
								?>
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