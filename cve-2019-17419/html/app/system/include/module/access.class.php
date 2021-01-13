<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved. 

defined('IN_MET') or exit('No permission');

load::sys_class('web');

class access extends web
{

    public function doinfo()
    {
        global $_M;
        $str = urldecode(load::sys_class('auth', 'new')->decode($_M['form']['str']));
        $groupid = urldecode(load::sys_class('auth', 'new')->decode($_M['form']['groupid']));
        $power = load::sys_class('user', 'new')->check_power($groupid);
        if ($power > 0) {
            echo 'document.write("' . $str . '")';
        } else {
            load::mod_class('user/user_url', 'new')->insert_m();
            $url_login = $_M['url']['login'];
            $url_register = $_M['url']['register'];
            echo 'document.write("' . "【<a href='" . $url_login . "' target='_blank'>{$_M['word']['login']}</a>】【<a href='" . $url_register . "' target='_blank'>{$_M['word']['register']}</a>】" . '")';
        }
    }

    public function dodown()
    {
        global $_M;
        $url = urldecode(load::sys_class('auth', 'new')->decode($_M['form']['url']));
        $groupid = urldecode(load::sys_class('auth', 'new')->decode($_M['form']['groupid']));
        $power = load::sys_class('user', 'new')->check_power($groupid);
        $lang = $_M['form']['lang'] ? $_M['form']['lang'] : $_M['lang'];
        $gourl = $_M['gourl']? base64_encode($_M['gourl']) : base64_encode($_M['url']['web_site']);
        if ($power > 0) {
            header("location:{$url}");
        } else {
            if ($power == -2) {
                okinfo($_M['url']['web_site'] . 'member/login.php?lang='.$lang, $_M['word']['systips1']);
                #okinfo($_M['url']['web_site'] . 'member/index.php?lang='.$lang.'&gourl=' . $gourl, $_M['word']['systips1']);
            }
            if ($power == -1) {
                okinfo($_M['url']['web_site'] . 'index.php?lang='.$lang.'&gourl=' . $gourl , $_M['word']['systips2']);
            }
        }
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>