<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
$head_tab_active=1;
$head_tab=array(
	array(title=>"商业模板",url=>'#/app/met_template'),
	array(title=>"其他模板",url=>'#/app/met_template/other'),
	array(title=>"更多模板",url=>$_M['config']['templates_url'],target=>true),
);
?>
<div class="met_template">
  <div class="head">
    <include file="pub/head_tab" />
  </div>
  <div class="content">
    <div class="met-template-list">
      <div class="alert alert-primary tips w-100">如果需安装自己制作的模板，请到应用市场安装 <a href="#/myapp/free">模板制作助手</a></div>
      <div class="met-template-container">

      </div>
    </div>
  </div>
</div>