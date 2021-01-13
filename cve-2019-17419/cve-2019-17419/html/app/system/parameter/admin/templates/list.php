<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
if($data['handle']){
	$data=array_merge($data,$data['handle']);
	unset($data['handle']);
}
$table_order='parameter-list-'.$data['module'].'-'.$data['class1'].'-'.$data['class2'].'-'.$data['class3'];
?>
<font class="text-danger">{$word.admin_content_list1}</font>
<form method="POST" action="{$url.own_name}c=parameter_admin&a=doparasave&module={$data.module_value}&class1={$data.class1}&class2={$data.class2}&class3={$data.class3}" data-submit-ajax='1'>
	<table class="table table-hover dataTable w-100 mt-2 parameter-list" id="{$table_order}" data-ajaxurl="{$url.own_name}c=parameter_admin&a=dojson_para_list&module={$data.module_value}&class1={$data.class1}&class2={$data.class2}&class3={$data.class3}" data-table-pageLength="1000" data-plugin="checkAll" data-datatable_order="#{$table_order}">
		<thead>
			<tr>
				<include file="pub/content_list/checkall_all"/>
				<th>{$word.paraname}</th>
				<th data-table-columnclass="text-center" width="80">{$word.parametertype}</th>
				<if value="$data['module'] neq 'message'">
				<th data-table-columnclass="text-center">{$word.category}</th>
				</if>
				<th data-table-columnclass="text-center" width="90">{$word.webaccess}</th>
				<?php
				$colspan=$data['module']=='message'?5:6;
				if(strpos('345', $data['module_value'])===false){
					$colspan++;
				?>
				<th data-table-columnclass="text-center" width="60">{$word.user_must_v6}</th>
				<?php } ?>
				<th width="110">{$word.operate}</th>
			</tr>
		</thead>
		<tbody data-plugin="dragsort" data-dragsort_order=".parameter-list">
			<include file="pub/content_list/table_loader"/>
		</tbody>
		<?php
		$colspan--;
		$table_newid=1;
		?>
		<include file="pub/content_list/tfoot_common"/>
					<include file="pub/content_list/btn_table_add"/>
					<textarea table-addlist-data hidden>
						<tr>
							<td class="text-center">
								<div class="custom-control custom-checkbox">
									<input class="checkall-item custom-control-input" type="checkbox" name="id">
									<label class="custom-control-label"></label>
								</div>
								<input type="hidden" name="no_order"></td>
							<td>
								<div class="form-group">
									<input type="text" name="name" required class="form-control">
								</div>
							</td>
							<td class="text-center">
								<select name="type" class="form-control w-a d-inline-block">
									<list data="$data['type_options']" name="$v">
									<option value="{$v.val}">{$v.name}</option>
									</list>
								</select>
							</td>
							<if value="$data['module'] neq 'message'">
							<td class="text-center">
								<select name="class" data-checked="{$data.class1}-{$data.class2}-{$data.class3}" class="form-control w-a d-inline-block">
									<list data="$data['class_options']" name="$v">
									<option value="{$v.val}">{$v.name}</option>
									</list>
								</select>
							</td>
							</if>
							<td class="text-center">
								<select name="access" class="form-control w-a d-inline-block">
									<list data="$data['access_options']" name="$v">
									<option value="{$v.val}">{$v.name}</option>
									</list>
								</select>
							</td>
							<if value="!in_array($data['module_value'], array(3,4,5))">
							<td class="text-center">
								<select name="wr_ok" class="form-control w-a d-inline-block">
									<option value="1">{$word.yes}</option>
									<option value="0">{$word.no}</option>
								</select>
							</td>
							</if>
							<td>
								<button type="button" class="btn btn-sm btn-primary btn-parameter-setoptions" data-toggle="modal" data-target=".parameter-options-modal" data-modal-title="{$word.listTitle}" hidden>{$word.listTitle}</button>
								<input name="options" type="hidden"/>
							</td>
						</tr>
					</textarea>
					<if value="$data['module_value'] eq 3">
					<span class='text-help font-weight-normal ml-2'>{$word.product_para_tips}</span>
					</if>
				</th>
			</tr>
		</tfoot>
	</table>
</form>