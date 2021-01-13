<?php

//defined ( 'SYSPATH' ) or die ( 'No direct access allowed.' );
include 'database.php';
class PHOTO_DB{
	 public function mysql_db(){
		$database = new DATABASE();
		$con = $database->conn_mysql();
		$result = mysqli_query($con,"SELECT * FROM photo");
		$database->close_mysql($con);
		return $result;
	 }
}
?>