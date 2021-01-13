<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
$data = $data['handle'];
$data['value']=$data['modules']?$data['modules']:$data['columns'];
?>
<div class="met-seo-link">
  <div class="d-flex justify-content-between">
    <div>
      <button type="button" class="btn btn-success" data-toggle="modal" data-target=".link-add-modal"
        data-modal-url="tags/add/?c=index&a=doGetParentColumns" data-modal-size="lg" data-modal-fullheight="1"
        data-modal-title="{$word.mobiletips3}" data-modal-tablerefresh="#tags_table">
        {$word.add_tag}
      </button>
      <span class="text-help ml-2">{$word.admin_tag_setting8}<a href="{$url.site}tags/"
          target="_blank">{$url.site}tags/</a></span>
    </div>
    <div>
      <!-- 筛选 -->
      <select name="cid" data-table-search="#tags_table" class="form-control d-inline-block w-a float-left mr-1 select-cid">
        <list data="$data['value']">
          <option value="{$val.id}">{$val.name}</option>
        </list>
      </select>
      <div class="input-group w-a float-left">
        <input type="search" name="keyword" placeholder="{$word.search}" class="form-control"
          data-table-search="#tags_table" />
        <div class="input-group-append">
          <div class="input-group-text btn btn-light"><i class="input-search-icon wb-search" aria-hidden="true"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <table class="dataTable table table-hover w-100 mt-2" data-ajaxurl="{$url.admin}?n=tags&c=index&a=doGetTagsList"
    data-table-pagelength="20" data-plugin="checkAll" data-time="{$time}" id="tags_table"
    data-datatable_order="#tags_table">
    <thead>
      <tr>
        <th width="50" data-table-columnclass="text-center">
          <div class="custom-control custom-checkbox">
            <input class="checkall-all custom-control-input" type="checkbox" />
            <label class="custom-control-label"></label>
          </div>
        </th>
        <th width="100" data-table-columnclass="text-center">{$word.sort}</th>
        <th width="200" data-table-columnclass="text-center">{$word.tag_name}</th>
        <th width="200" data-table-columnclass="text-center">{$word.columnhtmlname}</th>
        <th width="200" data-table-columnclass="text-center">{$word.font_size}</th>
        <th width="200" data-table-columnclass="text-center">{$word.text_color}</th>
        <th width="200" data-table-columnclass="text-center">{$word.source}
          <select name="source" data-table-search="#tags_table"
            class="form-control d-inline-block w-a ml-2 select-groupid">
            <option value="0">{$word.cvall}</option>
            <option value="1">{$word.content}</option>
            <option value="2">{$word.add_manully}</option>
          </select>
        </th>
        <th width="200" data-table-columnclass="text-center">{$word.aggregation_range}</th>
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
        <th colspan="8" data-no_column_defs>
          <button type="button" class="btn btn-default btn-delete-all">
            {$word.delete}
          </button>
        </th>
      </tr>
    </tfoot>
  </table>
</div>