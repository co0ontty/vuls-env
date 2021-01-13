<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::mod_class('product/product_handle');

/**
 * banner标签类
 */

class download_handle extends product_handle
{
    public function __construct()
    {
        global $_M;
        $this->construct('download');
    }

    /**
     * 处理list数组
     * @param  string $content 内容数组
     * @return array            处理过后数组
     */
    public function one_para_handle($content)
    {
        global $_M;
        $content = parent::one_para_handle($content);
        $content['downloadurl'] = str_replace('../',$_M['url']['web_site'],$content['downloadurl']);
        if ($content['downloadaccess']) {
            $url = urlencode(load::sys_class('auth', 'new')->encode($content['downloadurl']));
            $groupid = urlencode(load::sys_class('auth', 'new')->encode($content['downloadaccess']));
            $content['downloadurl'] = "{$_M['url']['entrance']}?m=include&c=access&a=dodown&url={$url}&groupid={$groupid}";
        }
        return $content;
    }

}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
