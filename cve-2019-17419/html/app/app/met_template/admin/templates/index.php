<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
$head_tab_active=0;
$head_tab=array(
	array(title=>"商业模板",url=>'#/app/met_template'),
	array(title=>"其他模板",url=>'#/app/met_template/other'),
	array(title=>"更多模板",url=>$_M['config']['templates_url'],target=>true),
);
$url=HTTP_HOST;
?>
<div class="met_template">
  <div class="head">
    <include file="pub/head_tab" />
    <div class="met_template-right">
		</div>
  </div>
  <div class="content">
    <div class="met-template-list">
    <div class="met-tips" data-url="{$url}"></div>
      <div class="met-template-container">
      </div>
    </div>
  </div>
</div>
<div class="modal fade modal-primary met-scrollbar met-modal met-install-modal" data-key=".met-install-modal">
  <div class="modal-dialog modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">{$word.met_template_demoinstalltitle}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span>×</span></button>
      </div>
      <div class="modal-body">
        <p>{$word.met_template_demoinstallsel}：</p>
        <div>1.{$word.met_template_demoinstallt1}</div>
        <div>2.{$word.met_template_demoinstallt2}</div>
        <div>3.{$word.met_template_demoinstallt3}</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">{$word.cancel}</button>
        <button type="button" class="btn btn-primary btn-backup">{$word.met_template_saveinstall}</button>
        <button type="button" class="btn btn-reset">{$word.met_template_installnewmetinfo}</button>
      </div>
    </div>
  </div>
</div>