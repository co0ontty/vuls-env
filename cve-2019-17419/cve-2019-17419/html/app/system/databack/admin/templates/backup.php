<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
$head_tab_active=0;
$head_tab=array(
array(title=>$word['databackup4'],url=>'#/databack'),
array(title=>$word['databackup2'],url=>'#/databack/recovery'),
);
?>
<include file="pub/head_tab"/>
<form method="POST" class="info-form">
	<div class="metadmin-fmbx met-databack">
		<h3 class="example-title">{$word.dataexplain5}</h3>
		<dl>
			<dt>
				<label class="form-control-label">{$word.dataexplain10}</label>
			</dt>
			<dd>
				<div class="form-group clearfix">
					<button class="btn btn-primary btn-backdata">{$word.databackup4}</button>
				</div>
			</dd>
		</dl>
		<h3 class="example-title">{$word.dataexplain6}</h3>
		<dl>
			<dt>
				<label class="form-control-label">{$word.databackup6}</label>
			</dt>
			<dd>
				<div class="form-group clearfix">
					<button class="btn btn-primary btn-backupload">{$word.databackup4}</button>
				</div>
			</dd>
		</dl>
		<h3 class="example-title">{$word.dataexplain7}</h3>
		<dl>
			<dt>
				<label class="form-control-label">{$word.databackup7}</label>
			</dt>
			<dd>
				<div class="form-group clearfix">
					<button class="btn btn-primary btn-backsite">{$word.databackup8}</button>
				</div>
			</dd>
		</dl>

	</div>
</form>
