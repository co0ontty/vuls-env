<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
$basic_admin_js_time = filemtime(PATH_WEB.'public/ui/v2/static/js/basic_admin.js');
$lang_json_admin_js_time = filemtime(PATH_WEB.'cache/lang_json_admin_'.$_M['lang'].'.js');
if(!$foot_no && !$_M['foot_no']){
	$foot = str_replace('$metcms_v',$_M['config']['metcms_v'], $_M['config']['met_agents_copyright_foot']);
	$foot = str_replace('$m_now_year',date('Y',time()), $foot);
?>
</div>
<?php } ?>
<button type="button" class="btn btn-icon btn-primary btn-squared met-scroll-top" hidden><i class="icon wb-chevron-up" aria-hidden="true"></i></button>
</body>
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
	"try_again":"{$_M['word']['try_again']}"
};
MET['langset']="{$_M['langset']}";
MET['anyid']="{$_M['form']['anyid']}";
MET['met_editor']="{$_M['config']['met_editor']}";
MET['met_keywords']="{$_M['config']['met_keywords']}";
MET['met_alt']="{$_M['config']['met_alt']}";
MET['url']['basepath']="{$_M['url']['site_admin']}";
MET['url']['ui']="{$_M['url']['ui']}";
MET['url']['own_form']="{$_M['url']['own_form']}";
MET['url']['own_name']="{$_M['url']['own_name']}";
MET['url']['own']="{$_M['url']['own']}";
MET['url']['own_tem']="{$_M['url']['own_tem']}";
MET['url']['api']="{$_M['url']['api']}";
</script>
<script src="{$_M['url']['site']}public/ui/v2/static/js/basic_admin.js?{$basic_admin_js_time}"></script>
<script src="{$_M['url']['site']}cache/lang_json_admin_{$_M['langset']}.js?{$lang_json_admin_js_time}"></script>
<?php if(file_exists(PATH_OWN_FILE.'templates/js/own.js')){
	$own_js_time = filemtime(PATH_OWN_FILE.'templates/js/own.js');
?>
<script src="{$_M['url']['own_tem']}js/own.js?{$own_js_time}"></script>
<?php } ?>
</html>