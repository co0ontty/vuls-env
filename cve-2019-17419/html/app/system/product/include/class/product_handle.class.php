<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::mod_class('news/news_handle');

/**
 * banner标签类
 */

class product_handle extends news_handle
{

    public function __construct()
    {
        global $_M;
        $this->construct('product');
    }

    /**
     * 处理list数组
     * @param  string $content 内容数组
     * @return array            处理过后数组
     */
    public function one_para_handle($content, $slim = '')
    {
        global $_M;
        $content = parent::one_para_handle($content);
        $displayimg = stringto_array($content['displayimg'], '*', '|');

        list($x, $y) = explode('x', $content['imgsize']);
        $displayimgs[] = array(
            'title' => $content['title'],
            'img' => $content['imgurl'],
            'x' => $x,
            'y' => $y
        );

        foreach ($displayimg as $key => $val) {
            if ($val[1]) {
                list($x, $y) = explode('x', $val['2']);
                $displayimgs[] = array(
                    'title' => $val[0],
                    'img' => $this->url_transform($val[1]),
                    'x' => $x,
                    'y' => $y
                );
            }
        }

        $content['displayimgs'] = $displayimgs;
        /*$content['contents'][] = array('title' => $_M['config']['met_productTabname'], 'content' => $content['content']);
        if ($_M['config']['met_productTabok'] > 1) {
            for ($i = 1; $i < $_M['config']['met_productTabok']; $i++) {
                $content['contents'][] = array('title' => $_M['config']['met_productTabname_' . $i], 'content' => $content['content' . $i]);
            }
        }*/
        if ($_M['config']['shopv2_open'] && $this->contents_page_name == 'product') {
            // 商品
            $goods = load::plugin('doget_goods', 1, $content['id']);
            if ($goods) {
                $content = array_merge($content, $goods);
            }
        }

        return $content;
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
