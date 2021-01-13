<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
?>
<div class="met-lang-web">
  <button type="button" class="btn btn-success btn-add" data-toggle="modal" data-target=".langweb-add-modal"
    data-modal-url="language/add" data-modal-size="lg" data-modal-title="{$word.langadd}"
    data-modal-tablerefresh="#lang-table" data-modal-loading="1">
    <i class="fa fa-plus mr-1" />
    {$word.langadd}
  </button>
  <table class="dataTable table table-bordered table-hover w-100 mt-2" id="lang-table"
    data-ajaxurl="{$url.own_name}c=language_web&a=doGetWebLanguage" data-table-pagelength="20" data-plugin="checkAll"
    data-datatable_order="#lang-table">
    <thead>
      <tr>
        <th data-table-columnclass="text-center">{$word.sort}</th>
        <th data-table-columnclass="text-center">{$word.langname}</th>
        <th data-table-columnclass="text-center">{$word.langflag}</th>
        <th data-table-columnclass="text-center">{$word.open}</th>
        <th data-table-columnclass="text-center">{$word.langhome}</th>
        <th width="200" data-table-columnclass="text-center">{$word.langouturl}</th>
        <th data-table-columnclass="text-center">{$word.operate}</th>
        <th>{$word.langpara}</th>
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
		</textarea>
        <th colspan="8" data-no_column_defs class="btn_group">
        </th>
      </tr>
    </tfoot>
  </table>
</div>