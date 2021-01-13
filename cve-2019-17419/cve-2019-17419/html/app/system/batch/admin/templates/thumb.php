<!--<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

require $this->template('ui/head');


echo <<<EOT
-->

<form  method="POST" name="myform" action="{$_M[url][own_form]}" target="_self">
<div class="v52fmbx" data-gent="{$_M[form][gent]}" data-webset-record="{$record}">
	<h3 class="v52fmbx_hr">{$_M[word][batch_watermarking_v6]}</h3>
<div class="v52fmbx_tbbox">

		<div class="v52fmbx_dlbox">
		<dl>
			<dt>{$_M['word']['batchtips5']}{$_M['word']['marks']}</dt>
			<dd>
			<select name="class1" id="class1select" class="noselect" style="width:150px">
			<option value="">{$_M['word']['settopcolumns']}</option>
<!--
EOT;
foreach($class1 as $key=>$val1){
    $k=$val1['id'];
    echo <<<EOT
-->
<option  value="$val1[id]" >$val1[name]</option>
<!--
EOT;
}
echo <<<EOT
-->
        </select>

        <select name="class2" id="class2select" style="width:150px">
            <option value=0>{$_M['word']['modClass2']}</option>
            </select>
            <select name="class3" id="class3select" style="width:150px">
            <option value=0>{$_M['word']['modClass3']}</option>
        </select>
    </dd>
    </dl>
    <dl id="quantity" style="display:none" >
      <dt></dt>
      <dd>
        <span></span>
      </dd>
    </dl>


<!--
    <div class="v52fmbx_dlbox">
    <dl>
        <dt>{$_M['word']['batchtips46']}{$_M['word']['marks']}</dt>
        <dd>
            <span id="schedule">0/0</span>
        </dd>
    </dl>
    </div>
-->
<!--
EOT;
echo <<<EOT
-->
        <dl>
            <div class="v52fmbx_submit">
                <input type="button" id="addthumb" name="button" value="{$_M['word']['batchtips9']}" class="submit" />
            </div>
		</dl>
		<dl>
		    <span class="tips color999">{$_M['word']['batchtips11']}</span>
		</dl>

<!--
EOT;
echo <<<EOT
-->

</div>
</form>
<!--
EOT;
require $this->template('ui/foot');
# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>