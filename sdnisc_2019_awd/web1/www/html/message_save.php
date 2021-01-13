
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Insert title here</title>
</head>
<body>
<?php
$m_name = $_POST['m_name'];
$m_text = $_POST['m_text'];
if($m_name==null||$m_text==null){
	echo "<script type='text/javascript'>alert('ID或内容未填写，请先填写内容！');</script>";
	$url="show_Message.php";
	echo "<script language=\"javascript\">";
	echo "location.href=\"$url\"";
	echo "</script>";
}else{
$m_addtime = date("Y-m-d h:i:s");
$m_photo = 'images/userpic.gif';

include 'config/message_db.php';
$message_db = new  MESSAGE_DB();
$message_db->mysql_db_insert($m_name,$m_photo,$m_text,$m_addtime);
//	$con = mysql_connect("localhost","root","root");
//	mysql_query("set names utf8;");
//	if (!$con){
//		die('Could not connect: ' . mysql_error());
//	}
//	mysql_select_db("db_blog", $con);
//	$result = mysql_query("insert into message(m_name,m_photo,m_text,m_addtime) value('$m_name','$m_photo','$m_text','$m_addtime')");
//	mysql_close($con);
	$url="show_Message.php";
	echo "<script language=\"javascript\">";
	echo "location.href=\"$url\"";
	echo "</script>";
}

	?>
</body>
</html>
