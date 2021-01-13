<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
$html_class=$body_class='h-100';
$html_class.=' met-admin';
?>
<include file="pub/header"/>
<if value="!$_M['form']['noside']">
<div class="h-100 cover d-flex">
	<div class="metadmin-sidebar h-100 transition500">
		<div class="metadmin-logo d-flex align-items-center justify-content-center" style="height: 70px;">
			<a href="#/home" title="{$word.metinfo}" class="d-block">
				<img src="{$data.met_admin_logo}" alt="{$word.metinfo}" width="150">
				<i class="fa-home h2 mb-0 text-white"></i>
			</a>
		</div>
		<hr class="my-0">
		<ul class="list-unstyled mb-0 metadmin-sidebar-nav">
			<li class="text-center py-3 transition500">
				<a href="#/home">{$word.backstage}</a>
				<span class="mx-1">|</span>
				<a href="{$url.site}index.php?lang={$_M['lang']}" target="_blank">{$word.homepage}</a>
				<if value="$data['privilege']['navigation'] eq 'metinfo' || strstr($data['privilege']['navigation'], '1802')">
				<span class="mx-1">|</span>
				<a href="{$url.site_admin}?lang={$_M['lang']}&n=ui_set" target="_blank">{$word.visualization}</a>
				</if>
			</li>
			<hr class="my-0">
			<list data="$data['adminnav']['top']" name="$m">
			<li class="transition500">
				<a <if value="$m['url']">href="#/{$m.url}"<else/>href="javascript:;"</if> title="{$m.name}" class="d-flex justify-content-between align-items-center px-4">
					<div><i class="iconfont-metadmin icon-metadmin-{$m.icon}"></i><span>{$m.name}</span></div>
					<if value="$data['adminnav']['sub'][$m['id']]"><span class="fa fa-angle-right h5 mb-0"></span></if>
				</a>
				<if value="$data['adminnav']['sub'][$m['id']]">
				<ul class="sub list-unstyled text-nowrap">
					<list data="$data['adminnav']['sub'][$m['id']]" name="$msub">
					<li class="transition500">
						<a <if value="$msub['url']">href="#/{$msub.url}"<else/>href="javascript:;"</if> title="{$msub.name}" class="d-block px-4"><i class="iconfont-metadmin icon-metadmin-{$msub.icon}"></i><span>{$msub.name}</span></a>
						<if value="$data['adminnav']['sub'][$msub['id']]">
						<ul class="sub list-unstyled text-nowrap">
							<list data="$data['adminnav']['sub'][$msub['id']]" name="$msub1">
							<li class="transition500">
								<a <if value="$msub1['url']">href="#/{$msub1.url}"<else/>href="javascript:;"</if> title="{$msub1.name}" class="d-block px-4"><if value="$msub1['icon']"><i class="iconfont-metadmin icon-metadmin-{$msub1.icon}"></i></if><span>{$msub1.name}</span></a>
							</li>
							</list>
						</ul>
						</if>
					</li>
					</list>
				</ul>
				</if>
			</li>
			</list>
		</ul>
	</div>
</if>
	<div class="metadmin-rightcontent h-100 met-scrollbar position-relative media-body" style="background: #f7fcff;overflow-x: hidden;">
		<if value="!$_M['form']['noside']">
		<?php
		$lang_name=$_M['langlist']['web'][$_M['lang']]['name'];
		?>
		<header class="metadmin-head navbar bg-light metadmin-shadow px-0">
			<div class="container-fluid">
				<div>
					<button type="button" class="btn btn-default btn-sm px-0 float-left btn-adminsidebar-control" style="width: 35px;"><i class="wb-arrow-left h5 mb-0"></i></button>
			        <div class="breadcrumb mb-0 p-0 d-none d-md-flex bg-none float-left ml-3 mt-1 metadmin-breadcrumb">
			            <li class='breadcrumb-item'>{$lang_name}</li>
			        </div>
		        </div>
		        <div class="metadmin-head-right">
                    <if value="$data['clear_cache'] eq 1">
		        	<div class="btn-group">
		                <button class="btn btn-light dropdown-toggle" type="button" data-toggle="dropdown">
		                    <i class="iconfont-metadmin icon-metadmin-clear-chache"></i>
		                    <span class="d-none d-md-inline-block">{$word.clearCache}</span>
		                </button>
		                <ul class="dropdown-menu dropdown-menu-right metadmin-head-langlist">
		                	<a href="{$url.own_form}n=ui_set&c=index&a=doclear_cache" title="{$word.clearCache}" class='dropdown-item px-3 clear-cache'>{$word.system_cache}</a>
		                	<a href="{$url.own_form}n=ui_set&c=index&a=doClearThumb" title="{$word.clearThumb}" class='dropdown-item px-3 clear-cache'>{$word.modimgurls}</a>
		                </ul>
		            </div>
					</if>
                    <if value="$data['checkupdate'] eq 1">
                    <button class="btn btn-light" data-toggle="modal" data-target=".update-modal" data-modal-size="lg" data-modal-url="update" data-modal-fullheight="1" data-modal-title="{$word.checkupdate}" data-modal-oktext="" data-modal-notext="{$word.close}">
	                    <i class="iconfont-metadmin icon-metadmin-update"></i>
	                    <span class="d-none d-md-inline-block">{$word.checkupdate}</span>
	                </button>
                    </if>
		            <if value="$data['function_complete'] eq 1">
	                <button class="btn btn-light" data-toggle="modal" data-target=".function-ency-modal" data-modal-size="lg" data-modal-url="#pub/function_ency" data-modal-refresh="one" data-modal-fullheight="1" data-modal-title="{$word.funcCollection}" data-modal-oktext="" data-modal-notext="{$word.close}">
	                    <i class="iconfont-metadmin icon-metadmin-function"></i>
	                    <span class="d-none d-md-inline-block">{$word.funcCollection}</span>
	                </button>
		            </if>
		            <if value="$c['met_agents_metmsg']">
		            <div class="btn-group">
		            	<button class="btn btn-light dropdown-toggle" type="button" data-toggle="dropdown">
		                    <i class="iconfont-metadmin icon-metadmin-manual"></i>
		                    <span class="d-none d-md-inline-block">{$word.indexbbs}</span>
		                </button>
		                <ul class="dropdown-menu dropdown-menu-right">
		                	<a href="{$c.help_url}" target="_blank" class='dropdown-item px-3'>{$word.help_manual}</a>
		                	<a href="{$c.edu_url}" target="_blank" class='dropdown-item px-3'>{$word.extension_school}</a>
		                	<a href="{$c.qa_url}" target="_blank" class='dropdown-item px-3'>{$word.online_quiz}</a>
		                	<a href="{$c.kf_url}" target="_blank" class='dropdown-item px-3'>{$word.online_work_order}</a>
                            <if value="$data['environmental_test'] eq 1">
                            <a href="javascript:;" class='dropdown-item px-3' data-toggle="modal" data-target=".system-check-env-modal" data-modal-size="lg" data-modal-url="system/envmt_check/?c=patch&a=docheckEnv" data-modal-fullheight="1" data-modal-title="{$word.environmental_test}" data-modal-oktext="" data-modal-notext="{$word.close}">{$word.environmental_test}</a>
                            </if>
		                </ul>
		            </div>
		            </if>
		            <div class="btn-group">
		                <button class="btn btn-light dropdown-toggle" type="button" data-toggle="dropdown">
		                    <i class="iconfont-metadmin icon-metadmin-multilingualism"></i>
		                    <span class="d-none d-md-inline-block">{$lang_name}</span>
		                </button>
		                <ul class="dropdown-menu dropdown-menu-right metadmin-head-langlist">
		                	<list data="$_M['user']['langok']" name="$v">
		                    <a href="javascript:;" data-val='{$v.mark}' class='dropdown-item px-3'>{$v.name}</a>
		                    </list>
	                        <li class="px-3 py-1"><a href="#/language" class="btn btn-success btn-add-lang"><i class="fa fa-plus"></i> {$word.added}{$word.langweb}</a></li>
		                </ul>
		            </div>
		            <div class="btn-group">
		                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">{$_M['user']['admin_name']}</button>
		                <ul class="dropdown-menu dropdown-menu-right">
		                    <a href="#/admin/user" class="dropdown-item px-3">{$word.modify_information}</a>
		                    <a href="{$url.adminurl}n=login&c=login&a=dologinout" class="dropdown-item px-3">{$word.indexloginout}</a>
		                </ul>
		            </div>
			    </div>
		    </div>
		</header>
		</if>
		<div class="metadmin-main px-4 mt-4 mb-3">
		</div>
		<div class="metadmin-loader"><div class="text-center d-flex align-items-center h-100"><div class="loader loader-round-circle"></div></div></div>
		<footer class="metadmin-foot px-4 my-3 text-grey">{$data.copyright}</footer>
		<button type="button" class="btn btn-primary btn-squared met-scroll-top position-fixed" hidden><i class="icon wb-chevron-up" aria-hidden="true"></i></button>
	</div>
<if value="!$_M['form']['noside']">
</div>
<button type="button" data-toggle="modal" class="btn-admin-common-modal" hidden></button>
</if>
<include file="pub/footer"/>