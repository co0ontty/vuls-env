<!--<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

require $this->template('ui/head');

echo <<<EOT
-->
<form method="POST" class="ui-from" name="myform" action="{$_M[url][own_form]}a=dosaveset" target="_self">
<div class="v52fmbx">
	<h3 class="v52fmbx_hr">{$_M['word']['unitytxt_1']}</h3>
  <dl>
	 <dt>{$_M['word']['sethtmok']}
	 <input name="op" type="hidden" value="0">
	 <input name="webhtm" type="hidden" value="{$_M['config']['met_webhtm']}"></dt>
  	<dd class="ftype_radio">
      <div class="fbox">
  			<label><input name="met_webhtm" type="radio" value="0" data-checked="{$_M['config']['met_webhtm']}">{$_M['word']['close']}</label>
  			<label><input name="met_webhtm" type="radio" value="1">{$_M['word']['setbasicTip3']} {$_M['word']['systips14']} </label>
  			<label><input name="met_webhtm" type="radio" value="2">{$_M['word']['sethtmall']} {$_M['word']['systips14']} </label>
  		</div>
  		<span class="tips">{$_M['word']['setbasicTip4']}</span>
  	</dd>
  </dl>
  <dl>
	 <dt>{$_M['word']['sethtmway']}</dt>
  	<dd class="ftype_radio">
  		<div class="fbox">
  			<label><input name="met_htmway" type="radio" value="0" data-checked="{$_M['config']['met_htmway']}">{$_M['word']['sethtmway1']}
        </label>
  			<label><input name="met_htmway" type="radio" value="1">{$_M['word']['sethtmway2']}</label>
  		</div>
  		<span class="tips">{$_M['word']['sethtmway3']}</span>
  	</dd>
  </dl>
  <!--
  <dl>
   <dt>{$_M['word']['htmltopseudo']}</dt>
    <dd class="ftype_radio">
      <div class="fbox">
        <label><input name="met_htmlurl" type="radio" value="1" data-checked="{$_M['config']['met_htmlurl']}">{$_M['word']['open']}
        </label>
        <label><input name="met_htmlurl" type="radio" value="0">{$_M['word']['close']}</label>
      </div>
      <span class="tips">{$_M['word']['htmltopseudotips']}</span>
    </dd>
  </dl>
  -->
  <h3 class="v52fmbx_hr">{$_M['word']['sethtmpage4']}</h3>
  <dl>
   <dt>{$_M['word']['sethtmtype']}</dt>
    <dd class="ftype_radio">
      <div class="fbox">
        <label><input name="met_htmtype" type="radio" value="htm" data-checked="{$_M['config']['met_htmtype']}">htm
        </label>
        <label><input name="met_htmtype" type="radio" value="html">html</label>
      </div>
    </dd>
  </dl>
  <dl>
   <dt>{$_M['word']['sethtmpage']}</dt>
    <dd class="ftype_radio">
      <div class="fbox">
        <label><input name="met_htmpagename" type="radio" value="3">ID</label>
        <label><input name="met_htmpagename" type="radio" value="0" data-checked="{$_M['config']['met_htmpagename']}">{$_M['word']['sethtmpage1']}
        </label>
        <label><input name="met_htmpagename" type="radio" value="1">{$_M['word']['sethtmpage2']}</label>
        <label><input name="met_htmpagename" type="radio" value="2">{$_M['word']['sethtmpage3']}</label>
      </div>
    </dd>
  </dl>
  <dl>
   <dt>{$_M['word']['setlisthtmltype']}</dt>
    <dd class="ftype_radio">
      <div class="fbox">
        <label><input name="met_listhtmltype" type="radio" value="0" data-checked="{$_M['config']['met_listhtmltype']}">{$_M['word']['setlisthtmltype1']}
        </label>
        <label><input name="met_listhtmltype" type="radio" value="1">{$_M['word']['setlisthtmltype2']}</label>
      </div>
    </dd>
  </dl>
  <dl>
   <dt>{$_M['word']['sethtmlist']}</dt>
    <dd class="ftype_radio">
      <div class="fbox">
        <label><input name="met_htmlistname" type="radio" value="0" data-checked="{$_M['config']['met_htmlistname']}">{$_M['word']['sethtmlist1']}
        </label>
        <label><input name="met_htmlistname" type="radio" value="1">{$_M['word']['sethtmlist2']}</label>
      </div>
    </dd>
  </dl>
	<dl class="noborder">
		<dt> </dt>
    <dd>
      <input type="submit" name="submit" class="submit" data-del-html="{$_M['word']['seotips11']}" data-generate-html="{$_M['word']['seotips12']}" value="{$_M['word']['Submit']}"/>
		</dd>
	</dl>
</div>
</form>
<!--
EOT;
require $this->template('ui/foot');
# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
