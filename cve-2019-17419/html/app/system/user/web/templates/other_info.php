<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
?>
<include file="sys_web/head"/>
<div class="register-index met-member page p-y-50">
	<div class="container">
		<form class="form-register met-form met-form-validation p-30 bg-white" method="post" action="{$_M['url']['login_other_register']}">
			<input type="hidden" name="type" value="{$_M['form']['type']}"/>
			<input type="hidden" name="other_id" value="{$_M['form']['other_id']}"/>
			<h1 class='m-t-0 m-b-20 font-size-24 text-xs-center'>{$_M['word']['memberReg']}</h1>
			<div class="form-group">
				<input type="text" name="username" class="form-control" placeholder="{$_M['word']['memberbasicUserName']}">
			</div>
			<button class="btn btn-lg btn-primary btn-squared btn-block" type="submit">{$_M['word']['memberRegister']}</button>
		</form>
	</div>
</div>
<include file="sys_web/foot"/>