<?php
class test
{
    public $str1 = "I am str1";
    public $str2 = "I am str2";
}
$test = new test;
$data = serialize($test);
echo $data."</br>";
echo "O,object(对象),对象名长度为4，拥有两个成员变量，string类型长度为4的str1和string类型长度为4的str2";
echo "</br>";
echo show_source(__FILE__);
?>