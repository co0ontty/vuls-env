<!--<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

require $this->template('ui/head');

echo <<<EOT
-->
<link rel="stylesheet" href="{$_M['url']['own_tem']}css/metinfo.css?{$jsrand}" />
<input type="hidden" id="auto" value="{$_M['form']['auto']}">
<input type="hidden" id="reurl" value="{$_M['form']['reurl']}">
<div class="v52fmbx" data-gent="{$_M['form']['gent']}" data-webset-record="{$record}">
	<a data-url="{$url}" href="javascript:;" style="dispaly:none;"></a>
	<div>
		<div id="htmlloading" class="htmlloading_generate">
			<h3></h3>
			<div class="listbox"></div>
		</div>
	</div>
</div>
<!--
EOT;
require $this->template('ui/foot');
# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
