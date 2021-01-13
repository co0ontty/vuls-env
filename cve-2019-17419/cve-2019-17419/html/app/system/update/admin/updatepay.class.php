<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::sys_class('admin');

class updatepay extends admin{
    public $appno;
    public $appname;
    public $appver;
    public $apptables;

    public function __construct()
    {
        global $_M;
        parent::__construct();
        /*$this->appno = 10080;
        $this->appname = 'pay';
        $this->appver = '1.0';*/

        $this->appno        = 10080;
        $this->appver       = '1.0';
        $this->appname      = 'pay';
        $this->m_class      = 'admin_pay';
        $this->m_action     = 'dopaylist';
        $this->dopaylist    = 'dofinancelist';
        $this->name         = '支付接口管理';
        $this->info         = '整合市面多种常用支付接口';
        $this->depend       = 'sys';
        $this->mlangok      = 1;
        //$sql = file_get_contents(__DIR__ . "/{$this->appname}_{$this->appver}_{$this->appno}_mysql.json");
        /*#die("{$this->appname}_{$this->appver}_{$this->appno}_mysql.json");
        $res = DB::get_all("SHOW FULL TABLES ");
        foreach ($res as $row) {
            if(strstr($row['Tables_in_met6_1'], 'met_shop'))
            $arr[] = $row['Tables_in_met6_1'];
        }
        var_export($arr);*/

        $tables = array(
            0 => 'pay_balance',
            1 => 'pay_config',
            2 => 'pay_finance',
            3 => 'pay_order',
            4 => 'pay_api'
        );

        $this->apptables = $tables;

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
        //注册表
        foreach ($this->apptables as $table) {
            add_table($table);
        }
        //更新表
        $this->checkTable();
        //消费记录
        $this->moveFinance();
        //用户余额
        $this->moveBalance();
        //Applist
        $this->insertAppList();
        //左侧导航
        $this->setLeftNAV();
        //写入配置
        $this->setCongfig();
        //跟新配置
        $this->updataConfig();
        //更新PayApi
        $this->updatePayApi();
        ///前台语言
        $this->setWebLang();
        //后台语言
        $this->setAdminLang();
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
            if(strstr( $tablename, "{$_M['config']['tablepre']}pay_")){
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
     * 添加applist
     */
    public function insertAppList()
    {
        global $_M;
        $query = "SELECT * FROM {$_M['table']['applist']} WHERE no='{$this->appno}'";
        $result = DB::get_one($query);
        if(!$result) {
            $query = "INSERT INTO  {$_M['table']['applist']} SET no = '{$this->appno}',ver = '0.1',m_name = '{$this->appname}',m_class = '{$this->m_class}',m_action = '{$this->m_action}',appname = '{$this->name }',target='0',info  = '{$this->info }',mlangok = '{$this->mlangok}',depend = '{$this->depend}'";
            DB::query($query);
        }
    }

    /**
     * 财务记录迁移
     */
    public function moveFinance()
    {
        global $_M;
        $query = "SELECT * FROM {$_M['config']['tablepre']}shopv2_finance ";
        $finance = DB::get_all($query);
        foreach ($finance as $value) {
            $query = "SELECT * FROM {$_M['config']['tablepre']}pay_finance WHERE 
                `uid`='{$value['uid']}' AND 
                `addtime`='{$value['addtiom']}'";
            $res = DB::get_one($query);
            if (!$res) {
                $query = "INSERT INTO {$_M['config']['tablepre']}pay_finance SET 
                `uid`='{$value['uid']}',
                `username`='{$value['username']}',
                `appno`='{$this->appno}',
                `type`='{$value['type']}',
                `reason`='{$value['reason']}',
                `price`='{$value['price']}',
                `balance`='{$value['balance']}',
                `addtime`='{$value['addtime']}',
                `adminname`='{$value['adminname']}',
                `lang`='{$value['lang']}' ";
                DB::query($query);
            }
        }
    }

    /**
     * 用户余额迁移
     */
    public function moveBalance()
    {
        global $_M;
        $query = "SELECT * FROM {$_M['config']['tablepre']}shopv2_user ";
        $balance = DB::get_all($query);
        foreach ($balance as $value) {
            $query = "SELECT * FROM {$_M['config']['tablepre']}pay_balance WHERE 
                `uid`='{$value['uid']}' AND 
                `lang`='{$value['lang']}'";
            $res = DB::get_all($query);
            if (!$res) {
                $query = "INSERT INTO {$_M['config']['tablepre']}pay_balance SET 
                `uid`='{$value['uid']}',
                `username`='{$value['username']}',
                `goods_list`='{$value['goods_list']}',
                `balance`='{$value['balance']}',
                `lang`='{$value['lang']}'
                ";
                DB::query($query);
            }
        }
    }

    /**
     * 会员中心侧导航
     * @param string $lang
     */
    public function setLeftNAV()
    {
        global $_M;
        foreach ($_M['langlist']['web'] as $item) {
            $lang = $item['mark'];
            $query = "SELECT * FROM {$_M['table']['ifmember_left']} WHERE no='{$this->appno}' AND foldername='pay' AND title='pay_consumption_detail' AND  filename='finance.php' AND lang='{$lang}'";
            $result = DB::get_one($query);
            if (!$result) {
                $query = "INSERT INTO {$_M['table']['ifmember_left']} SET no='{$this->appno}',columnid='0',title='pay_consumption_detail',foldername='pay',filename='finance.php',target='0',own_order = '1',effect = 1,lang='{$lang}'";
                DB::query($query);
            }
        }
    }

    /**
     * 更改设置
     */
    public function setCongfig()
    {
        global $_M;
        foreach($_M['langlist']['web'] as $key=>$val){
            $lang = $val['mark'];
            $query = "SELECT * FROM {$_M['config']['tablepre']}pay_config WHERE `name`='payment_type' AND `lang`='{$lang}'";
            $res = DB::get_one($query);
            $payment_type = str_replace("|", '#@met@#', $res['value']);
            $this->configinsert('payment_type', $payment_type, $lang);
            $this->configinsert('pay_price_str_prefix', '￥', $lang);
            $this->configinsert('pay_price_str_suffix', '元', $lang);
            $this->configinsert('payment_open', '1', $lang);
            $this->appconfiginsert('payment_open', '1', $lang);
        }
    }

    public function configinsert($name,$value,$lang)
    {
        global $_M;
        $query = "SELECT * FROM {$_M['config']['tablepre']}pay_config WHERE name = '{$name}' AND  lang = '{$lang}'";
        $res = DB::get_one($query);
        if (!$res) {
            $query = "INSERT INTO {$_M['config']['tablepre']}pay_config SET `name`='{$name}', `value`='{$value}' ,lang='{$lang}'";
            DB::query($query);
        }else{
            $query = "UPDATE {$_M['config']['tablepre']}pay_config SET `value`='{$value}' ,lang='{$lang}' WHERE `id`='{$res['id']}'";
            DB::query($query);
        }
    }

    public function appconfiginsert($name,$value,$lang)
    {
        global $_M;
        $query = "SELECT * FROM {$_M['table']['app_config']} WHERE name = '{$name}' AND  lang = '{$lang}'";
        $res = DB::get_one($query);
        if (!$res) {
            $query = "INSERT INTO {$_M['table']['app_config']} SET `appno` ='{$this->appno}', `name`='{$name}', `value`='{$value}' ,lang='{$lang}'";
            DB::query($query);
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
            $query = "SELECT * FROM {$_M['table']['config']} WHERE `name` = 'payment_open' `lang`='{$lang}'";
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
     * 更新PayApy
     */
    public function updatePayApi()
    {
        global $_M;
        $query = "UPDATE {$_M['config']['tablepre']}pay_api SET `lang`='{$_M['config']['met_index_type']}' WHERE `lang`='' ";
        DB::query($query);
        $query = "SELECT * FROM {$_M['table']['config']} WHERE `name`='paypal_config'";
        $res = DB::get_one($query);
        $query = "INSERT INTO {$_M['config']['tablepre']}pay_api SET `name`='paypal_config' ,`paytype`='5' ,`value`='{$res['value']}',`lang`='{$_M['config']['met_index_type']}'";
        DB::query($query);
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
     * test method
     */
    public function dotest()
    {
    }




}
