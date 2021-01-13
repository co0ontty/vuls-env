<?php
if (isset($_GET['str']) and isset($_GET['int'])){
    if ($_GET['str'] != $_GET['int']){
        if (intval($_GET['str']) == $_GET['int']){
            echo "You got it</br>";
        }
        else{
            echo "Only one step away from success </br>";
        }
    }
    else{
        echo "str can't = int</br>";
    }
}
else{
    echo "Input str and int by GET method</br>";
}
echo "</br>";
echo show_source(__FILE__);
?>