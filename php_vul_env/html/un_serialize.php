<?php
class chybeta{
	var $test = '123';
	function __wakeup(){
		$fp = fopen("shell.php","w") ;
		fwrite($fp,$this->test);
		fclose($fp);
	}
}
$class3 = $_GET['test'];
print_r($class3);
echo "</br>";
$class3_unser = unserialize($class3);
require "shell.php";
// 为显示效果，把这个shell.php包含进来
?>
