<?php
	class DATABASE{
		public function conn_mysql(){
			$con = mysqli_connect("localhost","db_blog","shee>f7Hee{ma7oo");
			mysqli_query($con,"set names utf8;");
			if (!$con){
				die('Could not connect: ' . mysqli_error());
			}
			mysqli_select_db($con,"db_blog");
			return $con;
		}
		public function close_mysql($con){
			mysqli_close($con);
		}
	}
?>