<?php
    class test
    {
       public $str1 = "I am str1";
       public $str2 = "I am str2";
    }
    $test = new test;
    $data = serialize($test);
    #$str = 'O:4:"test":2:{s:4:"str1";s:9:"I am str1";s:4:"str2";s:9:"I am str2";}';
    $obj = unserialize($data);
    var_dump($obj);
    echo "</br>";
    echo show_source(__FILE__);
?>
