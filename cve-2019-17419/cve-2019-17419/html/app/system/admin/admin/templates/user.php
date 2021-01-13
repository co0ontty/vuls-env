<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
?>
<div>
  <button type="button" class="btn btn-success btn-add" data-toggle="modal" data-modal-url="admin/admin_add"
    data-target=".admin-add-modal" data-modal-title="{$word.add}{$word.metadmin}" data-modal-size="lg"
    data-modal-tablerefresh="#admin-table" data-modal-loading="1">
    <i class="fa fa-plus mr-1" />
    {$word.add}{$word.metadmin}
  </button>
  <div class="input-group w-a float-right">
    <input type="search" name="search" placeholder="{$word.adminusername}" class="form-control" data-table-search="#admin-table" />
    <div class="input-group-append">
      <div class="input-group-text"><i class="input-search-icon wb-search" aria-hidden="true"></i></div>
    </div>
  </div>
</div>
<table class="dataTable table table-bordered table-hover table-striped w-100 mt-2" id="admin-table"
  data-ajaxurl="{$url.own_name}c=index&a=doGetList" data-table-pagelength="20" data-plugin="checkAll"
  data-datatable_order="#admin-table">
  <thead>
    <tr>
      <th width="50" data-table-columnclass="text-center">
        <div class="custom-control custom-checkbox">
          <input class="checkall-all custom-control-input" type="checkbox" />
          <label class="custom-control-label"></label>
        </div>
      </th>
      <th data-table-columnclass="text-center">{$word.adminusername}</th>
      <th data-table-columnclass="text-center">{$word.admintips5}</th>
      <th data-table-columnclass="text-center">{$word.adminname}</th>
      <th data-table-columnclass="text-center">{$word.adminLoginNum}</th>
      <th data-table-columnclass="text-center">{$word.adminLastLogin}</th>
      <th data-table-columnclass="text-center">{$word.adminLastIP}</th>
      <th width="200">{$word.operate}</th>
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
        <div class="flex justify-content-between">
          <button type="button" class="btn btn-delete-all">

            {$word.delete}
          </button>
        </div>
      </th>
    </tr>
  </tfoot>
</table>