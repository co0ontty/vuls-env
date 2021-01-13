<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
?>
<div class="met-myapp-login">
  <form method="POST" action="{$url.own_name}c=index&a=doLogin" class="login-form">
    <div class="metadmin-fmbx">
      <h3 class="example-title">{$word.application_market}</h3>
      <dl>
        <dt>
          <label class="form-control-label">{$word.loginusename}</label>
        </dt>
        <dd>
          <div class="form-group clearfix">
            <div class="form-group clearfix">
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text"><i class="fa fa-user"></i></div>
                </div>
                <input type="text" name="username" class="form-control" placeholder="{$word.enter_user_name}" required
                  data-fv-notEmpty-message="{$word.js41}" />
              </div>

            </div>
          </div>
        </dd>
      </dl>
      <dl>
        <dt>
          <label class="form-control-label">{$word.loginpassword}</label>
        </dt>
        <dd>
          <div class="form-group clearfix">
            <div class="input-group">
              <div class="input-group-prepend">
                <div class="input-group-text"><i class="fa fa-lock"></i></div>
              </div>
              <input type="password" name="password" class="form-control" placeholder="{$word.Prompt_password}" required
                data-fv-notEmpty-message="{$word.js41}" />
            </div>
          </div>
        </dd>
      </dl>
      <dl>
        <dt></dt>
        <dd>
          <button type="submit" class="btn btn-primary">{$word.landing}</button>
          <button class="btn btn-default ml-2">
            <a href="https://u.mituo.cn/#/user/register" target="_blank">{$word.register}</a>
          </button>
        </dd>
      </dl>
    </div>
  </form>
</div>