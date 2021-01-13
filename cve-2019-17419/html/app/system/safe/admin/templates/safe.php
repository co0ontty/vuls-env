<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
?>
<div class="met-safe-set">
  <form method="POST" action="{$url.own_name}c=index&a=doSaveSetup" class="info-form mt-3" data-submit-ajax="1"
    id="safe-form" data-validate_order="#safe-form">
    <div class="metadmin-fmbx">
      <h3 class="example-title">{$word.safety_efficiency}</h3>
      <dl>
        <dt>
          <label class="form-control-label">{$word.setimgrename}</label>
        </dt>
        <dd>
          <div class="form-group clearfix">
            <input type="checkbox" data-plugin="switchery" name="met_img_rename" value="0" />
            <span class="text-help ml-2">{$word.setimgrename1}，{$word.setimgrename2}</span>
          </div>
        </dd>
      </dl>
      <dl>
        <dt>
          <label class='form-control-label'>{$word.disableCssJs}</label>
        </dt>
        <dd>
          <div class='form-group clearfix'>
            <input type="checkbox" data-plugin="switchery" name="disable_cssjs" value='0' >
            <span class="text-help ml-2">{$word.disableCssJsTips}</span>
          </div>
        </dd>
      </dl>
      <dl>
        <dt>
          <label class="form-control-label">{$word.admin_log}</label>
        </dt>
        <dd>
          <div class="form-group clearfix">
            <input type="checkbox" data-plugin="switchery" name="met_logs" value="0" />

          </div>
        </dd>
      </dl>
      <div class="delete-file" style="display: none;">
        <div class="clearfix">
          <h3 class="example-title float-left">{$word.unitytxt_69}</h3>
          <span class="text-help ml-2 mr-2 float-right" style="line-height: 39px;">{$word.setsafeupdate1}</span>
        </div>
        <dl>
          <dt>
            <label class="form-control-label">{$word.setsafeinstall}</label>
          </dt>
          <dd>
            <div class="form-group clearfix">
              <button class="btn btn-primary btn-delete">{$word.delete}</button>
            </div>
          </dd>
        </dl>
      </div>
      <h3 class="example-title">{$word.setsafeadminname1c}{$site_admin}</h3>
      <dl>
        <dt>
          <label class="form-control-label">{$word.setsafeadminname}</label>
        </dt>
        <dd>
          <div class="form-group clearfix">
            <input type="text" name="met_adminfile" class="form-control" />
          </div>
        </dd>
      </dl>
      <h3 class="example-title">{$word.logincode}</h3>
      <dl>
        <dt>
          <label class="form-control-label">{$word.setsafeadmin}</label>
        </dt>
        <dd>
          <div class="form-group clearfix">
            <input type="checkbox" data-plugin="switchery" name="met_login_code" value="0" />
          </div>
        </dd>
      </dl>
      <dl>
        <dt>
          <label class="form-control-label">{$word.setsafemember}</label>
        </dt>
        <dd>
          <div class="form-group clearfix">
            <input type="checkbox" data-plugin="switchery" name="met_memberlogin_code" value="0" />
            <span class="text-help ml-2">{$word.upfiletips24}</span>
          </div>
        </dd>
      </dl>
      <h3 class="example-title">{$word.fdincSlash}</h3>
      <dl>
        <dt>
          <label class="form-control-label">{$word.fdincSlash}</label>
        </dt>
        <dd>
          <div class="form-group clearfix">
            <textarea name="met_fd_word" type="text" rows="5" class="form-control mr-2"></textarea>
            <span class="text-help ml-2">{$word.setbasicTip5}</span>
          </div>
        </dd>
      </dl>
      <h3 class="example-title">{$word.unitytxt_70}</h3>
      <dl>
        <dt>
          <label class="form-control-label">{$word.setbasicUploadMax}</label>
        </dt>
        <dd>
          <div class="form-group clearfix">
            <input type="text" name="met_file_maxsize" class="form-control w-auto" />
            <span class="text-help ml-2">{$word.systips15}</span>
          </div>
        </dd>
      </dl>
      <dl>
        <dt>
          <label class="form-control-label">{$word.setbasicEnableFormat}</label>
        </dt>
        <dd>
          <div class="form-group clearfix">
            <textarea name="met_file_format" type="text" rows="5" class="form-control mr-2"></textarea>
            <span class="text-help ml-2">{$word.setbasicTip5}</span>
          </div>
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