<?php

//defined ( 'SYSPATH' ) or die ( 'No direct access allowed.' );
include 'database.php';
class MESSAGE_DB{
	 public function mysql_db(){
		$database = new DATABASE();
		$con = $database->conn_mysql();
		$result = mysqli_query($con,"SELECT * FROM message");
		$database->close_mysql($con);
		return $result;
	 }
	 public function mysql_db_insert($m_name,$m_photo,$m_text,$m_addtime){
	 	$m_id = 101;
	 	$database = new DATABASE();
		$con = $database->conn_mysql();
		$result = mysqli_query($con,"insert into message(m_name,m_photo,m_text,m_addtime) value('$m_name','$m_photo','$m_text','$m_addtime')");
		$database->close_mysql($con);
	 }
}
?>