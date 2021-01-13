<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
$head_tab_active=2;
$head_tab=array(
	array(title=>$word['myapps'],url=>'#/myapp'),
	array(title=>$word['freeapp'],url=>'#/myapp/free'),
	array(title=>$word['businessapp'],url=>'#/myapp/business'),
	array(title=>$word['chargeapp'],url=>'#/myapp/charge'),
	array(title=>$word['columnmore'],url=>$_M['config']['app_url'],target=>"1"),
);
?>
<div class="met-myapp">
  <include file="pub/head_tab" />
  <div class="met-myapp-right">
    <a href="#/myapp/login" class="mr-2">
      <button class="btn btn-primary">
        {$word.landing}
      </button>
    </a>
    <button class="btn">{$word.registration}</button>
  </div>
  <div class="met-myapp-list mt-3">
    <div class="flex search">
      <div class="alert alert-primary">{$word.installCondition}</div>
      <div class="input-group">
        <input type="search" name="keyword" placeholder="{$word.search}" class="form-control">
        <div class="input-group-prepend">
          <div class="input-group-text"><i class="input-search-icon wb-search" aria-hidden="true"></i></div>
        </div>
			</div>
</div>
      <div class="met-myapp-list-row"></div>
    </div>
    <div class="app-detail"></div>
  </div>