<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::sys_class('database');

/**
 * 搜索标签类
 */

class tags_database extends database{
    public function __construct() {
        global $_M;
        $this->construct($_M['table']['tags']);
    }

    public function getTagsInfo($tag, $tag_pinyin,$class1,$id)
    {
        global $_M;
        $query = "SELECT * FROM {$_M['table']['tags']} WHERE tag_name='{$tag}' AND tag_pinyin='{$tag_pinyin}' AND list_id='{$id}' AND `cid`='{$class1}' AND lang='{$_M['lang']}'" ;
        $data = db::get_one($query);
        return $data;
    }

    public function getTagNmae($tag_pinyin)
    {
        global $_M;
        $query = "SELECT * FROM {$_M['table']['tags']} WHERE tag_pinyin = '{$tag_pinyin}' AND lang = '{$_M['lang']}'";
        $res = DB::get_one($query);
        $tag = $res['tag_name'];
        return $tag;
    }


    public function getAlltags()
    {
        global $_M;
        $query = "SELECT * FROM {$_M['table']['tags']} WHERE lang = '{$_M['lang']}' GROUP BY tag_name";
        $tags = DB::get_all($query);
        return $tags;
    }

}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
