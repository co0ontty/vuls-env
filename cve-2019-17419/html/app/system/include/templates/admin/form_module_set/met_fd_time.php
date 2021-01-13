<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
?>
<dl>
	<dt>
		<label class='form-control-label'>{$word.fdincTime}{$word.marks}</label>
	</dt>
	<dd>
		<input type="text"  name="met_fd_time" value='{$data.list.met_fd_time}' class="form-control">
		<span class="text-help ml-2">{$word.fdincTip4}</span>
	</dd>
</dl>