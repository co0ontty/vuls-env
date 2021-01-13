<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
?>
<script>
var MET=[];
MET['url']=[];
MET['langtxt'] = {
	"jsx15":"{$_M['word']['jsx15']}",
	"js35":"{$_M['word']['js35']}",
	"jsx17":"{$_M['word']['jsx17']}",
	"formerror1":"{$_M['word']['formerror1']}",
	"formerror2":"{$_M['word']['formerror2']}",
	"formerror3":"{$_M['word']['formerror3']}",
	"formerror4":"{$_M['word']['formerror4']}",
	"formerror5":"{$_M['word']['formerror5']}",
	"formerror6":"{$_M['word']['formerror6']}",
	"formerror7":"{$_M['word']['formerror7']}",
	"formerror8":"{$_M['word']['formerror8']}",
	"js46":"{$_M['word']['js46']}",
	"js23":"{$_M['word']['js23']}",
	"checkupdatetips":"{$_M['word']['checkupdatetips']}",
	"detection":"{$_M['word']['detection']}",
	"try_again":"{$_M['word']['try_again']}",
	"fileOK":"{$_M['word']['fileOK']}",
};
MET['met_editor']="{$_M['config']['met_editor']}";
MET['met_keywords']="{$_M['config']['met_keywords']}";
MET['url']['ui']="{$_M['url']['ui']}";
MET['url']['own']="{$_M['url']['own']}";
MET['url']['own_tem']="{$_M['url']['own_tem']}";
MET['url']['api']="{$_M['url']['api']}";
</script>
<include file="foot"/>
<if value="!$c['shopv2_open']">
<?php $app_js_time = filemtime(PATH_WEB.'public/ui/v2/static/js/app.js'); ?>
<script src="{$_M['url']['site']}public/ui/v2/static/js/app.js?{$app_js_time}"></script>
</if>
<?php if(file_exists(PATH_OWN_FILE.'templates/'.$url['app_tem'].'js/own.js') && !((M_NAME=='product' || M_NAME=='shop') && $_M['config']['shopv2_open'])){
	$own_js_time = filemtime(PATH_OWN_FILE.'templates/'.$url['app_tem'].'js/own.js');
?>
<script src="{$_M['url']['own_tem']}{$url.app_tem}js/own.js?{$own_js_time}"></script><?php } ?>