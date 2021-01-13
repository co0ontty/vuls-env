<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
?>
<div class="form-group">
	<div class="input-group">
		<span class="input-group-addon"><i class="fa fa-user"></i></span>
		<input type="text" name="username" required class="form-control" placeholder="{$_M['word']['memberName']}"
		data-fv-remote="true"
		data-fv-remote-url="{$_M['url']['register_userok']}"
		data-fv-remote-message="{$_M['word']['userhave']}"

		data-fv-notempty-message="{$_M['word']['noempty']}"

		data-fv-stringlength="true"
		data-fv-stringlength-min="2"
		data-fv-stringlength-max="30"
		data-fv-stringlength-message="{$_M['word']['usernamecheck']}"
		/>
	</div>
</div>
<div class="form-group">
	<div class="input-group">
		<span class="input-group-addon"><i class="fa fa-unlock-alt"></i></span>
		<input type="password" name="password" required class="form-control" placeholder="{$_M['word']['password']}"
		data-fv-notempty-message="{$_M['word']['noempty']}"

		data-fv-identical="true"
		data-fv-identical-field="confirmpassword"
		data-fv-identical-message="{$_M['word']['passwordsame']}"

		data-fv-stringlength="true"
		data-fv-stringlength-min="6"
		data-fv-stringlength-max="30"
		data-fv-stringlength-message="{$_M['word']['passwordcheck']}"
		>
	</div>
</div>
<div class="form-group">
	<div class="input-group">
		<span class="input-group-addon"><i class="fa fa-unlock-alt"></i></span>
		<input type="password" name="confirmpassword" required data-password="password" class="form-control" placeholder="{$_M['word']['renewpassword']}"
		data-fv-identical="true"
		data-fv-identical-field="password"
		data-fv-identical-message="{$_M['word']['passwordsame']}"
		data-fv-notempty-message="{$_M['word']['noempty']}"
		>

	</div>
</div>
<?php if($_M['config']['met_memberlogin_code']){ ?>
<div class="form-group">
    <div class="input-group input-group-icon">
        <span class="input-group-addon"><i class="fa fa-shield"></i></span>
        <input type="text" name="code" required class="form-control" placeholder="{$_M['word']['memberImgCode']}" data-fv-notempty-message="{$_M['word']['noempty']}">
        <div class="input-group-addon p-5 login-code-img">
            <img src="{$_M[url][entrance]}?m=include&c=ajax_pin&a=dogetpin" title="{$_M['word']['memberTip1']}" id='getcode' align="absmiddle" role="button">
        </div>
    </div>
</div>
<?php } ?>