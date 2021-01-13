<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
$checkbox_time = time();
$data = $data['handle'];
?>
<div class="met-safe-set">
  <form method="POST" action="{$url.own_name}c=index&a=doSaveGlobalSearch" class="info-form mt-3" data-submit-ajax="1"
    id="safe-form" data-validate_order="#safe-form">
    <div class="metadmin-fmbx">
      <dl>
        <dt><label class='form-control-label'>{$word.search_range}</label></dt>
        <dd class="form-group">
          <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" id="global_search_range_1" name="global_search_range" value='all'
              data-checked="{$c.global_search_range}" required class="custom-control-input" />
            <label class="custom-control-label" for="global_search_range_1">{$word.cvall}</label>
          </div>
          <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" id="global_search_range_2" name="global_search_range" value='module'
              class="custom-control-input" />
            <label class="custom-control-label" for="global_search_range_2">{$word.by_module}</label>
          </div>
          <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" id="global_search_range_3" name="global_search_range" value='column'
              class="custom-control-input"  />
            <label class="custom-control-label" for="global_search_range_3">{$word.by_column}</label>
          </div>
        </dd>
      </dl>

      <dl id="module-collapse" class='collapse'>
        <dt>
          <label class='form-control-label'>{$word.by_module}</label>
        </dt>
        <dd>
          <div class="form-group">
            <select name="global_search_module" class="form-control mr-1 prov w-a" required
              data-checked="{$c.global_search_module}">
              <option value="2">{$word.mod2}</option>
              <option value="3">{$word.mod3}</option>
              <option value="5">{$word.mod5}</option>
              <option value="4">{$word.mod4}</option>
            </select>
          </div>
        </dd>
      </dl>
      <dl id="column-collapse" class='collapse'>
        <dt>
          <label class='form-control-label'>{$word.by_column}</label>
        </dt>
        <dd>
          <div class="form-group">
            <select name="global_search_column" class="form-control mr-1 prov w-a" required
              data-checked="{$c.global_search_column}">
              <list data="$data['column']">
                <option value="{$val.id}">{$val.name}</option>
              </list>
            </select>
          </div>
        </dd>
      </dl>
      <dl>
        <dt><label class='form-control-label'>{$word.admin_search6}</label></dt>
        <dd class="form-group">
          <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" id="global_search_type_1" name="global_search_type" value='0'
              data-checked="{$c.global_search_type}" class="custom-control-input" />
            <label class="custom-control-label" for="global_search_type_1">{$word.cvall}</label>
          </div>
          <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" id="global_search_type_2" name="global_search_type" value='1'
              class="custom-control-input" />
            <label class="custom-control-label" for="global_search_type_2">{$word.title}</label>
          </div>
          <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" id="global_search_type_3" name="global_search_type" value='2'
              class="custom-control-input" />
            <label class="custom-control-label" for="global_search_type_3">{$word.content}</label>
          </div>
          <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" id="global_search_type_4" name="global_search_type" value='3'
              class="custom-control-input" data-toggle="collapse" data-target="#more-collapse" />
            <label class="custom-control-label" for="global_search_type_4">{$word.admin_search7}</label>
          </div>

        </dd>
      </dl>


      <dl>
        <dt>{$word.admin_search4}</dt>
        <dd>
          <div class='form-group clearfix'>
            <input type="text" name="search_placeholder" class="form-control" value="{$data.search_placeholder}"></div>
        </dd>

      </dl>
      <dl>
        <dt></dt>
        <dd>
          <button type="submit" class="btn btn-primary">{$word.Submit}</button>
        </dd>
      </dl>
    </div>
  </form>
</div>