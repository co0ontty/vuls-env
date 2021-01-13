<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
$data['page_title']=$_M['word']['memberLogin'].$data['page_title'];
$loginbg = $_M['config']['met_member_bgimage']?"background:url(".$_M['config']['met_member_bgimage'].") center / cover no-repeat;":'';
?>
<include file="sys_web/head"/>
<style>
.login-index{background:{$c.met_member_bgcolor};{$loginbg}}
</style>
<div class="met-member login-index page p-y-50">
	<div class="container">
		<form method="post" action="{$_M['url']['login_check']}" class='met-form met-form-validation'>
			<input type="hidden" name="gourl" value="{$_M['form']['gourl']}" />
			<div class="form-group">
				<input type="text" name="username" class="form-control" placeholder="{$_M['word']['logintips']}" required
				data-fv-notempty-message="{$_M['word']['noempty']}"
				>
			</div>
			<div class="form-group">
				<input type="password" name="password" class="form-control" placeholder="{$_M['word']['password']}" required
				data-fv-notempty-message="{$_M['word']['noempty']}"
				>
			</div>
			<?php if($_M['code']){ ?>
			<div class="form-group">
				<div class="input-group input-group-icon">
					<input type="text" name="code" class="form-control" placeholder="{$_M['word']['memberImgCode']}" required data-fv-notempty-message="{$_M['word']['noempty']}">
					<div class="input-group-addon p-5 login-code-img">
						<img src="{$_M[url][entrance]}?m=include&c=ajax_pin&a=dogetpin" title="{$_M['word']['memberTip1']}" id='getcode' align="absmiddle" role="button">
					</div>
				</div>
			</div>
			<?php } ?>
			<div class="login_link text-xs-right m-b-15"><a href="{$_M['url']['getpassword']}">{$_M['word']['memberForget']}</a></div>
			<button type="submit" class="btn btn-lg btn-primary btn-squared btn-block">{$_M['word']['memberGo']}</button>
			<?php if($_M['config']['met_qq_open']||$_M['config']['met_weixin_open']||$_M['config']['met_weibo_open']){ ?>
			<div class="login_type text-xs-center m-t-20">
				<p>{$_M['word']['otherlogin']}</p>
				<ul class="blocks-3 m-0">
					<?php if($_M['config']['met_qq_open']){ ?>
                    <li class='m-b-0'><a title="QQ{$_M['word']['login']}" href="{$_M['url']['login_other']}&type=qq"><i class="fa fa-qq font-size-30"></i></a></li>
					<?php
				    }
				    if($_M['config']['met_weixin_open'] && !(!is_weixin_client() && is_mobile_client())){
					?>
                    <li class='m-b-0'><a href="{$_M['url']['login_other']}&type=weixin"><i class="fa fa-weixin light-green-600 font-size-30"></i></a></li>
					<?php
				    }
				    if($_M['config']['met_weibo_open']){
					?>
                    <li class='m-b-0'><a href="{$_M['url']['login_other']}&type=weibo"><i class="fa fa-weibo red-600 font-size-30"></i></a></li>
					<?php } ?>
				</ul>
			</div>
			<?php } ?>
			<?php if($_M['config']['met_member_register']){ ?>
			<a class="btn btn-lg btn-info btn-squared btn-block m-t-20" href="{$_M['url']['register']}">{$_M['word']['logintips1']}</a>
			<?php } ?>
		</form>
	</div>
</div>
<include file="sys_web/foot"/>