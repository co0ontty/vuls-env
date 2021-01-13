<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved. 

defined('IN_MET') or exit('No permission');

class user_nav {
    public function nav(){
        global $_M;//记得global $_M
        parent::__construct();//如果重写了初始化方法,一定要调用父类的初始化函数。
        nav::set_nav(1, $_M['word']['userselectname']."1", $_M['url']['own_form'].'a=admin_user');
        nav::set_nav(2, $_M['word']['userselectname']."2", $_M['url']['own_form'].'a=admin_user');
        nav::set_nav(3, $_M['word']['userselectname']."3", $_M['url']['own_form'].'a=admin_user');
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>