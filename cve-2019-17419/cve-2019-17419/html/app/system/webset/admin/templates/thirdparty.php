<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
$head_tab_active=2;
$head_tab=array(
	array(title=>$word['website_information'],url=>'#/webset'),
	array(title=>$word['email_Settings'],url=>'#/webset/email'),
	array(title=>$word['third_party_code'],url=>'#/webset/thirdparty')
);
?>
<div class="met-web-set">
	<include file="pub/head_tab"/>
	<form method="POST" action="{$url.own_name}c=thirdparty&a=doSaveThirdparty"  class='third-form mt-3' data-submit-ajax='1'>
		<div class="metadmin-fmbx">
			<h3 class='example-title'>{$word.unitytxt_36}</h3>
			<dl>
				<dt>
					<label class='form-control-label'>{$word.setheadstat}</label>
				</dt>
				<dd>
					<div class='form-group clearfix'>
						<textarea name="met_headstat" rows="5" class='form-control mr-2'></textarea>
						<span class="text-help">{$word.unitytxt_37}</span>
					</div>
				</dd>
			</dl>
			<dl>
				<dt>
					<label class='form-control-label'>{$word.setfootstat}</label>
				</dt>
				<dd>
					<div class='form-group clearfix'>
						<textarea name="met_footstat" rows="5" class='form-control mr-2'></textarea>
						<span class="text-help">{$word.unitytxt_38}</span>
					</div>
				</dd>
			</dl>
			<h3 class='example-title'>{$word.third_code_mobile}</h3>
			<dl>
				<dt>
					<label class='form-control-label'>{$word.setheadstat}</label>
				</dt>
				<dd>
					<div class='form-group clearfix'>
						<textarea name="met_headstat_mobile" rows="5" class='form-control mr-2'></textarea>
						<span class="text-help">{$word.unitytxt_37}</span>
					</div>
				</dd>
			</dl>
			<dl>
				<dt>
					<label class='form-control-label'>{$word.setfootstat}</label>
				</dt>
				<dd>
					<div class='form-group clearfix'>
						<textarea name="met_footstat_mobile" rows="5" class='form-control mr-2'></textarea>
						<span class="text-help">{$word.unitytxt_38}</span>
					</div>
				</dd>
			</dl>
			<dl>
				<dt></dt>
				<dd>
					<button type="submit" class='btn btn-primary'>{$word.save}</button>
				</dd>
			</dl>
		</div>
	</form>
</div>