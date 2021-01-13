<?php
if (isset($_GET['name']) and isset($_GET['password'])){
    if ($_GET['name'] != $_GET['password']){
        if (MD5($_GET['name']) == MD5($_GET['password'])){
            echo "You got it </br>";
            echo "PHP在处理哈希字符串时，它把每一个以“0E”开头的哈希值都解释为0，所以如果两个不同的密码经过哈希以后，其哈希值都是以“0E”开头的，那么PHP将会认为他们相同，都是0。下列数组中的字符串加密结果均以 0E 开头 </br>";
            echo "['QNKCDZO','240610708','s878926199a','s155964671a','s214587387a','s214587387a']</br>";
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