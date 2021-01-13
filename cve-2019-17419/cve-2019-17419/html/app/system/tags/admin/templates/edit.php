<?php
defined('IN_MET') or exit('No permission');
$data = $data['handle'];
$data['value']=$data['modules']?$data['modules']:$data['columns'];
$id=$data['modules']?'module':'cid';
$check=$data[$id];
?>
<form method="POST" action="{$url.own_name}c=index&a=doSaveTags" class="link-form" data-submit-ajax="1">
  <div class="metadmin-fmbx">
    <dl>
      <dt>
        <label class="form-control-label">{$word.tag_name}</label>
      </dt>
      <dd>
        <div class="form-group clearfix">
          <input type="text" name="tag_name" class="form-control" required value="{$data.tag_name}" />
        </div>
      </dd>
    </dl>
    <dl>
      <dt>
        <label class="form-control-label">title</label>
      </dt>
      <dd>
        <div class="form-group clearfix">
          <input type="text" name="title" class="form-control" value="{$data.title}"/>
          <span class="text-help ml-2">{$word.admin_tag_setting7}</span>
        </div>
      </dd>
    </dl>
    <dl>
      <dt>
        <label class="form-control-label">keywords</label>
      </dt>
      <dd>
        <div class="form-group clearfix">
          <input type="text" name="keywords" class="form-control" value="{$data.keywords}"/>
          <span class="text-help ml-2">{$word.admin_tag_setting7}</span>
        </div>
      </dd>
    </dl>

    <dl>
      <dt>
        <label class="form-control-label">description</label>
      </dt>
      <dd>
        <div class="form-group clearfix">
          <textarea name="description" rows="5" class="form-control mr-2"  >{$data.description}</textarea>
          <span class="text-help ml-2">{$word.admin_tag_setting7}</span>
        </div>
      </dd>
    </dl>
    <dl>
      <dt>
        <label class='form-control-label'>{$word.columnhtmlname}</label>
      </dt>
      <dd class="form-group">
        <input type="text" name="tag_pinyin" class="form-control" value="{$data.tag_pinyin}" />
        <span class="text-help ml-2">{$word.admin_tag_setting7}</span>
      </dd>
    </dl>

    <dl id="column-collapse" class='collapse show'>
      <dt>
        <label class='form-control-label'>{$word.aggregation_range}</label>
      </dt>
      <dd>
        <div class="form-group">
          <select name="{$id}" class="form-control mr-1 prov w-a" required data-checked="{$check}">
            <list data="$data['value']">
              <option value="{$val.id}">{$val.name}</option>
            </list>
          </select>
        </div>
      </dd>
    </dl>

    <dl>
      <dt>
        <label class="form-control-label">{$word.sort}</label>
      </dt>
      <dd>
        <div class="form-group clearfix">
          <input type="number" name="sort" class="form-control" required value={$data.sort} />
        </div>
      </dd>
    </dl>

    <dl>
      <dt>
        <label class='form-control-label'>{$word.text_color}</label>
      </dt>
      <dd>
        <input type="text" name="tag_color" value="{$data.tag_color}" class="form-control" data-plugin='minicolors' placeholder="{$word.default_values}">
      </dd>
    </dl>

    <dl>
      <dt>
        <label class="form-control-label">{$word.font_size}</label>
      </dt>
      <dd>
        <div class="form-group clearfix">
          <input type="number" name="tag_size" class="form-control"  value={$data.tag_size} placeholder="{$word.default_values}"/>
          <span class="text-help ml-2">px</span>
        </div>
      </dd>
    </dl>

    <dl>
      <input type="text" name="id" class="form-control" value={$data.id} hidden />
      <button type="submit" hidden class="btn"></button>
    </dl>
  </div>
</form>