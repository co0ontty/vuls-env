<?php defined('IN_MET') or exit('No permission'); ?>
<if value="$c['met_img_page'] && $data['sub']">
	<tag action='category' cid="$data['classnow']" type="son">
		<li class="widget">
			<div class="cover overlay overlay-hover">
				<img class="cover-image overlay-scale" <if value="$v['_index'] gt 3 || $data['page'] gt 1">data-original<else/>src</if>="{$v.imgurl|thumb:$c['met_imgs_x'],$c['met_imgs_y']}" alt="{$v.title}"/>
			</div>
		    <div class="cover-title">
			  <h3>{$m._name}</h3>
			</div>
		</li>
	</tag>
<else/>
<tag action='img.list' num="$c['met_img_list']">
	<li class="widget {$v['page']}">
		<div class="cover overlay overlay-hover">
			<a href='{$v.url}' title='{$v.title}'  target="{$lang.met_listurlblank}" class="btn btn-outline btn-inverse met-img-showbtn">
					<img class="cover-image overlay-scale" <if value="$v['_index'] gt 3 || $data['page'] gt 1">data-original<else/>src</if>="{$v.imgurl|thumb:$c['met_imgs_x'],$c['met_imgs_y']}" alt="{$v.title}"/>
			</a>
		</div>
	    <div class="cover-title">
		  <h3><a href='{$v.url}' target="{$lang.met_listurlblank}" title='{$v.title}'>{$v._title}</a></h3>
		</div>
	</li>
</tag>
</if>