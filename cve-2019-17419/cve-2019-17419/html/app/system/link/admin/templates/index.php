<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
?>
<div class="met-link-list">
  <div class="d-flex justify-content-between">
    <button type="button" class="btn btn-success" data-toggle="modal" data-target=".link-add-modal"
      data-modal-url="link/add/?n=link&c=link_admin&a=doGetColumnList" data-modal-size="lg" data-modal-fullheight="1"
      data-modal-title="{$word.mobiletips3}" data-modal-tablerefresh="#link-table">
      {$word.mobiletips3}
    </button>
    <div>
      <!-- 筛选 -->
      <select name="search_type" data-table-search="#link-table" class="form-control d-inline-block w-a float-left mr-1">
        <option value="0">{$word.smstips64}</option>
        <option value="1">{$word.linkType1}</option>
        <option value="2">{$word.linkType2}</option>
        <option value="3">{$word.linkType4}</option>
        <option value="4">{$word.linkType5}</option>
      </select>
      <div class="input-group w-a float-left">
        <input type="search" name="keyword" placeholder="{$word.search}" class="form-control" data-table-search="#link-table" />
        <div class="input-group-append">
          <div class="input-group-text btn btn-light"><i class="input-search-icon wb-search" aria-hidden="true"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <table class="dataTable table table-hover w-100 mt-2 link-table"
    data-ajaxurl="{$url.own_name}c=link_admin&a=doGetList" data-table-pagelength="20" data-plugin="checkAll"
    id="link-table"
    data-time="{$time}"
    data-datatable_order="#link-table">
    <thead>
      <tr>
        <th width="50" data-table-columnclass="text-center">
          <div class="custom-control custom-checkbox">
            <input class="checkall-all custom-control-input" type="checkbox" />
            <label class="custom-control-label"></label>
          </div>
        </th>
        <th width="100" data-table-columnclass="text-center">{$word.sort}</th>
        <th width="200" data-table-columnclass="text-center">{$word.linkType}</th>
        <th width="200" data-table-columnclass="text-center">{$word.linkName}</th>
        <th width="200" data-table-columnclass="text-center">{$word.linkUrl}</th>
        <th width="200" data-table-columnclass="text-center">{$word.linkCheck}</th>
        <th width="200" data-table-columnclass="text-center">{$word.recom}</th>
        <th width="300">{$word.operate}</th>
      </tr>
    </thead>
    <tbody></tbody>
    <tfoot>
      <tr>
        <th>
          <div class="custom-control custom-checkbox">
            <input class="checkall-all custom-control-input" type="checkbox" />
            <label class="custom-control-label"></label>
          </div>
        </th>
        <th colspan="7" data-no_column_defs>
          <button type="button" class="btn btn-default btn-delete-all">
            {$word.delete}
          </button>
        </th>
      </tr>
    </tfoot>
  </table>
</div>