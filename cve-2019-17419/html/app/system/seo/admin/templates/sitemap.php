<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
?>

<div class="met-seo">
  <form method="POST" action="{$url.own_name}c=map&a=doSaveSiteMap" class="info-form mt-3" data-submit-ajax="1">
    <div class="metadmin-fmbx">
      <div class="clearfix">
        <h3 class="example-title float-left">{$word.unitytxt_1}</h3>
        <a href="https://help.metinfo.cn/faq/398.html" target="_blank" class="p-2 float-right">{$word.seotips14_1}</a>
      </div>
      <dl>
        <dt>
          <label class="form-control-label">{$word.setimgWater}</label>
        </dt>
        <dd>
          <div class="form-group clearfix">
            <input type="checkbox" data-plugin="switchery" name="met_sitemap_auto" value="0"/>
            <span class="text-help ml-2">{$word.unitytxt_77}</span>
          </div>
        </dd>
      </dl>
      <dl>
        <dt>
          <label class="form-control-label">{$word.seotips16}</label>
        </dt>
        <dd>
          <div class="form-group clearfix">
            <div class="custom-control custom-checkbox ">
              <input type="checkbox" name="met_sitemap_not1" value="1" class="custom-control-input" id="met_sitemap_not1" />
              <label class="custom-control-label" for="met_sitemap_not1">{$word.seotipssitemap1}</label>
            </div>
            <div class="custom-control custom-checkbox">
              <input type="checkbox" name="met_sitemap_not2" value="1" class="custom-control-input" id="met_sitemap_not2" />
              <label class="custom-control-label" for="met_sitemap_not2">{$word.seotips18}</label>
            </div>
            <span class="text-help ml-2">{$word.seotips2}</span>
          </div>
        </dd>
      </dl>
      <dl>
        <dt>
          <label class="form-control-label">{$word.seotips19}</label>
        </dt>
        <dd>
          <div class="form-group clearfix">
            <div class="custom-control custom-radio ">
              <input type="radio" name="met_sitemap_lang" value="1" class="custom-control-input" id="met_sitemap_lang-1" />
              <label class="custom-control-label" for="met_sitemap_lang-1">{$word.admintips1}</label>
            </div>
            <div class="custom-control custom-radio ">
              <input type="radio" name="met_sitemap_lang" value="0" class="custom-control-input" id="met_sitemap_lang-0" />
              <label class="custom-control-label" for="met_sitemap_lang-0">{$word.seotips20}</label>
            </div>
            <span class="text-help ml-2">{$word.seotips21}</span>
          </div>
        </dd>
      </dl>
      <dl>
        <dt>
          <label class="form-control-label">Sitemap{$word.type}</label>
        </dt>
        <dd>
          <div class="form-group clearfix">
            <div class="custom-control custom-checkbox ">
              <input type="checkbox" name="met_sitemap_xml" value="1" class="custom-control-input" id="met_sitemap_xml-1" />
              <label class="custom-control-label" for="met_sitemap_xml-1">{$word.sethtmsitemap4}</label>
            </div>
            <span class="text-help ml-2">{$word.seotips15_2}{$word.seotips15} <a href="{$url.site}sitemap.xml" target="_blank">{$url.site}sitemap.xml</a></span>
            <div class="custom-control custom-checkbox">
              <input type="checkbox" name="met_sitemap_txt" value="1" class="custom-control-input" id="met_sitemap_txt-1" />
              <label class="custom-control-label" for="met_sitemap_txt-1">Txt{$word.mod12}</label>
            </div>
            <span class="text-help ml-2">{$word.seotips15_3}{$word.seotips15} <a href="{$url.site}sitemap.txt" target="_blank">{$url.site}sitemap.txt</a></span>
          </div>
        </dd>
      </dl>
      <dl>
        <dt></dt>
        <dd>
          <button type="submit" class="btn btn-primary">{$word.save}</button>
          <button type="submit" class="btn btn-default ml-2">{$word.update}sitemap</button>
          <button type="submit" class="btn btn-default ml-2">{$word.update}robots</button>
        </dd>
      </dl>
    </div>
  </form>
</div>
