<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::sys_class('admin');

/**
 * 使用说明
 * 1 将文件放入上传至  wwwroot/app/system/update/admin 目录.
 * 2 访问 域名/后台目录/index.php?n=update&c=uptools&a=docheck
 * 3 根据说明手动调用升级方法
 * 4 删除该文件
 */
class uptools extends admin
{
    private $version;

    public function __construct()
    {
        global $_M;
        parent::__construct();
        $this->version = '7.0.0beta';
    }

    public function docheck()
    {
        global $_M;
        $query = "SELECT * FROM {$_M['table']['config']} WHERE name = 'metcms_v'";
        $metcms_v = DB::get_one($query);
        if ($metcms_v['value']=='7.0.0beta' && $_M['form']['to']!='to') {
            #echo "版本7.0.0beta 不可再次升级<br><hr>";
            #return;
        }

        echo "<br>版本{$metcms_v['value']}<br><hr>";
        echo "<a href='{$_M['url']['own_form']}a=doupdata&action=diff_fields'>数据表对比</a><br><hr>";
        echo "<a href='{$_M['url']['own_form']}a=doupdata&action=table_regist'>注册数据表</a><br><hr>";
        echo "<a href='{$_M['url']['own_form']}a=doupdata&action=update_admin_column'>更新后台栏目</a><br><hr>";
        echo "<a href='{$_M['url']['own_form']}a=doupdata&action=add_config'>添加配置</a><br><hr>";
        echo "<a href='{$_M['url']['own_form']}a=doupdata&action=recovery_column'>更新栏目数据</a><br><hr>";
        echo "<a href='{$_M['url']['own_form']}a=doupdata&action=recovery_form_seting'>更新表单栏目数据</a><br><hr>";
        echo "<a href='{$_M['url']['own_form']}a=doupdata&action=recovery_online'>更新客服数据</a><br><hr>";
        echo "<a href='{$_M['url']['own_form']}a=doupdata&action=recovery_link'>更新友情连接数据</a><br><hr>";
        echo "<a href='{$_M['url']['own_form']}a=doupdata&action=recovery_news'>更新新闻数据</a><br><hr>";
        echo "<a href='{$_M['url']['own_form']}a=doupdata&action=update_app_list'>更新applist</a><br><hr>";
        echo "<a href='{$_M['url']['own_form']}a=doupdata&action=update_tags'>更新tags数据</a><br><hr>";
        echo "<a href='{$_M['url']['own_form']}a=doupdata&action=update_language'>更新语言(修复后台语言丢失问题)</a><br><hr>";
        echo "<a href='{$_M['url']['own_form']}a=doupdata&action=updata_version'>更新系统版本号</a><br><hr>";
        echo "<br><br><span>升级错误修复<span><hr>";
        if ($metcms_v['value']=='7.0.0beta') {
            echo "<a href='{$_M['url']['own_form']}a=doupdata&action=job_repair'>修复招聘数据(修复升级后添加招聘职位在和后台不显示的问题)</a><br><hr>";
        }
        echo "<a href='{$_M['url']['own_form']}a=doupdata&action=template_repair'>修复默认模板配置不显示</a><br><hr>";

    }

    /**
     * 执行升级操作
     */
    public function doupdata()
    {
        global $_M;
        $version = '7.0.0beta';
        $action = $_M['form']['action'];
        switch ($action) {
            case 'diff_fields'://数据表对比
                self::diff_fields($version);
                echo 'complete';
                break;
            case 'table_regist'://注册数据表
                self::table_regist();
                echo 'complete';
                break;
            case 'update_admin_column'://更新后台栏目
                self::update_admin_column();
                echo 'complete';
                break;
            case 'add_config'://添加配置
                self::add_config();
                echo 'complete';
                break;
            case 'recovery_column'://更新栏目数据
                self::recovery_column();
                echo 'complete';
                break;
            case 'recovery_form_seting'://更新表单栏目数据
                self::recovery_form_seting();
                echo 'complete';
                break;
            case 'recovery_online'://更新客服数据
                self::recovery_online();
                echo 'complete';
                break;
            case 'recovery_link'://更新友情链接数据
                self::recovery_link();
                echo 'complete';
                break;
            case 'recovery_news'://更新新闻数据
                self::recovery_news();
                echo 'complete';
                break;
            case 'update_app_list'://更新applist
                self::update_app_list();
                echo 'complete';
                break;
            case 'update_tags'://更新tags数据
                self::update_tags();
                echo 'complete';
                break;
            case 'update_language'://更新语言
                self::update_language($version);
                echo 'complete';
                break;
            case 'updata_version'://更新语言
                self::updata_version();
                echo 'complete';
                break;
            case 'job_repair'://修复招聘数据
                self::job_repair();
                echo 'complete';
                break;
            case 'template_repair'://修复默认模板配置不显示
                self::template_repair();
                echo 'complete';
                break;
        }
    }


    /**
     * 对比数据库机构
     * @param $version
     */
    public function diff_fields($version)
    {
        global $_M;
        $app = load::sys_class('app','new');
        $app->version = $version;
        $diffs = $app->get_diff_tables(PATH_WEB.'config/v'.$version.'mysql.json');
        if(isset($diffs['table'])){
            foreach ($diffs['table'] as $table => $detail) {
                $sql = "CREATE TABLE IF NOT EXISTS `{$table}` (";
                foreach ($detail as $k => $v) {
                    if(!$v['Default'] && !is_numeric($v['Default'])){
                        $v['Default']= 'NULL';
                    }
                    if($k == 'id'){
                        $sql.= "`{$k}` {$v['Type']} {$v['Extra']} ,";
                    }else{
                        $sql.= "`{$k}` {$v['Type']} DEFAULT {$v['Default']} {$v['Extra']} ,";
                    }
                }
                $sql.="PRIMARY KEY (`id`)) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";
                DB::query($sql);
                add_table(str_replace($_M['config']['tablepre'], '', $table));
            }
        }

        if(isset($diffs['field']))
        {
            foreach ($diffs['field'] as $table => $v) {
                foreach ($v as $field => $f) {
                    $sql = "ALTER TABLE `{$table}` ADD COLUMN `{$field}`  {$f['Type']}";
                    if($f['Default'] != '') {
                        $sql .= " Default '{$f['Default']}'";
                    }
                    DB::query($sql);
                }
            }
        }
    }

    /**
     * 注册数据表
     */
    public function table_regist()
    {
        global $_M;
        add_table('flash_button');
        add_table('tags');
        add_table('admin_logs');
        add_table('menu');
    }

    /**
     * 备份用户临时数据
     * @return array
     */
    public function temp_data()
    {
        global $_M;

        $data = array();
        $data['met_secret_key'] = $_M['config']['met_secret_key'];
        $data['last_version']   = $_M['config']['metcms_v'];
        $data['tablename']      = $_M['config']['met_tablename'];

        $query = "SELECT * FROM {$_M['table']['applist']}";
        $data['applist'] = DB::get_all($query);

        //用户数据缓存
        Cache::put('temp_data',$data);
        return $data;
    }

    /**
     * 恢复用户数据
     */
    public function recovery_data()
    {
        global $_M;
        if(file_exists(PATH_WEB.'cache/temp_data.php')){
            $data = Cache::get('temp_data');
            add_table($data['tablename']);

            //恢复注册数据表
            $query = "SELECT value FROM {$_M['table']['config']} WHERE name = 'met_tablename'";
            $config = DB::get_one($query);
            $_Mettables = explode('|', $config['value']);
            foreach ($_Mettables as $key => $val) {
                $_M['table'][$val] = $_M['config']['tablepre'].$val;
            }

            //恢复用户TOKEN
            $query = "UPDATE {$_M['table']['config']} SET value = '{$data['met_secret_key']}' WHERE name = 'met_secret_key'";
            DB::query($query);

            //恢复系统版本呢
            $query = "UPDATE {$_M['table']['config']} SET value = '{$data['last_version']}' WHERE name = 'metcms_v'";
            DB::query($query);


            //恢复应用列表数据
            foreach ($data['applist'] as $app) {
                $query = "SELECT id FROM {$_M['table']['applist']} WHERE m_name='{$app['m_name']}'";
                if(!DB::get_one($query) && file_exists(PATH_WEB.'app/app/'.$app['m_name'])){
                    unset($app['id']);
                    $sql = self::get_sql($app);
                    $query = "INSERT INTO {$_M['table']['applist']} SET {$sql}";
                    DB::query($query);
                }
            }
        }


        //删除临时数据文件
        Cache::del('temp_data');
    }

    /**
     * 表单模块数据迁移
     */
    public function recovery_form_seting()
    {
        global $_M;
        //job
        foreach (array_keys($_M['langlist']['web']) as $lang) {
            //栏目初始化
            ###$this->colum_label ->get_column($lang);

            $query = "SELECT * FROM {$_M['table']['column']} WHERE lang = '{$lang}' AND module = 6";
            $jobs = DB::get_all($query);
            if ($jobs) {
                foreach ($jobs as $job) {
                    self::recovery_job($job, $lang);
                }
            }

            //message
            $query = "SELECT * FROM {$_M['table']['column']} WHERE lang = '{$lang}' AND module = 7";
            $message = DB::get_one($query);
            if ($message) {
                self::recovery_message($message, $lang);
            }


            //feedback
            $query = "SELECT * FROM {$_M['table']['column']} WHERE lang = '{$lang}' AND module = 8";
            $feedbacks = DB::get_all($query);
            if ($feedbacks) {
                foreach ($feedbacks as $fd) {
                    self::recovery_feedback($fd, $lang);
                }
            }
        }
    }

    /**
     * 更新job配置
     */
    public function recovery_job($data = array(), $lang = '')
    {
        global $_M;
        file_put_contents(PATH_WEB . 'update_logs.txt',"recovery_job\n",FILE_APPEND);
        if($data && $lang){
            //跟新内容层级关系
            #$class123 = self::getClass123($data['id'], $lang);
            #$query = "UPDATE {$_M['table']['job']} SET class1 = '{$class123['class1']['id']}' , class2 = '{$class123['class2']['id']}', class3 = '{$class123['class3']['id']}'";
            $query = "UPDATE {$_M['table']['job']} SET class1 = '{$data['id']}' , class2 = '0', class3 = '0' WHERE lang = '{$lang}'";
            DB::query($query);

            //更新表单配置
            $array = array();
            $array[] = array('met_cv_time', '120');
            $array[] = array('met_cv_image', '');
            $array[] = array('met_cv_showcol', '');
            $array[] = array('met_cv_emtype', '1');
            $array[] = array('met_cv_type', '');
            $array[] = array('met_cv_to', '');
            $array[] = array('met_cv_job_tel', '');
            $array[] = array('met_cv_back', '');
            $array[] = array('met_cv_email', '');
            $array[] = array('met_cv_title', '');
            $array[] = array('met_cv_content', '');
            $array[] = array('met_cv_sms_back', '');
            $array[] = array('met_cv_sms_tell', '');
            $array[] = array('met_cv_sms_content', '');

            $column_config = self::getClassConfig($data['id']);

            foreach ($array as $row) {
                $name = $row[0];
                $value = $column_config[$name] ? $column_config[$name] : $row[1];
                $cid = $data['id'];
                $lang = $data['lang'];
                self::update_config($name, $value, $cid, $lang);
            }

            //删除无用配置
            $query = "DELETE FROM {$_M['table']['config']} WHERE name LIKE '%met_cv%' AND lang = '{$data['lang']}' AND columnid = '0'";
            DB::query($query);
        }
        return;
    }

    /**
     * 更新message配置
     */
    public function recovery_message($data = array(), $lang = '')
    {
        global $_M;
        file_put_contents(PATH_WEB . 'update_logs.txt',"recovery_message\n",FILE_APPEND);
        if ($data && $lang) {
            $array = array();
            $array[] = array('met_msg_ok', '');
            $array[] = array('met_msg_time', '120');
            $array[] = array('met_msg_name_field', '');
            $array[] = array('met_msg_content_field', '');
            $array[] = array('met_msg_show_type', '1');
            $array[] = array('met_msg_type', '1');
            $array[] = array('met_msg_to', '');
            $array[] = array('met_msg_admin_tel', '');
            $array[] = array('met_msg_back', '');
            $array[] = array('met_msg_email_field', '');
            $array[] = array('met_msg_title', '');
            $array[] = array('met_msg_content', '');
            $array[] = array('met_msg_sms_back', '');
            $array[] = array('met_msg_sms_field', '');
            $array[] = array('met_msg_sms_content', '');

            $column_config = self::getClassConfig($data['id']);

            foreach ($array as $row) {
                $name = $row[0];
                $value = $column_config[$name] ? $column_config[$name] : $row[1];
                $cid = $data['id'];
                $lang = $data['lang'];
                self::update_config($name, $value, $cid, $lang);
            }
        }
    }

    /**
     * 更新feedback配置
     */
    public function recovery_feedback($data = array(), $lang = '')
    {
        global $_M;
        file_put_contents(PATH_WEB . 'update_logs.txt',"recovery_feedback\n",FILE_APPEND);
        if ($data && $lang) {
            $column = self::getClassById($data['id'], $lang);
            $met_fdtable = $column['name'];     //反馈表单名称

            $array = array();
            $array[] = array('met_fd_ok', '');
            $array[] = array('met_fdtable', $met_fdtable);
            ###$array[] = array('met_fd_class', '');
            $array[] = array('met_fd_time', '120');
            $array[] = array('met_fd_related', '');
            $array[] = array('met_fd_showcol', '');
            $array[] = array('met_fd_inquiry', '');
            $array[] = array('met_fd_type', '');
            $array[] = array('met_fd_to', '');
            $array[] = array('met_fd_admin_tel', '');
            $array[] = array('met_fd_back', '');
            $array[] = array('met_fd_email', '');
            $array[] = array('met_fd_title', '');
            $array[] = array('met_fd_content', '');
            $array[] = array('met_fd_sms_back', '');
            $array[] = array('met_fd_sms_tell', '');
            $array[] = array('met_fd_sms_content', '');

            $column_config = self::getClassConfig($data['id']);

            foreach ($array as $row) {
                $name = $row[0];
                $value = $column_config[$name] ? $column_config[$name] : $row[1];
                $cid = $data['id'];
                $lang = $data['lang'];
                self::update_config($name, $value, $cid, $lang);
            }
        }
    }

    /**
     * 更新online数据
     */
    public function recovery_online()
    {
        global $_M;
        /*if(file_exists(PATH_WEB.'cache/temp_online.php')){
            $data = Cache::get('temp_online');
        }*/

        $query = "SELECT * FROM {$_M['table']['online']}";
        $data = DB::get_all($query);

        //清空online表
        ##$query = "TRUNCATE TABLE {$_M['table']['online']} ";
        $query = "DELETE FROM {$_M['table']['online']} ";
        DB::query($query);
        $query = "ALTER TABLE `{$_M['table']['online']}` 
                    DROP COLUMN `qq`,
                    DROP COLUMN `msn`,
                    DROP COLUMN `taobao`,
                    DROP COLUMN `alibaba`,
                    DROP COLUMN `skype`;
                    ";
        DB::query($query);

        foreach (array_keys($_M['langlist']['web']) as $lang) {
            //客服默认样式
            self::update_config('met_online_skin', 3, 0, $lang);
            //插入新客服数据
            self::onlineInsert($data, $lang);
        }
        return;
    }

    /**
     * 插入新客服数据
     * @param array $online_list
     * @param string $lang
     */
    private function onlineInsert($online_list = array(),$lang = '')
    {
        global $_M;
        foreach ($online_list as $online) {
            if ($online['lang'] == $lang) {
                if ($online['qq']) {
                    $name = $online['name'];
                    $no_order = $online['no_order'];
                    $value = $online['qq'];
                    $icon = 'icon fa-qq';
                    $type = '0';
                    $query = "INSERT INTO {$_M['table']['online']} (name,no_order,lang,value,icon,type) VALUES ('{$name}','{$no_order}','{$lang}','{$value}','{$icon}','{$type}')";
                    DB::query($query);
                }
                if ($online['msn']) {
                    $name = $online['name'];
                    $no_order = $online['no_order'];
                    $value = $online['sms'];
                    $icon = 'icon fa-facebook';
                    $type = '6';
                    $query = "INSERT INTO {$_M['table']['online']} (name,no_order,lang,value,icon,type) VALUES ('{$name}','{$no_order}','{$lang}','{$value}','{$icon}','{$type}')";
                    DB::query($query);
                }
                if ($online['taobao']) {
                    $name = $online['name'];
                    $no_order = $online['no_order'];
                    $value = $online['taobao'];
                    $icon = 'icon fa-comment';
                    $type = '1';
                    $query = "INSERT INTO {$_M['table']['online']} (name,no_order,lang,value,icon,type) VALUES ('{$name}','{$no_order}','{$lang}','{$value}','{$icon}','{$type}')";
                    DB::query($query);
                }
                if ($online['alibaba']) {
                    $name = $online['name'];
                    $no_order = $online['no_order'];
                    $value = $online['alibaba'];
                    $icon = 'icon fa-comment';
                    $type = '2';
                    $query = "INSERT INTO {$_M['table']['online']} (name,no_order,lang,value,icon,type) VALUES ('{$name}','{$no_order}','{$lang}','{$value}','{$icon}','{$type}')";
                    DB::query($query);
                }
                if ($online['skype']) {
                    $name = $online['name'];
                    $no_order = $online['no_order'];
                    $value = $online['skype'];
                    $icon = 'icon fa-skype';
                    $type = '5';
                    $query = "INSERT INTO {$_M['table']['online']} (name,no_order,lang,value,icon,type) VALUES ('{$name}','{$no_order}','{$lang}','{$value}','{$icon}','{$type}')";
                    DB::query($query);
                }

            }
        }
    }

    /**
     * 更新友情链接数据
     */
    public function recovery_link()
    {
        global $_M;
        $query = "UPDATE {$_M['table']['link']} SET module = ',10001,'";
        DB::query($query);

    }

    /**
     * 更新友情链接数据
     */
    public function recovery_news()
    {
        global $_M;
        $query = "SELECT * FROM {$_M['table']['news']}";
        $news_list = DB::get_all($query);
        foreach ($news_list as $news) {
            if ($news['issue']) {
                $query = "UPDATE {$_M['table']['news']} SET publisher = '{$news['issue']}' WHERE id = {$news['id']}";
                DB::query($query);
            }
        }
        return;
    }

    /**
     * 更新栏目数据
     */
    public function recovery_column()
    {
        global $_M;
        foreach (array_keys($_M['langlist']['web']) as $lang) {
            $query = "SELECT * FROM {$_M['table']['column']} WHERE lang = '{$lang}' ";
            $column_list = DB::get_all($query);
            foreach ($column_list as $column) {
                if ($column['module'] == 2) {
                    $list_length = $_M['config']['met_news_list'];
                }
                if ($column['module'] == 3) {
                    $list_length = $_M['config']['met_product_list'];
                }
                if ($column['module'] == 4) {
                    $list_length = $_M['config']['met_download_list'];
                }
                if ($column['module'] == 5) {
                    $list_length = $_M['config']['met_img_list'];
                }
                if ($column['module'] == 6) {
                    $list_length = $_M['config']['met_job_list'];
                }
                if ($column['module'] == 7) {
                    $list_length = $_M['config']['met_message_list'];
                }
                if ($column['module'] == 11) {
                    $list_length = $_M['config']['met_search_list'];
                }

                $list_length = $list_length ? $list_length : 8;

                $query = "UPDATE {$_M['table']['column']} SET list_length = '{$list_length}' WHERE id = {$column['id']}";
                DB::query($query);

            }
        }


    }

    /**
     * 更新语言
     */
    public function update_language($version)
    {
        global $_M;
        //添加管理员语言
        $query = "SELECT * FROM {$_M['table']['lang_admin']} WHERE lang = 'cn' AND mark = 'cn'";
        $res = DB::get_one($query);
        if (!$res) {
            $query = "INSERT INTO {$_M['table']['lang_admin']} SET name = '简体中文', useok = 1, no_order = 1, mark = 'cn', synchronous = 'cn',  link = '', lang = 'cn')";
            DB::query($query);
        }

        foreach (array_keys($_M['langlist']['web']) as $lang) {
            //语言
            if ($lang != 'en') {
                $json_sql = "https://www.metinfo.cn/upload/json/v{$version}lang_cn.json";
                $lang_json = file_get_contents($json_sql);
            }else{
                $json_sql = "https://www.metinfo.cn/upload/json/v{$version}lang_en.json";
                $lang_json = file_get_contents($json_sql);
            }

            $lang_json = json_decode($lang_json, true);
            if (is_array($lang_json)) {
                $sql = "DELETE FROM {$_M['table']['language']} WHERE lang = '{$lang}' AND  site = 1 AND (app = 0 OR app = 1 OR app = 50002)";
                DB::query($sql);
                foreach ($lang_json as $row) {
                    self::add_language($row);
                }
            }
        }
    }

    /**
     * 更新后台栏目数据
     */
    public function update_admin_column()
    {
        global $_M;
        $admin_array = self::admin_array();
        if (is_array($admin_array)) {
            //清空老数据表
            #$query = "TRUNCATE TABLE {$_M['table']['admin_column']} ";
            $query = "DELETE FROM {$_M['table']['admin_column']} ";
            DB::query($query);

            foreach ($admin_array as $row) {
                $sql = get_sql($row);
                $query = "INSERT INTO {$_M['table']['admin_column']} SET {$sql}";
                DB::query($query);
            }
        }
    }

    /**
     * @return array
     */
    protected function admin_array()
    {
        global $_M;
        $admin_array = array(
            0 =>
                array(
                    'id' => '1',
                    'name' => 'lang_administration',
                    'url' => 'manage',
                    'bigclass' => '0',
                    'field' => '1301',
                    'type' => '1',
                    'list_order' => '0',
                    'icon' => 'manage',
                    'info' => '',
                    'display' => '1',
                ),
            1 =>
                array(
                    'id' => '2',
                    'name' => 'lang_htmColumn',
                    'url' => 'column',
                    'bigclass' => '0',
                    'field' => '1201',
                    'type' => '1',
                    'list_order' => '1',
                    'icon' => 'column',
                    'info' => '',
                    'display' => '1',
                ),
            2 =>
                array(
                    'id' => '3',
                    'name' => 'lang_feedback_interaction',
                    'url' => '',
                    'bigclass' => '0',
                    'field' => '1202',
                    'type' => '1',
                    'list_order' => '2',
                    'icon' => 'feedback-interaction',
                    'info' => '',
                    'display' => '1',
                ),
            3 =>
                array(
                    'id' => '4',
                    'name' => 'lang_seo_set_v6',
                    'url' => 'seo',
                    'bigclass' => '0',
                    'field' => '1404',
                    'type' => '1',
                    'list_order' => '3',
                    'icon' => 'seo',
                    'info' => '',
                    'display' => '1',
                ),
            4 =>
                array(
                    'id' => '5',
                    'name' => 'lang_appearance',
                    'url' => 'app/met_template',
                    'bigclass' => '0',
                    'field' => '1405',
                    'type' => '1',
                    'list_order' => '4',
                    'icon' => 'template',
                    'info' => '',
                    'display' => '1',
                ),
            5 =>
                array(
                    'id' => '6',
                    'name' => 'lang_myapp',
                    'url' => 'myapp',
                    'bigclass' => '0',
                    'field' => '1505',
                    'type' => '1',
                    'list_order' => '5',
                    'icon' => 'application',
                    'info' => '',
                    'display' => '1',
                ),
            6 =>
                array(
                    'id' => '7',
                    'name' => 'lang_the_user',
                    'url' => '',
                    'bigclass' => '0',
                    'field' => '1506',
                    'type' => '1',
                    'list_order' => '6',
                    'icon' => 'user',
                    'info' => '',
                    'display' => '1',
                ),
            7 =>
                array(
                    'id' => '8',
                    'name' => 'lang_safety',
                    'url' => '',
                    'bigclass' => '0',
                    'field' => '0',
                    'type' => '1',
                    'list_order' => '7',
                    'icon' => 'safety',
                    'info' => '',
                    'display' => '1',
                ),
            8 =>
                array(
                    'id' => '9',
                    'name' => 'lang_multilingual',
                    'url' => 'language',
                    'bigclass' => '0',
                    'field' => '1002',
                    'type' => '1',
                    'list_order' => '8',
                    'icon' => 'multilingualism',
                    'info' => '',
                    'display' => '1',
                ),
            9 =>
                array(
                    'id' => '10',
                    'name' => 'lang_unitytxt_39',
                    'url' => '',
                    'bigclass' => '0',
                    'field' => '0',
                    'type' => '1',
                    'list_order' => '9',
                    'icon' => 'setting',
                    'info' => '',
                    'display' => '1',
                ),
            10 =>
                array(
                    'id' => '11',
                    'name' => 'cooperation_platform',
                    'url' => 'partner',
                    'bigclass' => '0',
                    'field' => '1508',
                    'type' => '1',
                    'list_order' => '10',
                    'icon' => 'partner',
                    'info' => '',
                    'display' => '1',
                ),
            11 =>
                array(
                    'id' => '21',
                    'name' => 'lang_mod8',
                    'url' => 'feed_feedback_8',
                    'bigclass' => '3',
                    'field' => '1509',
                    'type' => '2',
                    'list_order' => '0',
                    'icon' => 'feedback',
                    'info' => '',
                    'display' => '1',
                ),
            12 =>
                array(
                    'id' => '22',
                    'name' => 'lang_mod7',
                    'url' => 'feed_message_7',
                    'bigclass' => '3',
                    'field' => '1510',
                    'type' => '2',
                    'list_order' => '1',
                    'icon' => 'message',
                    'info' => '',
                    'display' => '1',
                ),
            13 =>
                array(
                    'id' => '23',
                    'name' => 'lang_mod6',
                    'url' => 'feed_job_6',
                    'bigclass' => '3',
                    'field' => '1511',
                    'type' => '2',
                    'list_order' => '2',
                    'icon' => 'recruit',
                    'info' => '',
                    'display' => '1',
                ),
            14 =>
                array(
                    'id' => '24',
                    'name' => 'lang_customerService',
                    'url' => 'online',
                    'bigclass' => '3',
                    'field' => '1106',
                    'type' => '2',
                    'list_order' => '3',
                    'icon' => 'online',
                    'info' => '',
                    'display' => '1',
                ),
            15 =>
                array(
                    'id' => '25',
                    'name' => 'lang_indexlink',
                    'url' => 'link',
                    'bigclass' => '4',
                    'field' => '1406',
                    'type' => '2',
                    'list_order' => '0',
                    'icon' => 'link',
                    'info' => '',
                    'display' => '0',
                ),
            16 =>
                array(
                    'id' => '26',
                    'name' => 'lang_member',
                    'url' => 'user',
                    'bigclass' => '7',
                    'field' => '1601',
                    'type' => '2',
                    'list_order' => '0',
                    'icon' => 'member',
                    'info' => '',
                    'display' => '1',
                ),
            17 =>
                array(
                    'id' => '27',
                    'name' => 'lang_managertyp2',
                    'url' => 'admin/user',
                    'bigclass' => '7',
                    'field' => '1603',
                    'type' => '2',
                    'list_order' => '1',
                    'icon' => 'administrator',
                    'info' => '',
                    'display' => '1',
                ),
            18 =>
                array(
                    'id' => '28',
                    'name' => 'lang_safety_efficiency',
                    'url' => 'safe',
                    'bigclass' => '8',
                    'field' => '1004',
                    'type' => '2',
                    'list_order' => '0',
                    'icon' => 'safe',
                    'info' => '',
                    'display' => '1',
                ),
            19 =>
                array(
                    'id' => '29',
                    'name' => 'lang_data_processing',
                    'url' => 'databack',
                    'bigclass' => '8',
                    'field' => '1005',
                    'type' => '2',
                    'list_order' => '1',
                    'icon' => 'databack',
                    'info' => '',
                    'display' => '1',
                ),
            20 =>
                array(
                    'id' => '30',
                    'name' => 'lang_upfiletips7',
                    'url' => 'webset',
                    'bigclass' => '10',
                    'field' => '1007',
                    'type' => '2',
                    'list_order' => '0',
                    'icon' => 'information',
                    'info' => '',
                    'display' => '1',
                ),
            21 =>
                array(
                    'id' => '31',
                    'name' => 'lang_indexpic',
                    'url' => 'imgmanage',
                    'bigclass' => '10',
                    'field' => '1003',
                    'type' => '2',
                    'list_order' => '1',
                    'icon' => 'picture',
                    'info' => '',
                    'display' => '1',
                ),
            22 =>
                array(
                    'id' => '32',
                    'name' => 'lang_banner_manage',
                    'url' => 'banner',
                    'bigclass' => '10',
                    'field' => '1604',
                    'type' => '2',
                    'list_order' => '2',
                    'icon' => 'banner',
                    'info' => '',
                    'display' => '1',
                ),
            23 =>
                array(
                    'id' => '33',
                    'name' => 'lang_the_menu',
                    'url' => 'menu',
                    'bigclass' => '10',
                    'field' => '1605',
                    'type' => '2',
                    'list_order' => '3',
                    'icon' => 'bottom-menu',
                    'info' => '',
                    'display' => '1',
                ),
            24 =>
                array(
                    'id' => '34',
                    'name' => 'lang_checkupdate',
                    'url' => 'update',
                    'bigclass' => '37',
                    'field' => '1104',
                    'type' => '2',
                    'list_order' => '4',
                    'icon' => 'update',
                    'info' => '',
                    'display' => '0',
                ),
            25 =>
                array(
                    'id' => '35',
                    'name' => 'lang_appinstall',
                    'url' => 'appinstall',
                    'bigclass' => '6',
                    'field' => '1800',
                    'type' => '2',
                    'list_order' => '0',
                    'icon' => 'appinstall',
                    'info' => '',
                    'display' => '0',
                ),
            26 =>
                array(
                    'id' => '36',
                    'name' => 'lang_dlapptips6',
                    'url' => 'appuninstall',
                    'bigclass' => '6',
                    'field' => '1801',
                    'type' => '2',
                    'list_order' => '0',
                    'icon' => 'appuninstall',
                    'info' => '',
                    'display' => '0',
                ),
            27 =>
                array(
                    'id' => '37',
                    'name' => 'lang_top_menu',
                    'url' => 'top_menu',
                    'bigclass' => '0',
                    'field' => '1900',
                    'type' => '1',
                    'list_order' => '0',
                    'icon' => 'top_menu',
                    'info' => '',
                    'display' => '0',
                ),
            28 =>
                array(
                    'id' => '38',
                    'name' => 'lang_clearCache',
                    'url' => 'clear_cache',
                    'bigclass' => '37',
                    'field' => '1901',
                    'type' => '2',
                    'list_order' => '0',
                    'icon' => 'clear_cache',
                    'info' => '',
                    'display' => '0',
                ),
            29 =>
                array(
                    'id' => '39',
                    'name' => 'lang_funcCollection',
                    'url' => 'function_complete',
                    'bigclass' => '37',
                    'field' => '1902',
                    'type' => '2',
                    'list_order' => '0',
                    'icon' => 'function_complete',
                    'info' => '',
                    'display' => '0',
                ),
            30 =>
                array(
                    'id' => '40',
                    'name' => 'lang_environmental_test',
                    'url' => 'environmental_test',
                    'bigclass' => '37',
                    'field' => '1903',
                    'type' => '2',
                    'list_order' => '0',
                    'icon' => 'environmental_test',
                    'info' => '',
                    'display' => '0',
                ),
            31 =>
                array(
                    'id' => '41',
                    'name' => 'lang_navSetting',
                    'url' => 'navSetting',
                    'bigclass' => '6',
                    'field' => '1904',
                    'type' => '2',
                    'list_order' => '0',
                    'icon' => 'navSetting',
                    'info' => '',
                    'display' => '0',
                ),
            32 =>
                array(
                    'id' => '42',
                    'name' => 'lang_style_settings',
                    'url' => 'style_settings',
                    'bigclass' => '5',
                    'field' => '1905',
                    'type' => '2',
                    'list_order' => '0',
                    'icon' => 'style_settings',
                    'info' => '',
                    'display' => '0',
                ),
        );
        return $admin_array;
    }

    /**
     * 更新applist
     */
    public function update_app_list()
    {
        global $_M;
        $query = "UPDATE {$_M['table']['applist']} SET display = '1' WHERE no = '50002'";
        DB::query($query);
    }

    /**
     * 更新系统配置
     */
    public function add_config()
    {
        global $_M;
        foreach (array_keys($_M['langlist']['web']) as $lang) {
            //shearch
            self::update_config('global_search_range', 'all', 0, $lang);
            self::update_config('global_search_type', '0', 0, $lang);
            self::update_config('global_search_module', '2', 0, $lang);
            self::update_config('global_search_column', '3', 0, $lang);
            self::update_config('column_search_range', 'parent', 0, $lang);
            self::update_config('column_search_type', '0', 0, $lang);
            self::update_config('advanced_search_range', 'all', 0, $lang);
            self::update_config('advanced_search_type', '1', 0, $lang);
            self::update_config('advanced_search_column', '3', 0, $lang);
            self::update_config('advanced_search_linkage', '1', 0, $lang);
            //tags
            self::update_config('tag_show_range', '0', 0, $lang);
            self::update_config('tag_show_number', '4', 0, $lang);
            self::update_config('tag_search_type', 'module', 0, $lang);
            //logs
            self::update_config('met_logs', '0', 0, 'metinfo');
            //logo
            self::update_config('met_logo_keyword', "{$_M['config']['met_webname']}", 0, $lang);


            if ($lang == 'cn') {
                self::update_config('met_data_null', '没有找到数据', 0, $lang);
                self::update_config('met_404content', '404错误，页面不见了。。。', 0, $lang);
            }else{
                self::update_config('met_404content', '404 error, the page is gone. . .', 0, $lang);
                self::update_config('met_data_null', 'The page is gone', 0, $lang);
            }
        }

        //global
        self::update_config('met_api', 'https://u.mituo.cn/api/client', 0, 'metinfo');
        self::update_config('met_301jump', '0', 0, 'metinfo');
        self::update_config('disable_cssjs', '0', 0, 'metinfo');
        self::update_config('met_uiset_guide', '1', 0, 'metinfo');
    }

    /**
     * tags数据迁移
     */
    public function update_tags()
    {
        global $_M;

        $tags = load::sys_class('label', 'new')->get('tags');
        $modules = array(2 => 'news', 3 => 'product', 4 => 'download', 5 => 'img');
        foreach ($modules as $mod => $table) {
            $query = "SELECT * FROM {$_M['table'][$table]} WHERE tag != '' AND tag IS NOT NULL AND recycle = 0";
            $list = DB::get_all($query);
            foreach ($list as $v) {
                if (!trim($v['tag'])) {
                    continue;
                }
                $tagStr = $v['tag'];
                $_M['lang'] = $v['lang'];
                $tags->updateTags($tagStr, $mod, $v['class1'], $v['id'], 1);
            }
        }
    }

    /**
     * 更新版本号
     */
    public function updata_version()
    {
        global $_M;
        $query = "UPDATE {$_M['table']['config']} SET value = '{$this->version}' WHERE name = 'metcms_v'";
        DB::query($query);
        return;
    }

    /***********************/
    // 模板导入演示数据之后调用了这里，如果还有其他操作数据处理可以继续追加
    public function update_shop()
    {
        global $_M;

        if($_M['table']['shopv2_product']){
            $shop_update = load::mod_class('update/admin/update','new');
            $shop_update->update();

            $pay_update = load::mod_class('update/admin/updatepay','new');
            $pay_update->update();

            self::check_shop();
        }
    }

    public function check_shop()
    {
        global $_M;
        if(!file_exists(PATH_WEB.'shop')){
            $query = "DELETE FROM {$_M['table']['applist']} WHERE no = '10043'";
            DB::query($query);

            $query = "DELETE FROM {$_M['table']['app_config']} WHERE appno = 10043";
            DB::query($query);

            $query = "DELETE FROM {$_M['table']['app_plugin']} WHERE no = 10043";
            DB::query($query);
        }

        if(!file_exists(PATH_WEB.'pay')){
            $query = "DELETE FROM {$_M['table']['applist']} WHERE no = 10080";
            DB::query($query);
            $query = "DELETE FROM {$_M['table']['app_config']} WHERE appno = 10080";
            DB::query($query);
            $query = "DELETE FROM {$_M['table']['pay_config']}";
            DB::query($query);
        }
    }

    /*****************************工具方法******************************/
    /**
     * 更新配置
     * @param $name
     * @param $value
     * @param $cid
     * @param $lang
     */
    public function update_config($name,$value,$cid,$lang)
    {
        global $_M;
        $query = "SELECT id FROM {$_M['table']['config']} WHERE  name='{$name}' AND lang = '{$lang}'";
        $config = DB::get_one($query);
        if(!$config){
            $query = "INSERT INTO {$_M['table']['config']} (name,value,mobile_value,columnid,flashid,lang)VALUES ('{$name}', '{$value}', '', '{$cid}', '0', '{$lang}')";
            DB::query($query);
        }else{
            $query = "UPDATE {$_M['table']['config']} SET name = '{$name}',value = '{$value}', columnid = '{$cid}' ,lang = '{$lang}' WHERE id = '{$config['id']}'";
            DB::query($query);
        }
    }

    /**
     * 更新 插入语言
     * @param array $lang_data
     */
    public function add_language($lang_data = array())
    {
        global $_M;
        $name = $lang_data['name'];
        $value = $lang_data['value'];
        $site = $lang_data['site'];
        $lang = $lang_data['lang'];
        $js = $lang_data['array'] ? 1 : 0;
        $app = $lang_data['app'];

        if ($site == 1) {
            $query = "INSERT INTO {$_M['table']['language']} SET name = '{$name}',value='{$value}',site = '{$site}',no_order = 0,array='{$js}', app = '{$app}', lang='{$lang}';";
            DB::query($query);
        }

        /*$query = "SELECT * FROM {$_M['table']['language']} WHERE name = '{$name}' AND site = '{$site}'  AND lang = '{$lang}'";
        $has = DB::get_one($query);
        #file_put_contents(PATH_WEB . 'lang_select_sql.txt', "{$query}\n", FILE_APPEND);
        if(!$has){
            $query = "INSERT INTO {$_M['table']['language']} SET name = '{$name}',value='{$value}',site = '{$site}',no_order = 0,array='{$js}', app = '{$app}', lang='{$lang}'";
            DB::query($query);
            #file_put_contents(PATH_WEB . 'lang_add_sql.txt', "{$query}\n", FILE_APPEND);
        }else{
            if ($site == 1) {
                $query = "UPDATE {$_M['table']['language']} SET value='{$value}' WHERE name = '{$has['name']}' AND site = '{$site}' AND lang='{$lang}'";
                DB::query($query);
                #file_put_contents(PATH_WEB . 'lang_update_sql.txt', "{$query}\n", FILE_APPEND);
            }
        }*/
        return;
    }

    /**
     * 获取sql
     * @param $data
     * @return string
     */
    public function get_sql($data) {
        global $_M;
        $sql = "";
        foreach ($data as $key => $value) {
            if(strstr($value, "'")){
                $value = str_replace("'", "\'", $value);
            }
            $sql .= " {$key} = '{$value}',";
        }
        return trim($sql,',');
    }

    /**
     * 获取三级栏目信息
     */
    public function getClass123($cid = '', $lang = '')
    {
        global $_M;
        $classnow = self::getClassById($cid, $lang);

        $return = array();
        if ($classnow) {
            if ($classnow['classtype'] == 1) {
                $return['class1'] = $classnow;
                $return['class2'] = array();
                $return['class3'] = array();
            }

            if ($classnow['classtype'] == 2) {
                $return['class1'] = self::getClassById($classnow['bigclass'],$lang);
                $return['class2'] = $classnow;
                $return['class3'] = array();
            }

            if ($classnow['classtype'] == 3) {
                $bigclass = self::getClassById($classnow['bigclass'],$lang);
                $return['class1'] = self::getClassById($bigclass['bigclass'],$lang);
                $return['class2'] = $bigclass;
                $return['class3'] = $classnow;
            }
            return $return;
        }
        return false;
    }

    /**
     * 获取特定栏目信息
     * @param string $cid
     * @param string $lang
     * @return array|bool
     */
    public function getClassById($cid = '', $lang = '')
    {
        global $_M;
        if ($cid && $lang) {
            $query = "SELECT * FROM {$_M['table']['column']} WHERE lang = '{$lang}' AND id = '{$cid}'";
            $class = DB::get_one($query);
            return $class;
        }
        return false;
    }

    /**
     * 获取栏目配置
     * @param $class_id
     * @return array
     */
    public function getClassConfig($class_id = '')
    {
        global $_M;
        $query = "SELECT * FROM {$_M['table']['config']} WHERE columnid = '{$class_id}'";
        $config_list = DB::get_all($query);
        $list = array();
        foreach($config_list as $key => $val){
            $list[$val['name']] = $val['value'];
        }
        return $list;
    }

    /*****************************数据错误修复******************************/
    public function job_repair()
    {
        global $_M;
        $sql = "ALTER TABLE `{$_M['table']['job']}` MODIFY COLUMN `class1` int(11) DEFAULT 0";
        DB::query($sql);
        $sql = "ALTER TABLE `{$_M['table']['job']}` MODIFY COLUMN `class2` int(11) DEFAULT 0";
        DB::query($sql);
        $sql = "ALTER TABLE `{$_M['table']['job']}` MODIFY COLUMN `class3` int(11) DEFAULT 0";
        DB::query($sql);

        foreach (array_keys($_M['langlist']['web']) as $lang) {
            $query = "SELECT * FROM {$_M['table']['job']} WHERE lang = '{$lang}'";
            $job_list = DB::get_all($query);
            foreach ($job_list as $job) {
                $class = self::getClassById($job['class1'], $lang);
                if ($class['module']!=6) {
                    $query = "UPDATE {$_M['table']['job']} SET class1 = '{$job['class2']}',class2 = '0',class3 = '0' WHERE id = '{$job['id']}'";
                    DB::query($query);
                }else{
                    $query = "UPDATE {$_M['table']['job']} SET class1 = '{$job['class1']}'";
                    if (!$job['class2']) {
                        $query .= ",class2 = '0'";
                    }else{
                        $query .= ",class2 = '{$job['class2']}'";
                    }
                    if (!$job['class3']) {
                        $query .= ",class3 = '0'";
                    }else{
                        $query .= ",class3 = '{$job['class3']}'";
                    }
                    $query .= " WHERE id = '{$job['id']}'";
                    DB::query($query);
                }

            }
        }

        return;
    }

    /*
     * 修复默认模板配置不显示的问题
     */
    public function template_repair()
    {
        global $_M;
        if ($_M['config']['tablepre'] != 'tem_') {
            $per = $_M['config']['tablepre'];
            $sql = "SELECT * FROM {$_M['table']['templates']} WHERE name LIKE '{$per}%'";
            $list = DB::get_all($sql);
            foreach ($list as $row) {
                $new_name = str_replace($per, 'met_', $row['name']);
                $sql = "UPDATE {$_M['table']['templates']} SET name = '{$new_name}' WHERE id = '{$row['id']}'";
                DB::query($sql);
            }

        }
        return;
    }

}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
