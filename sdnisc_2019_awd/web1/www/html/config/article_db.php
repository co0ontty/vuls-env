<?php

//defined ( 'SYSPATH' ) or die ( 'No direct access allowed.' );
include 'database.php';
class ARTICLE_DB{
	 public function mysql_db(){
		$database = new DATABASE();
		$con = $database->conn_mysql();
		$result = mysqli_query($con,"SELECT * FROM article");
		$database->close_mysql($con);
		return $result;
	 }
	 public function mysql_db2($a_id){
	 	$database = new DATABASE();
		$con = $database->conn_mysql();
		$result = mysqli_query($con,"SELECT * FROM article where a_id=".$a_id);
		$database->close_mysql($con);
		return $result;
	 }
}
?>