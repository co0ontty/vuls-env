<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
?>
<dl>
	<dt>
		<label class='form-control-label'>
			<if value="$upload['required']"><span class="text-danger">*</span></if>
			{$upload.title}
		</label>
	</dt>
	<dd>
		<div class='form-group clearfix'>
			<if value="$upload['name'] eq 'downloadurl1'">
			<input type="text" name="downloadurl" value="{$upload.value}" class="form-control mr-1">
			</if>
			<div class="d-inline-block mr-2">
				<input type="file" name="{$upload.name}" value="{$upload.value}"
				<if value="$upload['required']">data-filerequired='1' data-notEmpty-message="{$word.js15}"</if>
				data-plugin='fileinput'
				<if value="$upload['drop_zone_enabled']">data-drop-zone-enabled="false"</if>
				<if value="$upload['preview_class']">data-preview-class='{$upload.preview_class}'</if>
				<if value="$upload['noprogress']">data-noprogress='1'</if>
				<if value="$upload['noimage']">data-noimage='1'</if>
				<if value="$upload['size']">data-size='1'</if>
				<if value="$upload['multiple']">multiple</if>
				<if value="$upload['delimiter']">data-delimiter='{$upload.delimiter}'</if>
				accept="<if value="$upload['type'] neq 'file'">image/*<else/>*</if>"
				<if value="$upload['callback']">data-callback="{$upload.callback}"</if>
				>
			</div>
			<if value="$upload['tips']">
			<span class="text-help">{$upload.tips}</span>
			</if>
		</div>
	</dd>
</dl>
<?php unset($upload); ?>