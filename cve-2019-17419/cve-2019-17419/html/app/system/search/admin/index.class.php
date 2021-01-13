<?php
defined('IN_MET') or exit('No permission');
load::sys_class('admin');
load::sys_func('file');
/** 搜索设置 */
class index extends admin
{
    public function __construct()
    {
        global $_M;
        parent::__construct();
        admin_information();
    }

    //获取设置
    public function doIndex()
    {
        global $_M;

    }

    //获取全站搜索框数据
    public function doGetGlobalSearch()
    {
        global $_M;
        $query = "SELECT * FROM {$_M['table']['language']} WHERE name = 'SearchInfo1' AND lang = '{$_M['lang']}'";
        $lang = DB::get_one($query);
        $data['search_placeholder'] = $lang['value'];
        $data['column'] = load::sys_class('label','new')->get('column')->get_parent_columns();
        return $data;
    }

    //保存全部搜索框数据
    public function doSaveGlobalSearch()
    {
        global $_M;
        $data = array(
            'global_search_range',
            'global_search_type',
            'global_search_module',
            'global_search_column',
        );
        configsave($data, $_M['form']);
        $query = "UPDATE {$_M['table']['language']} SET value = '{$_M['form']['search_placeholder']}' WHERE name = 'SearchInfo1' AND lang = '{$_M['lang']}'";
        DB::query($query);
        buffer::clearConfig();
        $this->success($data, $_M['word']['jsok']);
    }

    public function doGetColumnSearch()
    {
        global $_M;
        $query = "SELECT * FROM {$_M['table']['language']} WHERE name = 'columnSearchInfo' AND lang = '{$_M['lang']}'";
        $lang = DB::get_one($query);
        $data['search_placeholder'] = $lang['value'];
        return $data;
    }

    //保存栏目搜索框数据
    public function doSaveColumnSearch()
    {
        global $_M;
        $data = array(
            'column_search_range',
            'column_search_type'
        );
        configsave($data, $_M['form']);
        $query = "UPDATE {$_M['table']['language']} SET value = '{$_M['form']['search_placeholder']}' WHERE name = 'columnSearchInfo' AND lang = '{$_M['lang']}'";
        DB::query($query);
        buffer::clearConfig();

        $this->success($data, $_M['word']['jsok']);
    }

    public function doGetAdvancedSearch()
    {
        global $_M;
        $data = array();
        $query = "SELECT * FROM {$_M['table']['language']} WHERE name = 'advancedSearchInfo' AND lang = '{$_M['lang']}'";
        $lang = DB::get_one($query);
        $data['search_placeholder'] = $lang['value'];
        $data['column'] = load::sys_class('label', 'new')->get('column')->get_parent_columns();

        return $data;
    }
    //保存栏目搜索框数据
    public function doSaveAdvancedSearch()
    {
        global $_M;
        $data = array(
            'advanced_search_range',
            'advanced_search_type',
            'advanced_search_column',
            'advanced_search_linkage'
        );
        
        if($_M['form']['advanced_search_range'] == 'all'){
            $_M['form']['advanced_search_column'] = '';
        }
        configsave($data, $_M['form']);
        $query = "UPDATE {$_M['table']['language']} SET value = '{$_M['form']['search_placeholder']}' WHERE name = 'advancedSearchInfo' AND lang = '{$_M['lang']}'";
        DB::query($query);
        buffer::clearConfig();
        $this->success($data, $_M['word']['jsok']);
    }
}
