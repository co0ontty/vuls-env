<?php
/**
 * @copyright (C)2016-2099 Hnaoyun Inc.
 * @author XingMeng
 * @email hnxsh@foxmail.com
 * @date 2018年01月03日
 *  应用配置控制器
 */
namespace app\admin\controller\system;

use core\basic\Controller;
use app\admin\model\system\ConfigModel;
use core\basic\Config;

class ConfigController extends Controller
{

    private $model;

    public function __construct()
    {
        $this->model = new ConfigModel();
    }

    // 应用配置列表
    public function index()
    {
        if (! ! $action = get('action')) {
            switch ($action) {
                case 'sendemail':
                    $rs = sendmail($this->config(), get('to'), '【PbootCMS】测试邮件', '欢迎您使用PbootCMS网站开发管理系统！');
                    if ($rs === true) {
                        alert_back('测试邮件发送成功！');
                    } else {
                        error('发送失败：' . $rs);
                    }
                    break;
            }
        }
        
        // 修改参数配置
        if ($_POST) {
            unset($_POST['upload']); // 去除上传组件
            foreach ($_POST as $key => $value) {
                if (! preg_match('/^[\w\-]+$/', $key)) {
                    continue;
                }
                $config = array(
                    'debug',
                    'sn',
                    'sn_user',
                    'pagenum',
                    'tpl_html_cache',
                    'tpl_html_cache_time',
                    'session_in_sitepath'
                );
                if (in_array($key, $config)) {
                    if ($key == 'tpl_html_cache_time' && ! $value) {
                        $value = 900;
                    } else {
                        $value = post($key);
                    }
                    $this->modConfig($key, $value);
                } else {
                    $this->modDbConfig($key);
                }
            }
            
            $this->log('修改参数配置成功！');
            path_delete(RUN_PATH . '/config'); // 清理缓存的配置文件
            
            switch (post('submit')) {
                case 'email':
                    success('修改成功！', url('/admin/Config/index' . get_tab('t2'), false));
                    break;
                case 'baidu':
                    success('修改成功！', url('/admin/Config/index' . get_tab('t3'), false));
                    break;
                case 'api':
                    success('修改成功！', url('/admin/Config/index' . get_tab('t4'), false));
                    break;
                case 'watermark':
                    success('修改成功！', url('/admin/Config/index' . get_tab('t5'), false));
                    break;
                case 'security':
                    success('修改成功！', url('/admin/Config/index' . get_tab('t6'), false));
                    break;
                case 'urlrule':
                    success('修改成功！', url('/admin/Config/index' . get_tab('t7'), false));
                    break;
                case 'upgrade':
                    success('修改成功！', url('/admin/Upgrade/index' . get_tab('t2'), false));
                    break;
                default:
                    success('修改成功！', url('/admin/Config/index', false));
            }
        }
        $configs = $this->model->getList();
        $configs['debug']['value'] = $this->config('debug');
        $configs['sn']['value'] = $this->config('sn');
        $configs['sn_user']['value'] = $this->config('sn_user');
        $configs['session_in_sitepath']['value'] = $this->config('session_in_sitepath');
        $configs['pagenum']['value'] = $this->config('pagenum');
        $configs['url_type']['value'] = $this->config('url_type');
        $configs['tpl_html_cache']['value'] = $this->config('tpl_html_cache');
        $configs['tpl_html_cache_time']['value'] = $this->config('tpl_html_cache_time');
        $this->assign('configs', $configs);
        $this->display('system/config.html');
    }

    // 修改配置文件
    private function modConfig($key, $value)
    {
        $value = str_replace(' ', '', $value); // 去除空格
        $value = str_replace('，', ',', $value); // 转换可能输入的中文逗号
        if (! preg_match('/^[\w\s\,\-]+$/', $value)) {
            return;
        }
        
        $config = file_get_contents(CONF_PATH . '/config.php');
        if (preg_match("'$key'", $config)) {
            if (is_numeric($value)) {
                $config = preg_replace('/(\'' . $key . '\'([\s]+)?=>([\s]+)?)[\w\'\"\s,]+,/', '${1}' . $value . ',', $config);
            } else {
                $config = preg_replace('/(\'' . $key . '\'([\s]+)?=>([\s]+)?)[\w\'\"\s,]+,/', '${1}\'' . $value . '\',', $config);
            }
        } else {
            $config = preg_replace('/(return array\()/', "$1\r\n\r\n\t'$key' => '$value',", $config); // 自动新增配置
        }
        return file_put_contents(CONF_PATH . '/config.php', $config);
    }

    // 修改数据库配置
    private function modDbConfig($key)
    {
        $value = post($key);
        
        // 如果开启伪静态时自动拷贝文件
        if ($key == 'url_rule_type' && $value == 2) {
            $soft = get_server_soft();
            if ($soft == 'iis') {
                if (! file_exists(ROOT_PATH . '/web.config')) {
                    copy(ROOT_PATH . '/rewrite/web.config', ROOT_PATH . '/web.config');
                }
            } elseif ($soft == 'apache') {
                if (! file_exists(ROOT_PATH . '/web.config')) {
                    copy(ROOT_PATH . '/rewrite/.htaccess', ROOT_PATH . '/.htaccess');
                }
            }
        }
        
        // 关键词过滤处理
        if ($key == 'content_keyword_replace' && $value) {
            $value = str_replace("\r\n", ",", $value); // 替换回车
            $value = str_replace("，", ",", $value); // 替换中文逗号分割符
        }
        
        if ($this->model->checkConfig("name='$key'")) {
            $this->model->modValue($key, $value);
        } elseif ($key != 'submit' && $key != 'formcheck') {
            // 自动新增配置项
            $data = array(
                'name' => $key,
                'value' => $value,
                'type' => 2,
                'sorting' => 255,
                'description' => ''
            );
            return $this->model->addConfig($data);
        }
    }
}