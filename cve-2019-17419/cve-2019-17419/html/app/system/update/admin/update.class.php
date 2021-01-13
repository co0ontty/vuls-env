<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::sys_class('admin');

class update extends admin{
    public $appno;
    public $appname;
    public $appver;
    public $apptables;

    public function __construct()
    {
        global $_M;
        parent::__construct();
        $this->appno = 10043;
        $this->appname = 'shop';
        $this->appver = '4.0.0';
        //$sql = file_get_contents(__DIR__ . "/{$this->appname}_{$this->appver}_{$this->appno}_mysql.json");
        /*#die("{$this->appname}_{$this->appver}_{$this->appno}_mysql.json");
        $res = DB::get_all("SHOW FULL TABLES ");
        foreach ($res as $row) {
            if(strstr($row['Tables_in_met6_1'], 'met_shop'))
            $arr[] = $row['Tables_in_met6_1'];
        }
        var_export($arr);*/

        $tables = array(
            0 => 'shopv2_address',
            1 => 'shopv2_card',
            2 => 'shopv2_cart',
            3 => 'shopv2_converse',
            4 => 'shopv2_discount',
            5 => 'shopv2_discount_coupon',
            6 => 'shopv2_favorite',
            7 => 'shopv2_finance',
            8 => 'shopv2_goods_relation',
            9 => 'shopv2_goods_spec',
            10 => 'shopv2_goods_spec_value',
            11 => 'shopv2_goods_splist',
            12 => 'shopv2_group_discount',
            13 => 'shopv2_logistics',
            14 => 'shopv2_logistics_zone',
            15 => 'shopv2_order',
            16 => 'shopv2_order_goods',
            17 => 'shopv2_order_statistics',
            18 => 'shopv2_para',
            19 => 'shopv2_plist',
            20 => 'shopv2_product',
            21 => 'shopv2_searchlist',
            22 => 'shopv2_searchlist_tag',
            23 => 'shopv2_tracking',
            24 => 'shopv2_user',
            25 => 'shopv2_zone'
        );

        $this->apptables = $tables;

    }

    public function doindex()
    {
        global $_M;
        $query = "show tables";
        $res = DB::query($query);
        DB::fetch_row($res);
        while ($row = $res->fetch_array(MYSQLI_ASSOC)) {
            $tablename = array_values($row);
            $tablename = $tablename[0];
            if(strstr( $tablename, "{$_M['config']['tablepre']}shopv2_")){
                $tables[] = str_replace($_M['config']['tablepre'],'',$tablename);
            }
        }
        $diffarr = array_diff($this->apptables,$tables);
        foreach ($diffarr as $table) {
            if (in_array($table, $this->apptables)) {
                $newtables[] = $table;
            }
        }

        foreach ($this->apptables as $table) {
            $query = "desc {$_M['table'][$table]}";
            $res = DB::get_all($query);
        }
    }

    public function dogetTablesjson()
    {
        global $_M;
        foreach ($this->apptables as $table) {
            #$query = "desc {$_M['table'][$table]}";
            $query = "SHOW FULL FIELDS FROM {$_M['table'][$table]}";
            $res = DB::get_all($query);
            $col = array();
            foreach ($res as $row) {
                $col[$row['Field']] = $row;
            }
            $tables[$table] = $col;

        }
        $tables = json_encode($tables, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
        $time = time();
        file_put_contents(__DIR__ . "/{$this->appname}_{$this->appver}_{$this->appno}_mysql_new.json", $tables);
        die();
    }

    /**
     * 升级商城
     */
    public function update()
    {
        global $_M;
        foreach ($this->apptables as $table) {
            add_table($table);
        }
        //更新表
        $this->checkTable();
        //app 版本更新
        $this->updateAppVer();
        //更新规格
        $this->updateSpec();
        //更新规格商品
        $this->updateSplist();
        //更新shop_paraList
        $this->updateProductParaList();
        //写入商城配置
        $this->addConfig();
        //更新商城配置
        $this->updataConfig();
        //设置应用插件
        $this->setPlugin();
        //设置左侧导航栏
        $this->setLeftNAV();
        //添加地区
        $this->setZone();
        //添加后台语言
        $this->setAdminLang();
        //添加前台语言
        $this->setWebLang();

    }

    /**
     * 检测数据表
     */
    public function checkTable()
    {
        global $_M;
        $res = DB::get_all("SHOW TABLES ");
        $tables = array();
        foreach ($res as $row) {
            $tablename = array_values($row);
            $tablename = $tablename[0];
            if(strstr( $tablename, "{$_M['config']['tablepre']}shopv2_")){
                $tables[] = str_replace($_M['config']['tablepre'],'',$tablename);
            }
        }

        //检查表
        $difftable = array_diff($this->apptables,$tables);
        foreach ($difftable as $table) {
            if (in_array($table, $this->apptables)) {
                $newtables[] = $table;
                $this->createTable($table);
            }
        }

        //检查字段
        foreach ($tables as $table) {
            $this->alterTable($table);
        }

    }

    /**
     * 创建数据不表
     * @param $tname
     */
    public function createTable($tname)
    {
        global $_M;
        $tablesql = file_get_contents(__DIR__ . "/sql/{$this->appname}_{$this->appver}_{$this->appno}_mysql.json");
        $tablesql = jsondecode($tablesql);

        $sql = "CREATE TABLE IF NOT EXISTS `{$_M['config']['tablepre']}{$tname}` (";
        foreach ($tablesql[$tname] as $key => $val) {
            $val['Default'] = $val['Default'] ? $val['Default'] : 'NULL';
            if($val['Key']=="PRI"){
                $sql .= " `{$key}` {$val['Type']} {$val['Extra']} , ";
            }else{
                $sql .= " `{$key}` {$val['Type']} DEFAULT {$val['Default']} {$val['Extra']} , ";
            }
            if($val['Key']=="PRI"){
                $pri = $val['Field'];
            }
        }
        $sql .= " PRIMARY KEY (`{$pri}`)) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";
        DB::query($sql);
        #dump($sql);
    }

    /**
     * 检测字段
     * @param $tname 表名
     */
    public function alterTable($tname)
    {
        global $_M;
        $tablesql = file_get_contents(__DIR__ . "/sql/{$this->appname}_{$this->appver}_{$this->appno}_mysql.json");
        $tablesql = jsondecode($tablesql);
        $tablenew = $tablesql[$tname];
        foreach ($tablenew as $row) {
            $fieldnew[$row['Field']] = $row['Field'];
        }

        $query    = "SHOW FULL FIELDS FROM {$_M['table'][$tname]}";
        $oldtable = DB::get_all($query);
        foreach ($oldtable as $row) {
            $fieldold[$row['Field']] = $row['Field'];
            $tableold[$row['Field']] = $row;
        }
        $oldtable = $fieldold;

        $diff_field = array_diff($fieldnew, $fieldold);
        foreach ($diff_field as $val) {
            $this->alterTableField($val,$tname ,$tablenew[$val]);
        }
    }

    /**
     * 添加字段
     * @param $fieldname    字段名
     * @param $tname        表明
     * @param $tablenew     新数据表结构信息
     */
    public function alterTableField($fieldname, $tname , $tablenew)
    {
        global $_M;
        $sql = "ALTER TABLE `{$_M['config']['tablepre']}{$tname}` ADD COLUMN `{$fieldname}` ";
        $tablenew['Default'] = $tablenew['Default'] ? $tablenew['Default'] : 'NULL';
        $sql .= " {$tablenew['Type']} DEFAULT {$tablenew['Default']} {$tablenew['Extra']}  ";
        DB::query($sql);
        #dump($sql);
    }

    /**
     * 更新app版本号
     */
    public function updateAppVer()
    {
        global $_M;
        $query = "UPDATE {$_M['table']['applist']} SET `ver`='{$this->appver}',`mlangok`='1' WHERE `no`='{$this->appno}' ";
        DB::query($query);
    }

    /**
     * 更新商品规格
     */
    public function updateSpec()
    {
        global $_M;
        $query = "SELECT * FROM {$_M['table']['shopv2_para']}";
        $paralist = DB::get_all($query);
        foreach ($paralist as $key => $value) {
            $query = "SELECT * FROM {$_M['config']['tablepre']}shopv2_goods_spec WHERE `name`='{$value['value']}' AND `lang`='{$_M['lang']}'";
            if (!$res = DB::get_one($query)) {
                $query = "INSERT INTO {$_M['config']['tablepre']}shopv2_goods_spec SET `name`='{$value['value']}',`lang`='{$_M['lang']}'";
                DB::query($query);
                $spec_id = DB::insert_id();
            }else{
                $spec_id = $res['id'];
            }
            $this->updateSpecVal($spec_id, $value['valuelist']);
        }
    }

    /**
     * 更新规格值
     * @param $spec_id          规格ID
     * @param $spec_val_list    规格值列表
     */
    public function updateSpecVal($spec_id, $spec_val_list)
    {
        global $_M;
        $spec_val_list = explode(',', $spec_val_list);
        foreach ($spec_val_list as $spec_val) {
            $query = "SELECT * FROM {$_M['config']['tablepre']}shopv2_goods_spec_value WHERE `spec_id`='{$spec_id}' AND `value`='{$spec_val}' AND `lang`='{$_M['lang']}'";
            if (!$res = DB::get_one($query)) {
                $query = "INSERT INTO {$_M['config']['tablepre']}shopv2_goods_spec_value SET `spec_id`='{$spec_id}',`value`='{$spec_val}',`lang`='{$_M['lang']}'";
                DB::query($query);
            }
        }
    }

    /**
     * 更新商品规格存储方式
     * plist -> splist
     */
    public function updateSplist()
    {
        global $_M;
        $query = "SELECT * FROM {$_M['table']['shopv2_plist']}";
        $plist = DB::get_all($query);
        foreach ($plist as $val) {
                $query = " INSERT INTO {$_M['config']['tablepre']}shopv2_goods_splist SET 
                 `pid`='{$val['pid']}',
                 `price`='{$val['price']}',
                 `stock` = '{$val['stock']}',
                 `sales`='{$val['sales']}',
                 `para_img`='{$val['para_img']}',
                 `lang`='{$_M['lang']}' ";
                DB::query($query);
                $splist_id = DB::insert_id();
            $this->updateSpecRelation($val['valuelist'],$val['pid'],$splist_id);
        }
    }

    /**
     * 更新 specrelation信息
     * @param $valuelist  plist规格字符串
     * @param $pid        商品ID
     * @param $splist_id  splist ID
     */
    public function updateSpecRelation($valuelist, $pid, $splist_id)
    {
        global $_M;
        $valuelist = explode(',', $valuelist);
        if($valuelist){
            foreach ($valuelist as $value) {
                $query = "SELECT * FROM {$_M['config']['tablepre']}shopv2_goods_spec_value WHERE `value`='{$value}'";
                $spec_value = DB::get_one($query);
                $query = "INSERT INTO {$_M['config']['tablepre']}shopv2_goods_relation SET 
                  `splist_id`='{$splist_id}',
                  `spec_value_id`='{$spec_value['id']}',
                  `spec_id`='{$spec_value['spec_id']}',
                  `pid`='{$pid}'
                  ";
                DB::query($query);
            }
        }
    }

    /**
     * 更新shop_product数据
     */
    public function updateProductParaList()
    {
        global $_M;
        $query = "SELECT * FROM {$_M['table']['shopv2_product']} WHERE paralist!='' ";
        $shop_product = DB::get_all($query);
        $time = time();
        ##file_put_contents(__DIR__ . "/shopv2_product_{$time}.json",jsonencode($shop_product));
        foreach ($shop_product as $good) {
            ##$para_list = $this->getParaList($good['paralist']);
            ##$para_list = jsonencode($para_list);
            $para_list = $this->getProParaList($good['pid']);
            if ($para_list) {
                $query = "UPDATE {$_M['table']['shopv2_product']} SET `paralist`='{$para_list}' WHERE `pid`='{$good['pid']}'";
                DB::query($query);
            }
        }
    }

    /**
     * 通过 goodsterlation  获取商品新规格
     * @param $paralist    商品规格值
     */
    public function getProParaList($pid)
    {
        global $_M;
        $query = "SELECT `spec_id` FROM {$_M['config']['tablepre']}shopv2_goods_relation WHERE `pid` = '{$pid}' GROUP BY `spec_id` ORDER  BY `spec_id`";
        $spec = DB::get_all($query);
        foreach ($spec as $key => $value) {
            $query = "SELECT `spec_value_id` FROM {$_M['config']['tablepre']}shopv2_goods_relation WHERE `pid` = '{$pid}' AND `spec_id`='{$value['spec_id']}' ORDER BY `spec_value_id`";
            $spec_values = DB::get_all($query);
            $value_id = array();
            foreach ($spec_values as $val) {
                if (!in_array($val['spec_value_id'], $value_id)) {
                    $value_id[] = $val['spec_value_id'];
                }
            }
            $spec[$key]['value_id'] = $value_id;
        }
        if($spec){
            $paralist = jsonencode($spec);
            return $paralist;
        }
    }

    /**
     * 通过Product paralist获取商品新规格
     * @param $paralist    商品规格值
     */
    public function getParaList($paralist)
    {
        global $_M;
        $para_list = jsondecode($paralist);
        $para_list_new = array();
        foreach ($para_list as $key=>$para) {
            $query = "SELECT * FROM {$_M['config']['tablepre']}shopv2_goods_spec WHERE `name`='{$para['value']}'";
            $spec = DB::get_one($query);
            $spec_val = $this->getParaVal($spec['id'],$para['valuelist']);

            $para_list_new[$key] = array('spec_id' => $spec['id'],'value_id'=>$spec_val);
        }
        return $para_list_new;
    }

    /**
     * 获取商品规格值
     * @param $para_val  商品规格值
     */
    public function getParaVal($spec_id, $valuelist)
    {
        global $_M;
        $para_values = explode(',',$valuelist);
        foreach ($para_values as $pvalue) {
            $query = "SELECT * FROM {$_M['config']['tablepre']}shopv2_goods_spec_value WHERE 
                      `spec_id` = '{$spec_id}' AND 
                      `value` = '{$pvalue}' AND 
                      `lang` = '{$_M['lang']}'";
            $spec_val = DB::get_one($query);
            $spec_val_list[] = $spec_val['id'];
        }
        return $spec_val_list;
    }

    /**
     * 添加配置文件
     */
    public function addConfig()
    {
        global $_M;
        $this->app_config_insert('shopv2_onlinepay', '1');
        $this->app_config_insert('shopv2_deliverypay', '0');
        $this->app_config_insert('shopv2_gi', '0');
        $this->app_config_insert('shopv2_vat', '0');
        $this->app_config_insert('shopv2_ei', '0');
        $this->app_config_insert('shopv2_invoice','');
        $this->app_config_insert('shopv2_open', '1');
        $this->app_config_insert('shopv2_order_end', '1440');
        $this->app_config_insert('shopv2_order_close', '10080');
        $this->app_config_insert('shopv2_adminemail','');
        $this->app_config_insert('shopv2_admintel','');
        $this->app_config_insert('shopv2_usmsv1', '您的订单已经下单成功，请在30分钟内付款，超过30分钟订单将被关闭！');
        $this->app_config_insert('shopv2_usmsv2', '您的订单已经付款成功，我们将会及时安排时间为您发货！');
        $this->app_config_insert('shopv2_usmsv3', '您的订单已经发货，请注意收货！');
        $this->app_config_insert('shopv2_is_usmsv1', '0');
        $this->app_config_insert('shopv2_is_usmsv2', '0');
        $this->app_config_insert('shopv2_is_usmsv3', '0');
        $this->app_config_insert('shopv2_is_uemailv1', '0');
        $this->app_config_insert('shopv2_is_uemailv2', '0');
        $this->app_config_insert('shopv2_is_uemailv3', '0');
        $this->app_config_insert('shopv2_uemailtv1', '{rid}订单下单成功');
        $this->app_config_insert('shopv2_uemailtv2', '{rid}订单付款成功');
        $this->app_config_insert('shopv2_uemailtv3', '{rid}订单已经发货');
        $this->app_config_insert('shopv2_uemailcv1', '您的订单{rid}已经下单成功，请在30分钟内付款，超过30分钟订单将被关闭！');
        $this->app_config_insert('shopv2_uemailcv2', '尊敬的{user}会员，您的订单{rid}已经付款成功，我们将会及时安排时间为您发货！');
        $this->app_config_insert('shopv2_uemailcv3', '尊敬的{user}会员，您的订单{rid}已经通过{logistics}发货，快递单号：{odd}，请注意收货');
        $this->app_config_insert('shopv2_order_auto_close', '0');
        $this->app_config_insert('shopv2_order_auto_close_time', '90');
        $this->app_config_insert('shopv2_order_auto_ok', '0');
        $this->app_config_insert('shopv2_order_auto_ok_time', '7');
        $this->app_config_insert('shopv2_order_auto_del', '0');
        $this->app_config_insert('shopv2_order_auto_del_time', '30');
        $this->app_config_insert('shopv2_price_str_prefix','￥');
        $this->app_config_insert('shopv2_price_str_suffix', '元');
        // 新加变量
        #$this->app_config_insert('shopv2_express_key', '');
        $this->app_config_insert('shopv2_guest_open', '0');
        $this->app_config_insert('shopv2_logistics_open', '0');
        $this->app_config_insert('shopv2_recommend', '2');
        $this->app_config_insert('shopv2_recommend_num', '5');
        $this->app_config_insert('shopv2_recommend_order', '0');
        $this->app_config_insert('shopv2_moregoods', '1');
        $this->app_config_insert('shopv2_moregoods_num', '12');
        $this->app_config_insert('shopv2_moregoods_order', '0');
        $this->app_config_insert('shopv2_moregoods_order', '0');    //排序规则
        //4.0.0
        $this->app_config_insert('shopv2_price_set', '0');          //价格默认设置方式
        $this->app_config_insert('shopv2_price_refund', '0');       //自助退款
        $this->app_config_insert('shopv2_return_goods', '0');       //退换货
        $this->app_config_insert('shopv2_price_reason', '');        //取消订单原由
        $this->app_config_insert('shopv2_refund_reason', '');       //退换货单原由
        $this->app_config_insert('shopv2_refund_tips', '');         //退换货提示语言
        $this->app_config_insert('shopv2_discount_type_1', '0');    //多件商品打折
        $this->app_config_insert('shopv2_discount_type_2', '0');    //每单固定折扣
        $this->app_config_insert('shopv2_discount_static', '0');    //固定折扣价格
        $this->app_config_insert('shopv2_discount_plan', '0');      //数量折扣
        $this->app_config_insert('shopv2_stock_type', '0');         //未完成订单是否减少库存
        $this->app_config_insert('shopv2_para', '1');               //商城规格搜索开关

    }

    /**
     * 写入app_config
     * @param $name
     * @param $value
     * @param string $lang
     */
    public function app_config_insert($name, $value, $lang = ''){
        global $_M;
        foreach($_M['langlist']['web'] as $key=>$val){
            $query = "SELECT * FROM {$_M['table']['app_config']} WHERE name='{$name}' AND lang='{$val['mark']}'";
            if(!DB::get_one($query)){
                $query = "INSERT INTO {$_M['table']['app_config']} SET name='{$name}',value='{$value}',appno='{$this->appno}' ,lang='{$val['mark']}'";
                DB::query($query);
            }
        }
    }

    /**
     * 更新应用配置
     */
    public function updataConfig()
    {
        global $_M;
        foreach ($_M['langlist']['web'] as $item) {
            $lang = $item['mark'];
            $query = "SELECT * FROM {$_M['table']['config']} WHERE `name` LIKE '%shopv2_%' AND `lang`='{$lang}'";
            $config = DB::get_all($query);

            foreach ($config as $conf) {
                $query = "SELECT * FROM {$_M['table']['app_config']} WHERE `name`='{$conf['name']}' AND lang='{$lang}' AND `appno`='{$this->appno}'";
                if ($res = DB::get_one($query)){
                    if ($res['value'] !== $conf['value']) {
                        $query = "UPDATE {$_M['table']['app_config']} SET `value`='{$conf['value']}' WHERE `name`='{$conf['name']}' AND `lang`='{$lang}'";
                        DB::query($query);
                    }
                }else{
                    $query = "INSERT INTO {$_M['table']['app_config']} SET `appno`='{$this->appno}', `name`='{$conf['name']}',`value`='{$conf['value']}',`lang`='{$lang}'";
                    DB::query($query);
                }
                $query = "DELETE FROM {$_M['table']['config']} WHERE `name`='{$conf['name']}' AND `lang`='{$lang}'";
                DB::query($query);
            }
        }
    }

    /**
     * 应用插件设置
     */
    public function setPlugin()
    {
        global $_M;
        $query = "DELETE FROM {$_M['table']['app_plugin']} WHERE `no`='{$this->appno}'";
        DB::query($query);
        $query = "SELECT * FROM {$_M['table']['app_plugin']} WHERE no='{$this->appno}'";
        if(!DB::get_one($query)){
            $query = "INSERT INTO {$_M['table']['app_plugin']} SET no_order='0',no='{$this->appno}',m_name='shop',m_action='doweb',effect=1";
            DB::query($query);
            $query = "INSERT INTO {$_M['table']['app_plugin']} SET no_order='0',no='{$this->appno}',m_name='shop',m_action='doproduct_list',effect=1";
            DB::query($query);
            $query = "INSERT INTO {$_M['table']['app_plugin']} SET no_order='0',no='{$this->appno}',m_name='shop',m_action='doproduct_show',effect=1";
            DB::query($query);
            $query = "INSERT INTO {$_M['table']['app_plugin']} SET no_order='0',no='{$this->appno}',m_name='shop',m_action='doproduct_plugin_class',effect=1";
            DB::query($query);
            $query = "INSERT INTO {$_M['table']['app_plugin']} SET no_order='0',no='{$this->appno}',m_name='shop',m_action='temporary_plugin_product_list',effect=1";
            DB::query($query);
            $query = "INSERT INTO {$_M['table']['app_plugin']} SET no_order='0',no='{$this->appno}',m_name='shop',m_action='doadmin',effect=1";
            DB::query($query);
            $query = "INSERT INTO {$_M['table']['app_plugin']} SET no_order='0',no='{$this->appno}',m_name='shop',m_action='doseourl',effect=1";
            DB::query($query);
            $query = "INSERT INTO {$_M['table']['app_plugin']} SET no_order='0',no='{$this->appno}',m_name='shop',m_action='dopay',effect=1";
            DB::query($query);
            $query = "INSERT INTO {$_M['table']['app_plugin']} SET no_order='0',no='{$this->appno}',m_name='shop',m_action='doget_goods',effect=1";
            DB::query($query);
            $query = "INSERT INTO {$_M['table']['app_plugin']} SET no_order='0',no='{$this->appno}',m_name='shop',m_action='search_order',effect=1";
            DB::query($query);
            $query = "INSERT INTO {$_M['table']['app_plugin']} SET no_order='0',no='{$this->appno}',m_name='shop',m_action='module_get_list_by_class_query',effect=1";
            DB::query($query);
        }
    }

    /**
     * 用户中心左侧导航栏
     */
    public function setLeftNAV()
    {
        global $_M;
        foreach ($_M['langlist']['web'] as $item) {
            $lang = $item['mark'];
            //会员中心侧导航4.0.0
            $ifmember_left_shop=array(
                array('title'=>'app_shop_mycart','filename'=>'cart.php','own_order'=>0,'target'=>1,'effect'=>1),
                array('title'=>'app_shop_personal','filename'=>'profile.php','own_order'=>1,'target'=>0,'effect'=>1),
                array('title'=>'app_shop_myorder','filename'=>'order.php','own_order'=>2,'target'=>0,'effect'=>1),
                array('title'=>'app_shop_myfavorite','filename'=>'favorite.php','own_order'=>3,'target'=>0,'effect'=>1),
                array('title'=>'app_shop_mydiscount','filename'=>'discount.php','own_order'=>4,'target'=>0,'effect'=>1),
                array('title'=>'app_shop_myaddress','filename'=>'address.php','own_order'=>5,'target'=>0,'effect'=>1),
                #array('title'=>'app_shop_consumption_detail','filename'=>'finance.php','own_order'=>7)
            );
            foreach ($ifmember_left_shop as $value) {
                $query  = "SELECT * FROM {$_M['table']['ifmember_left']} WHERE title='{$value['title']}' AND filename='{$value['filename']}' AND no='{$this->appno}' AND lang = '{$lang}'";
                $result = DB::get_one($query);
                if(!$result) {
                    $query = "INSERT INTO {$_M['table']['ifmember_left']} SET no='{$this->appno}',columnid='0',title='{$value['title']}',foldername='shop',filename='{$value['filename']}',target='{$value['target']}',own_order = '{$value['own_order']}',effect = {$value['effect']},lang='{$lang}'";
                    DB::query($query);
                }
            }
        }
    }

    /**
     * 添加地区
     */
    public function setZone()
    {
        global $_M;
        $content = file_get_contents(__DIR__ . '/sql/shop_zone.sql');
        $this->insertsql($content);
    }

    /**
     * 添加前台语言
     */
    public function setWebLang()
    {
        global $_M;
        foreach ($_M['langlist']['web'] as $lang) {
            $query = "DELETE FROM {$_M['table']['language']} WHERE app = '{$this->appno}' AND site = '0' AND lang = '{$lang['mark']}'";
            #DB::query($query);
            if ($lang['mark'] == 'cn' || $lang['mark'] == 'en') {
                $content = file_get_contents(__DIR__ . "/sql/lang_web_{$this->appno}_{$lang['mark']}.json");
                $content = jsondecode($content);
                $this->lang_insert($content, $lang['mark']);
            }else{
                //其他语种
                $content = file_get_contents(__DIR__ . "/sql/lang_web_{$this->appno}_cn.json");
                $content = jsondecode($content);
                $this->lang_insert($content, $lang['mark']);
            }
        }
        return;
    }

    /**
     * 添加后台语言
     */
    public function setAdminLang()
    {
        global $_M;
        $query = "DELETE FROM {$_M['table']['language']} WHERE `app`='{$this->appno}' AND site='1'";
        DB::query($query);
        foreach ($_M['langlist']['admin'] as $lang) {
            if ($lang['mark'] == 'cn' || $lang['mark'] == 'en') {
                $content = file_get_contents(__DIR__ . "/sql/lang_admin_{$this->appno}_{$lang['mark']}.json");
                $content = jsondecode($content);
                $this->lang_insert($content, $lang['mark']);
            }else{
                //其他语种
                $content = file_get_contents(__DIR__ . "/sql/lang_admin_{$this->appno}_cn.json");
                $content = jsondecode($content, $lang['mark']);
                $this->lang_insert($content, $lang['mark']);

            }
        }
        return;
    }

    public function lang_insert($content , $setlang ='')
    {
        global $_M;
        $i = 0;
            foreach ($content as $lang) {
                $lang['lang'] = $setlang ? $setlang : $lang['lang'];
                $query = "SELECT * FROM {$_M['table']['language']} WHERE name='{$lang['name']}' AND site='{$lang['site']}' AND lang='{$lang['lang']}' AND array='{$lang['array']}' AND app='{$this->appno}'";
                $res = DB::get_one($query);
                if(!$res){
                    $value = addslashes($lang['value']);
                    $query = "INSERT INTO {$_M['table']['language']} SET name='{$lang['name']}',value='{$value}', site='{$lang['site']}',no_order=0,array='{$lang['array']}',app='{$this->appno}',lang='{$lang['lang']}'";
                    DB::query($query);
                    $i++;
                }
            }
    }

    /**
     * 执行sql文件
     * @param $content
     */
    public function insertsql($content)
    {
        global $_M;
        if($content) {
            $sql=explode("\n",$content);
            foreach ($sql as $query) {
                if ($query!=='' && !strstr($query,'##')) {
                    $query = str_replace('met_',$_M['config']['tablepre'],$query);
                    DB::query($query);
                }
            }
        }
        return;
    }

    /**
     * test method
     */
    public function dotest()
    {
        global $_M;
    }




}
