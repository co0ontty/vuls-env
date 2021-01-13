<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
$basic_admin_css_filemtime = filemtime(PATH_STATIC.'css/basic_admin.css');
$met_title.='-'.$word['metinfo'];
$synchronous=$_M['langlist']['admin'][$_M['langset']]['synchronous'];
?>
<!DOCTYPE HTML>
<html class="{$html_class}">
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit">
<meta name="robots" content="noindex,nofllow">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0,minimal-ui">
<meta name="format-detection" content="telephone=no">
<title data-title="{$word.metinfo}">{$met_title}</title>
<meta name="generator" content="MetInfo {$c.metcms_v}" data-variable="{$url.site}|{$_M['lang']}|{$synchronous}|{$c.met_skin_user}||||">
<link href="{$url.site}favicon.ico" rel="shortcut icon" type="image/x-icon">
<link href="{$url.static_new}css/basic_admin.css?{$basic_admin_css_filemtime}" rel='stylesheet' type='text/css'>
<!--['if lte IE 9']>
<script src="{$url.static_new}js/lteie9.js"></script>
<!['endif']-->
</head>
<!--['if lte IE 9']>
<div class="text-center mb-0 bg-danger alert">
    <button type="button" class="close" data-dismiss="alert">
        <span aria-hidden="true">×</span>
    </button>
    {$word.browserupdatetips}
</div>
<!['endif']-->
<body class="{$body_class}">