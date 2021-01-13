<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
$head_tab_active=isset($data['head_tab_active'])?$data['head_tab_active']:0;
$head_tab=array(
	array(title=>$word['article6'],url=>'seo/seo/?nocommon=1'),
	array(title=>$word['pseudostatic'],url=>'seo/pseudostatic'),
	array(title=>$word['staticpage'],url=>'seo/staticpage'),
	array(title=>$word['anchor_text'],url=>'seo/anchor/?nocommon=1'),
	array(title=>"SiteMap",url=>'seo/sitemap'),
	array(title=>$word['indexsetFriendly'],url=>'seo/link'),
	array(title=>$word['tag'],url=>'seo/tags/?n=tags&c=index&a=doGetParentColumns'),
);
$head_tab_ajax=1;
?>
<div class="met-seo">
<include file="pub/head_tab"/>

</div>
