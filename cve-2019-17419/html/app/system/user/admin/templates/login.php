<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
?>
<div class="met-user-func">
	<form method="POST" action="{$url.own_name}c=admin_set&a=doSaveThirdParty" class="info-form mt-3" data-submit-ajax='1'>
		<div class="metadmin-fmbx">
			<h3 class="example-title">QQ</h3>
			<dl>
				<dd>
					<span class="text-help"
						>{$word.user_tips8_v6}
						<a href="http://connect.qq.com/" target="_blank">{$word.user_QQinterconnect_v6}</a>
						{$word.user_tips9_v6}</span
					>
				</dd>
			</dl>
			<dl>
				<dt>
					<label class="form-control-label">{$word.qqlogin}</label>
				</dt>
				<dd>
					<div class="form-group clearfix">
						<input type="checkbox" data-plugin="switchery" name="met_qq_open" value="0"  />
					</div>
				</dd>
			</dl>
			<dl>
				<dt>
					<label class="form-control-label">App ID</label>
				</dt>
				<dd>
					<div class="form-group clearfix">
						<input type="text" name="met_qq_appid" class="form-control" />
					</div>
				</dd>
			</dl>
			<dl>
				<dt>
					<label class="form-control-label">App Key</label>
				</dt>
				<dd>
					<div class="form-group clearfix">
						<input type="text" name="met_qq_appsecret" class="form-control" />
					</div>
				</dd>
			</dl>
			<dl>
				<dt>
					<label class="form-control-label">{$word.user_backurl_v6}</label>
				</dt>
				<dd>
					<div class="form-group clearfix">
						{$url.site}member/login.php
					</div>
				</dd>
			</dl>

			<h3 class="example-title">{$word.pay_WeChat_v6}</h3>
			<dl>
				<dd>
					<span class="text-help"
						>{$word.user_tips8_v6}
						<a href="https://open.weixin.qq.com/cgi-bin/frame?t=home/web_tmpl&lang=zh_CN" target="_blank"
							>{$_M[word][user_tips10_v6]}</a
						>
						{$word.user_Apply_v6}</span
					>
					<span class="text-help">{$_M[word][user_tips11_v6]}</span>
				</dd>
			</dl>
			<dl>
				<dt>
					<label class="form-control-label">{$word.weixinlogin}</label>
				</dt>
				<dd>
					<div class="form-group clearfix">
						<input type="checkbox" data-plugin="switchery" name="met_weixin_open" value="0"   />
					</div>
				</dd>
			</dl>
			<dl>
				<dt>
					<label class="form-control-label">{$word.user_Openplatform_v6}App ID</label>
				</dt>
				<dd>
					<div class="form-group clearfix">
						<input type="text" name="met_weixin_appid" class="form-control" />
					</div>
				</dd>
			</dl>
			<dl>
				<dt>
					<label class="form-control-label">{$word.user_Openplatform_v6}App Secret</label>
				</dt>
				<dd>
					<div class="form-group clearfix">
						<input type="text" name="met_weixin_appsecret" class="form-control" />
					</div>
				</dd>
			</dl>
			<dl>
				<dd>
					<span class="text-help"
						>{$word.user_tips8_v6}
						<a href="https://mp.weixin.qq.com/cgi-bin/frame?t=home/web_tmpl&lang=zh_CN" target="_blank"
							>{$_M[word][user_publicplatform_v6]}</a
						>
						{$word.user_Apply_v6}</span
					>
					<span class="text-help">{$_M[word][user_tips13_v6]}{$_M[word][user_tips14_v6]}</span>
				</dd>
			</dl>

			<dl>
				<dt>
					<label class="form-control-label">{$word.user_publicplatform_v6}App ID</label>
				</dt>
				<dd>
					<div class="form-group clearfix">
						<input type="text" name="met_weixin_gz_appid" class="form-control" />
					</div>
				</dd>
			</dl>
			<dl>
				<dt>
					<label class="form-control-label">{$word.user_publicplatform_v6}App Secret</label>
				</dt>
				<dd>
					<div class="form-group clearfix">
						<input type="text" name="met_weixin_gz_appsecret" class="form-control" />
					</div>
				</dd>
			</dl>
			<h3 class="example-title">{$word.user_tips15_v6}</h3>
			<dl>
				<dd>
					<span class="text-help"
						>{$word.user_tips8_v6}
						<a href="http://open.weibo.com/authentication/" target="_blank">{$word.user_tips16_v6}</a>
						{$word.user_tips9_v6}{$word.user_tips17_v6}</span
					>
				</dd>
			</dl>
			<dl>
				<dt>
					<label class="form-control-label">{$word.sinalogin}</label>
				</dt>
				<dd>
					<div class="form-group clearfix">
						<input type="checkbox" data-plugin="switchery" name="met_weibo_open" value="0"   />
					</div>
				</dd>
			</dl>
			<dl>
				<dt>
					<label class="form-control-label">App Key</label>
				</dt>
				<dd>
					<div class="form-group clearfix">
						<input type="text" name="met_weibo_appkey" class="form-control" />
					</div>
				</dd>
			</dl>
			<dl>
				<dt>
					<label class="form-control-label">App Secret</label>
				</dt>
				<dd>
					<div class="form-group clearfix">
						<input type="text" name="met_weibo_appsecret" class="form-control" />
					</div>
				</dd>
			</dl>
			<dl>
				<dt></dt>
				<dd>
					<button type="submit" class="btn btn-primary">{$word.Submit}</button>
				</dd>
			</dl>
		</div>
	</form>
</div>
