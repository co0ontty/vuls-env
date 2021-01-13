<!--<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved. 

defined('IN_MET') or exit('No permission');
require $this->template('ui/head');

echo <<<EOT
-->
<form method="POST" class="ui-from" action="{$_M[url][own_form]}a=dodel">

<div class="v52fmbx">
    <table class="display dataTable ui-table" data-table-ajaxurl="{$_M[url][own_form]}a=dolog_list" data-table-pagelength="50">
        <thead>
            <tr>
        <th width="20" data-table-columnclass="met-center" ><input name="id" data-table-chckall="id" type="checkbox" value="" /></th>  
            <th>发送时间</th>  
            <th>发送类型</th>
            <th>短信内容</th>
            <th>对方号码</th>
            <th>发送结果</th>
            </tr>
        </thead>
        <tbody>
        <!--这里的数据由控件自动生成-->
        </tbody>
        <tfoot>
       
    </tfoot>
    </table>
</div>
</form>
<!--
EOT;
require $this->template('ui/foot');
# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved..
?>