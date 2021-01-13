<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
?>
<div class="met-lang-admin">
<button
type="button"
class="btn btn-success btn-add"
data-toggle="modal"
data-target=".lang-adminAdd-modal"
data-modal-url="language/admin_add"
data-modal-size="lg"
data-modal-title="{$word.langadd}"
data-modal-tablerefresh="#lang-admin-table"
data-modal-loading="1"
>
<i class="fa fa-plus mr-1" />
{$word.langadd}
</button>
<table
	class="dataTable table table-bordered table-hover table-striped w-100 mt-2"
	id="lang-admin-table"
	data-ajaxurl="{$url.own_name}c=language_admin&a=doGetAdminLanguage"
	data-table-pagelength="20"
	data-plugin="checkAll"
	data-datatable_order="#lang-admin-table"
>
	<thead>
		<tr>
			<th width="100" data-table-columnclass="text-center">{$word.sort}</th>
			<th width="150" data-table-columnclass="text-center">{$word.langname}</th>
			<th width="100" data-table-columnclass="text-center">{$word.open}</th>
			<th width="100" data-table-columnclass="text-center">{$word.langhome}</th>
			<th width="600" data-table-columnclass="text-center">{$word.sys_lang_operate}</th>
			<th width="150" data-table-columnclass="text-center">{$word.langpara}</th>
		</tr>
	</thead>
	<tbody></tbody>
	<tfoot>
		<tr>
			<textarea table-addlist-data hidden>
							<tr class="class1">
								<td class="text-center">
									<div class="custom-control custom-checkbox">
										<input class="checkall-item custom-control-input" type="checkbox" name="id">
										<label class="custom-control-label"></label>
									</div>
				
								</td>
								<td class="td-column-name">
										<input type="text" name="no_order-1"  class="form-control">
								</td>
								<td class="text-center">
										<input type="text" name="name-1"   class="form-control text-center">
								</td>
								<td class="text-center">
										<input type="text" name="qq-1"   class="form-control text-center">
								</td>
								<td class="text-center">
										<input type="text" name="msn-1"  class="form-control text-center">
								</td>
								<td class="text-center">
										<input type="text" name="taobao-1"   class="form-control text-center">
								</td>
								<td class="text-center">
										<input type="text" name="alibaba-1"   class="form-control text-center">
								</td>
								<td class="text-center">
										<input type="text" name="skype-1"   class="form-control text-center">
								</td>
								<td>
									<button type="button" class='btn btn-sm btn-success' table-save-new data-url="{$url.own_name}c=index&a=doAddColumn">{$word.Submit}</button>
								</td>
							</tr>
						</textarea
			>

			<th colspan="6" data-no_column_defs class="btn_group">

			</th>
		</tr>
	</tfoot>
</table>
</div>
