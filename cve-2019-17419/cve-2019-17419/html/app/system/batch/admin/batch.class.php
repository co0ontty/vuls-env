<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::sys_class('admin.class.php');
load::sys_class('nav.class.php');

class batch extends admin {
    public $module;
    public $watermark;

    public function __construct()
    {
        global $_M;
        parent::__construct();
        nav::set_nav(1,$_M[word][batch_wm_v6], $_M['url']['own_form'].'&a=doindex');
        $this->module = load::mod_class('column/column_op', 'new')->get_sorting_by_module(1);
        $this->watermark = load::sys_class('watermark', 'new');
    }

    public function doindex(){
        global $_M;
        nav::select_nav(1);
        $class1 = array();
        foreach ($this->module as $key => $val) {
            foreach ($val['class1'] as $k => $v) {
                if(in_array($v['module'],array(1,2,3,4,5)))
                    $class1[$k] = $v;
            }
        }
        #dump($class1);
        require $this->template('own/watermark');
    }

    public function do_get_class2()
    {
        global $_M;
        $class1id = $_M['form']['id'];
        $class2 = array();

        $option = '';
        foreach ($this->module as $key => $val) {
            foreach ($val['class2'] as $k => $v) {
                if($v['bigclass'] == $class1id ){
                    $class2[$k] = $v;
                    $option .= "<option value='{$v['id']}'>{$v['name']}</option>";
                }
            }
        }
        echo $option;
        die();
    }

    public function do_get_class3()
    {
        global $_M;
        $class1id = $_M['form']['id'];
        $class3 = array();

        $option = '';
        foreach ($this->module as $key => $val) {
            foreach ($val['class3'] as $k => $v) {
                if($v['bigclass'] == $class1id ){
                    $class3[$k] = $v;
                    $option .= "<option value='{$v['id']}'>{$v['name']}</option>";
                }
            }
        }
        #dump($class3);
        echo $option;
        die();
    }

    public function dowatermark()
    {
        global $_M;
        $class1 = $_M['form']['class1'];
        $class2 = $_M['form']['class2'];
        $class3 = $_M['form']['class3'];
        $type = $_M['form']['type'];

        if (!$class1) {
            $rejson = ['code'=>'1','message'=>$_M[word][dataerror]];
            echo json_encode($rejson,JSON_UNESCAPED_UNICODE);
            die();
        }

        $query = "select * from {$_M['table']['column']} where id='{$class1}'";
        $remark = DB::get_one($query);
        $module_name = self::get_colnum_name($remark['module']);
        $module_code = $remark['module'];
        $resql="class1='$class1'";
        $resql.=$class2?" and class2='$class2'":"";
        $resql.=$class3?" and class3='$class3'":"";

        $query = "select * from {$_M['table'][$module_name]} where $resql and (recycle='0' or recycle='-1')";
        $renow=DB::get_all($query);

        if ($type == 'addwm') {
            $this->addwatermark($renow ,$module_name );
        }elseif($type == 'delwm'){
            $this->delwatermark($renow ,$module_name );
        } elseif ($type == 'addthumb') {
            $this->addthumb($renow ,$module_code );
        }
        die();
    }

    /**
     * 添加水印
     * @param $renow array 栏目数字
     * @param $module_name string 模块名称
     */
    public function addwatermark($renow ,$module_name)
    {
        global $_M;
        $quantity = 0;
        foreach ($renow as $value) {
            $query = "select * from {$_M[table]['parameter']} where lang='{$_M[lang]}' and module='$module_name' and (class1='$value[class1]' or class1=0) and type='5'";
            $para_list = DB::get_all($query);

            $query="select * from {$_M[table][$module_name]} where id='{$value['id']}'";
            $item = DB::get_all($query);

            foreach ($item as $row => $val) {
                if($_M['config']['met_big_wate']==1){
                    /*原图水印*/
                    if ($val['imgurl'] != '' && !strstr($val['imgurl'], 'watermark')) {
                        $imgurlwm = $this->waterbigimg($value['imgurl']);
                    }
                    /*展示图片*/
                    if ($val['displayimg']!='' && !strstr($val['displayimg'], 'watermark')) {
                        $displayurl=explode("|",$val['displayimg']);
                        foreach($displayurl as $key1=>$val1){
                            $displayurls[]=explode("*",$val1);
                        }
                        foreach ($displayurls as $pathitem) {
                            $displaywm = $this->waterbigimg($pathitem[1]);
                            $displayimgwm = str_replace($pathitem[1], $displaywm, $val['displayimg']);
                        }
                    }
                    /*内容详情图片*/
                    if($val['content']!=''&&!strstr($val['content'], 'watermark')){
                        $rearr =  $this->form_imglist($val, $module_name);
                        $contentwm = $rearr['content'];
                        $contentwm1 = $rearr['content1'];
                        $contentwm2 = $rearr['content2'];
                        $contentwm3 = $rearr['content3'];
                        $contentwm4 = $rearr['content4'];
                    }
                }

                $sql1 = $imgurlwm ? ",`imgurl` = '$imgurlwm'" : '';
                $sql2 = $displayimgwm ? ",`displayimg` = '$displayimgwm'" : '';
                $sql3 = $contentwm ? ",`content` = '$contentwm'" : '';
                $sql4 = $contentwm1 ? ",`content1` = '$contentwm1'" : '';
                $sql5 = $contentwm2 ? ",`content2` = '$contentwm2'" : '';
                $sql6 = $contentwm3 ? ",`content3` = '$contentwm3'" : '';
                $sql7 = $contentwm4 ? ",`content4` = '$contentwm4'" : '';
                $sql = trim($sql1.$sql2.$sql3.$sql4.$sql5.$sql6.$sql7,',');
                #dump($sql);

                if ($sql) {
                    $query = "UPDATE {$_M['table'][$module_name]} SET $sql WHERE `id` = {$val['id']}";
                    $res = DB::query($query);
                    //更新记录条数
                    $res ? $quantity++ : '';
                }

            }
        }
        $rejson = ['code'=>'0','message'=>$quantity];
        echo json_encode($rejson,JSON_UNESCAPED_UNICODE);
        die();
    }

    /**
     * 取消水印
     * @param $renow array 栏目数字
     * @param $module_name string 模块名称
     */
    public function delwatermark($renow ,$module_name)
    {
        global $_M;
        $quantity = 0;
        foreach ($renow as $value) {
            $query = "select * from {$_M[table]['parameter']} where lang='{$_M[lang]}' and module='$module_name' and (class1='$value[class1]' or class1=0) and type='5'";
            $para_list = DB::get_all($query);

            $query="select * from {$_M[table][$module_name]} where id='{$value['id']}'";
            $item = DB::get_all($query);

            foreach ($item as $row => $val) {
                if($_M['config']['met_big_wate']==1){
                    /*原图水印*/
                    if ($val['imgurl'] != '' && strstr($val['imgurl'], 'watermark')) {
                        $imgurl = str_replace('watermark/', '', $val['imgurl']);
                    }

                    /*展示图片*/
                    if ($val['displayimg']!=''&&strstr($val['displayimg'], 'watermark')) {
                        $displayimg = str_replace('watermark/', '', $val['displayimg']);
                    }

                    /*内容详情图片*/
                    if($val['content']!=''&&strstr($val['content'], 'watermark')){
                        $content = str_replace('watermark/', '', $val['content']);
                    }
                    if($val['content1']!=''&&strstr($val['content1'], 'watermark')){
                        $content1 = str_replace('watermark/', '', $val['content1']);
                    }
                    if($val['content2']!=''&&strstr($val['content2'], 'watermark')){
                        $content2 = str_replace('watermark/', '', $val['content2']);
                    }
                    if($val['content3']!=''&&strstr($val['content3'], 'watermark')){
                        $content3 = str_replace('watermark/', '', $val['content3']);
                    }
                    if($val['content4']!=''&&strstr($val['content4'], 'watermark')){
                        $content4 = str_replace('watermark/', '', $val['content4']);
                    }
                }

                $sql1 = $imgurl ? ",`imgurl` = '$imgurl'" : '';
                $sql2 = $displayimg ? ",`displayimg` = '$displayimg'" : '';
                $sql3 = $content ? ",`content` = '$content'" : '';
                $sql4 = $content1 ? ",`content1` = '$content1'" : '';
                $sql5 = $content2 ? ",`content2` = '$content2'" : '';
                $sql6 = $content3 ? ",`content3` = '$content3'" : '';
                $sql7 = $content4 ? ",`content4` = '$content4'" : '';
                $sql = trim($sql1.$sql2.$sql3.$sql4.$sql5.$sql6.$sql7,',');
                #dump($sql);


                if ($sql) {
                    $query = "UPDATE {$_M['table'][$module_name]} SET $sql WHERE `id` = {$val['id']}";
                    $res = DB::query($query);
                    //更新记录条数
                    $res ? $quantity++ : '';
                    $quantity = $res ? $quantity++ : $quantity;
                }
            }
        }
        $rejson = ['code'=>'0','message'=>$quantity];
        echo json_encode($rejson,JSON_UNESCAPED_UNICODE);
        die();
    }

    /**
     * 缩略图生成
     * @param  string  $filePath    原图路径
     * @return array                缩略图路径
     */
    public function thumbimg($filePath, $module){
        global $_M;
        $thumb = load::sys_class('thumb', 'new');
        $thumb->list_module($module);
        $ret = $thumb->createthumb($filePath);
        return $ret['path'];
    }

    /**
     * 大图水印
     * @param  string  $filePath    原图路径
     * @return array                大图水印路径
     */
    public function waterbigimg($filePath){
        global $_M;
        $this->watermark->set_system_bigimg();
        $ret = $this->watermark->create($filePath);
        #dump($ret);
        return $ret['path'];
    }

    /**
     * 缩略图水印
     * @param  string  $filePath    缩略图路径
     * @return array                缩略图水印路径
     */
    public function waterthumbimg($filePath){
        global $_M;
        $this->watermark->set_system_thumb();
        $ret = $this->watermark->create($filePath);
        return $ret['path'];
    }

    /**
     * 处理图片
     * @param  string  $list   数据数组
     * @return array           处理完的图片后的数据数组
     */
    public function form_imglist($list, $module){
        global $_M;
        $imglist = explode("|",$list['imgurl']);
        $imgsizes=explode("|",$list['imgsizes']);//增加图片尺寸变量（新模板框架v2）
        $i=0;
        $list['displayimg'] = '';
        foreach($imglist as $val){
            if($val!='' || $j==1)$i++;
            if(1){
                $list['imgurlr'] = str_replace('watermark/', '',$val);

                if($_M['config']['met_autothumb_ok'] != 1){
                    $list['imgurl'] = $this->waterbigimg($list['imgurlr']);

                }else{
                    $list['imgurl'] = $list['imgurlr'];
                }

                if($_M['config']['met_big_wate'] == 1 )
                {
                    $list['imgurl'] = $this->waterbigimg($list['imgurlr']);
                }else{
                    $list['imgurl'] = $list['imgurlr'];
                }
                if($list['imgurlr']!=str_replace('thumb/', '',$list['imgurl_l']) && $_M['config']['met_autothumb_ok'] == 1){

                    $list['imgurls'] = $this->thumbimg($list['imgurlr'], $module);
                }else{
                    $list['imgurls'] = $list['imgurl_l'];
                }

                if($_M['config']['met_autothumb_ok'] == 1 && $_M['config']['met_thumb_wate'] == 1 ){
                    $list['imgurls'] = $this->waterthumbimg($list['imgurls']);
                }else{
                    $list['imgurls'] = $list['imgurlr'];
                    //$list['imgurl'] = $val;
                }

                if($i==1){
                    $j=1;
                    if(strstr($val,'../')){
                        $img=explode('/',$imglist[$i]);
                        $imglast=$img[count($img)-1];
                        $imglist[$i]= str_replace('watermark/', '',$imglist[$i]);
                        if($imglist[0]!=''){
                            $imglist[$i]=str_replace('watermark/', '',$imglist[0]);
                            $img=explode('/',$imglist[$i]);
                            $imglast=$img[count($img)-1];
                        }
                        if($_M['config']['met_autothumb_ok'] == 1 && $_M['config']['met_big_wate']!=1 && $_M['config']['met_thumb_wate']!=1 ){
                            $imgurls= str_replace($imglast,'thumb/'.$imglast,$imglist[$i]);
                            $imgurl =$imglist[$i];
                        }elseif($_M['config']['met_autothumb_ok'] == 1 && $_M['config']['met_thumb_wate']!=1 && $_M['config']['met_big_wate']==1){
                            $imgurls=  str_replace($imglast,'thumb/'.$imglast,$imglist[$i]);
                            $imgurl=   str_replace($imglast,'watermark/'.$imglast,$imglist[$i]);
                        }elseif($_M['config']['met_autothumb_ok'] != 1 && $_M['config']['met_thumb_wate']!=1 && $_M['config']['met_big_wate']!=1){
                            $imgurls='';
                            $imgurl= $imglist[$i];
                        }elseif($_M['config']['met_autothumb_ok'] != 1  && $_M['config']['met_big_wate']==1){
                            $imgurls= '';
                            $imgurl=  str_replace($imglast,'watermark/'.$imglast,$imglist[$i]);
                        }elseif($_M['config']['met_autothumb_ok'] == 1 && $_M['config']['met_thumb_wate']==1 && $_M['config']['met_big_wate']==1){
                            $imgurls=  str_replace($imglast,'thumb/'.$imglast,$imglist[$i]);
                            $imgurl=  str_replace($imglast,'watermark/'.$imglast,$imglist[$i]);
                        }elseif($_M['config']['met_autothumb_ok'] == 1 && $_M['config']['met_big_wate']!=1 && $_M['config']['met_thumb_wate']==1) {
                            $imgurls=  str_replace($imglast,'thumb/'.$imglast,$imglist[$i]);
                            $imgurl= $imglist[$i];
                        }else{
                            $imgurls= '';
                            $imgurl= $imglist[$i];
                        }
                    }else{
                        $imgurls= '';
                        $imgurl= $val;
                    }

                }
                if(!strstr($val,'../')){//说明是外部图片
                    $list['imgurl']=$val;
                }
                $list['imgsize']=$imgsizes[$i-1];//增加图片尺寸值（新模板框架v2）
                $lt = $list['title'].'*'.$list['imgurl'].'*'.$imgsizes[$i-1];//
                if($i==1){
                    $lt='';
                }
                $list['displayimg'].= count($imglist)==$i?$lt:$lt.'|';
            }

        }

        if($_M['config']['met_big_wate'] == 1){
            $list['content'] = $this->concentwatermark($list['content']);
            if($list['content1'])$list['content1'] = $this->concentwatermark($list['content1']);
            if($list['content2'])$list['content2'] = $this->concentwatermark($list['content2']);
            if($list['content3'])$list['content3'] = $this->concentwatermark($list['content3']);
            if($list['content4'])$list['content4'] = $this->concentwatermark($list['content4']);
        }
        $str=substr($list['displayimg'],'0','1');
        if($str=='|'){
            $length=strlen($list['displayimg']);
            $list['displayimg']=substr($list['displayimg'],1,$length);
        }
        // dump($list['displayimg']);
        // exit;
        $list['imgurls']= $imgurls;
        $list['imgurl']= $imgurl;
        return $list;
    }

    /**
     * 处理内容中的图片
     * @param  string  $str    内容html
     * @return array           处理完的图片后的html
     */
    function concentwatermark($str){
        if(preg_match_all('/<img.*?src="(.*?)".*?>/i', $str, $out)){
            foreach($out[1] as $key=>$val){
                $imgurl  = explode("upload/", $val);
                if($imgurl[1]){
                    $list['imgurl_now'] = 'upload/'.$imgurl[1];
                    $list['imgurl_original'] = 'upload/'.str_replace('watermark/', '',$imgurl[1]);
                    if(file_exists(PATH_WEB.$list['imgurl_original']))$imgurls[] = $list;
                }
            }
            foreach($imgurls as $key=>$val){
                $watermarkurl = str_replace('../', '',$this->waterbigimg($val['imgurl_original']));
                $str = str_replace($val['imgurl_now'], $watermarkurl, $str);
            }
        }
        return $str;
    }


    function dobatchthumb()
    {
        global $_M;
        #nav::select_nav(2);
        #dump($this->module[1]);
        $class1 = array();
        foreach ($this->module as $key => $val) {
            foreach ($val['class1'] as $k => $v) {
                if(in_array($v['module'],array(1,2,3,4,5)))
                    $class1[$k] = $v;
            }
        }
        #dump($class1);
        require $this->template('own/thumb');
    }


    public static function get_colnum_name($module)
    {
        switch($module){
            case 1:
                $moduledb='column';
                break;
            case 2:
                $moduledb='news';
                break;
            case 3:
                $moduledb='product';
                break;
            case 4:
                $moduledb='download';
                break;
            case 5:
                $moduledb='img';
                break;
            case 6:
                $moduledb='job';
                break;
        }
        return $moduledb;
    }
}
