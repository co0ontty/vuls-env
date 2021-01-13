<?php
if (isset($_GET['name']) and isset($_GET['password'])){
    if ($_GET['name'] != $_GET['password']){
        if (MD5($_GET['name']) === MD5($_GET['password'])){
            echo "You got it </br>";
            echo "php 的 md5 函数存在如下特性 md5([1,2,3]) == md5([4,5,6]) == NULL</br>";
        }
        else{
            echo "Only one step away from success</br>";
        }
    }
    else{
        echo "Can you let MD5( name ) == MD5( password ) and name != password</br>";
    }
    
}
else{
    echo "Input name and password by GET method</br>";
}
echo "</br>";
echo show_source(__FILE__);
?>