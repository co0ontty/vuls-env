<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
$data['page_title']=$_M['word']['getTip5'].$data['page_title'];
?>
<include file="sys_web/head"/>
<div class="register-index met-member page p-y-50 bg-pagebg1">
	<div class="container ">
	<form class="form-register ui-from met-form-validation panel panel-body" method="post" action="{$_M['url']['password_email']}">
		<h1 class='m-t-0 m-b-20 font-size-24 text-xs-center'>{$_M['word']['getTip5']}</h1>
		<div class="form-group">
			<input type="text" name="username" class="form-control" placeholder="{$_M['word']['getpasswordtips']}" required data-fv-notempty-message="{$_M['word']['noempty']}">
		</div>
		<?php if($_M['config']['met_memberlogin_code']){ ?>
		<div class="form-group">
		    <div class="input-group input-group-icon">
		        <span class="input-group-addon"><i class="fa fa-shield"></i></span>
		        <input type="text" name="code" required class="form-control" placeholder="{$_M['word']['memberImgCode']}" data-fv-notempty-message="{$_M['word']['js14']}">
		        <div class="input-group-addon p-5 login-code-img">
		            <img src="{$_M[url][entrance]}?m=include&c=ajax_pin&a=dogetpin" title="{$_M['word']['memberTip1']}" id='getcode' align="absmiddle" role="button">
		        </div>
		    </div>
		</div>
		<?php } ?>
		<button class="btn btn-lg btn-primary btn-squared btn-block" type="submit">{$_M['word']['next']}</button>
		<div class="login_link m-t-10 text-xs-right"><a href="{$_M['url']['login']}">{$_M['word']['relogin']}</a></div>
	</form>
	</div>
</div>
<include file="sys_web/foot"/>