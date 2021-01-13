<form method="POST" action="{$url.own_name}c=online&a=doSaveSetup" class='met-set-form mt-3' data-submit-ajax='1'>
  <div class="metadmin-fmbx">
    <h3 class='example-title'>{$word.unitytxt_1}</h3>
    <dl>
      <dt>
        <label class='form-control-label'>{$word.setskinOnline}</label>
      </dt>
      <dd>
        <div class='form-group'>
          <div class="custom-control custom-radio ">
            <input type="radio" name="met_online_type" value='3' class="custom-control-input " id="met_online_type-3" />
            <label class="custom-control-label" for="met_online_type-3">{$word.setskinOnline1}</label>
          </div>
          <div class="custom-control custom-radio ">
            <input type="radio" name="met_online_type" value='4' class="custom-control-input " id="met_online_type-4" />
            <label class="custom-control-label" for="met_online_type-4">{$word.setskinOnline9}</label>
          </div>
          <div class="custom-control custom-radio ">
            <input type="radio" name="met_online_type" value='1' class="custom-control-input " id="met_online_type-1" />
            <label class="custom-control-label" for="met_online_type-1">{$word.setskinOnline2}</label>
          </div>
          <div class="custom-control custom-radio ">
            <input type="radio" name="met_online_type" value='2' class="custom-control-input " id="met_online_type-2" />
            <label class="custom-control-label" for="met_online_type-2">{$word.setskinOnline3}</label>
          </div>
          <div class="custom-control custom-radio ">
            <input type="radio" name="met_online_type" value='0' class="custom-control-input " id="met_online_type-0" />
            <label class="custom-control-label" for="met_online_type-0">{$word.close}</label>
          </div>

        </div>
      </dd>
    </dl>

    <dl class="">
      <dt>
        <label class='form-control-label'>{$word.setskinOnline10}</label>
      </dt>
      <dd>
        <div class='form-group'>
          <div class="mb-2">
            <span class="text-help">{$word.setskinOnline5}</span>
            <input type="text" name="met_online_x" class="form-control float-none  w-auto d-inline-block" />
            <span class="text-help">{$word.setflashPixel}</span>
          </div>
          <div>
            <span class="text-help">{$word.setskinOnline6}</span>
            <input type="text" name="met_online_y" class="form-control float-none  w-auto d-inline-block" />
            <span class="text-help">{$word.setflashPixel}</span>
          </div>
        </div>
      </dd>
    </dl>
    <h3 class="example-title">{$word.unitytxt_14}</h3>
    <dl>
      <dt>
        <label class='form-control-label'>{$word.onlineskintype}</label>
      </dt>
      <dd>
        <div class='form-group'>
          <input type="text" name="met_online_color" class="form-control" data-plugin='minicolors'>
        </div>
      </dd>
    </dl>
    <dl>
      <dt>
        <label class='form-control-label'>{$word.choice_style}</label>
      </dt>
      <dd class="flex">
        <select name="met_online_skin" class="form-control float-none"></select>
        <a title="{$word.clickview}" target="_blank" class="d-block ml-3"><img /></a>
      </dd>
    </dl>
    <h3 class="example-title">{$word.unitytxt_15}</h3>
    <dl>
      <dt>
        <label class='form-control-label'>{$word.onlinetel}</label>
        <span class="text-help">{$word.onlyInStyle3}</span>
      </dt>
      <dd>
        <div class='form-group clearfix'>
          <textarea name="met_onlinetel" data-plugin='editor' data-editor-x='700' hidden></textarea>
      </dd>
    </dl>
    <dl>
      <dt></dt>
      <dd>
        <button type="submit" class='btn btn-primary'>{$word.Submit}</button>
      </dd>
    </dl>
  </div>
</form>