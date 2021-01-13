<!--<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

require $this->template('ui/head');

echo <<<EOT
-->
	<link rel="stylesheet" href="{$_M['url']['own_tem']}css/metinfo.css?{$jsrand}" />
	<input type="hidden" id="auto" value="{$_M['form']['auto']}">
	<input type="hidden" id="reurl" value="{$_M['form']['url']}">
  <div class="v52fmbx" data-gent="{$_M['form']['gent']}" data-webset-record="{$record}">
  <div style="position:relative;">
    <div id="htmlloading" class="htmlloading_html">
    	<h3></h3>
    	<div class="listbox"></div>
    </div>
  </div>
	<h3 class="v52fmbx_hr">{$_M['word']['setbasicWebInfoSet']}</h3>
<!--
EOT;
foreach($class1 as $key=>$val){
echo <<<EOT
-->
	<dl>
		<dt>{$val['name']}</dt>
		<dd class="ftype_input">
			<div class="fbox">
				<a class="html" data-url="{$val['content']['url']}" href="javascript:;">{$val['content']['name']}</a>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <a class="html" data-url="{$val['column']['url']}" href="javascript:;">{$val['column']['name']}</a>
			</div>
		</dd>
	</dl>
<!--
EOT;
}
echo <<<EOT
-->
	<dl class="noborder">
		<dt> </dt>
		<dd>
			<input type="submit" name="submit" value="{$_M['word']['Submit']}" class="submit">
		</dd>
	</dl>
</div>
<!--
EOT;
require $this->template('ui/foot');
# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
