<?php
/**
 * @copyright (C)2016-2099 Hnaoyun Inc.
 * @author XingMeng
 * @email hnxsh@foxmail.com
 * @date 2018年2月14日
 *  首页控制器
 */
namespace app\home\controller;

use core\basic\Controller;
use app\home\model\ParserModel;

class IndexController extends Controller
{

    protected $parser;

    protected $model;

    public function __construct()
    {
        $this->parser = new ParserController();
        $this->model = new ParserModel();
    }

    // 空拦截器, 实现文章路由转发
    public function _empty()
    {
        // 地址类型
        $url_rule_type = $this->config('url_rule_type') ?: 3;
        
        if (P) { // 采用pathinfo模式及p参数模式
                 
            // 禁止伪静态时带index.php访问
            if ($url_rule_type == 2 && stripos(URL, $_SERVER['SCRIPT_NAME']) !== false) {
                $this->_404('您访问的内容不存在，请核对后重试！');
            }
            
            $path = explode('/', P);
            if (! defined('URL_BIND')) {
                array_shift($path); // 去除模块部分
            }
        } elseif ($url_rule_type == 3 && isset($_SERVER["QUERY_STRING"]) && $qs = $_SERVER["QUERY_STRING"]) { // 采用简短传参模式
            parse_str($qs, $output);
            unset($output['page']); // 去除分页
            if ($output && ! current($output)) {
                $path = key($output); // 第一个参数为路径信息，注意PHP数组会自动将key点符号转换下划线
                $path = trim($path, '/'); // 去除两端斜杠
                $url_rule_suffix = substr($this->config('url_rule_suffix'), 1);
                if (! ! $pos = strripos($path, '_' . $url_rule_suffix)) {
                    $path = substr($path, 0, $pos); // 去扩展
                }
                if (! preg_match('/^[\w\-\.\/]+$/', $path)) {
                    $this->_404('您访问的地址有误，请核对后重试！');
                }
                $path = explode('/', $path);
            } elseif (isset($output['keyword'])) { // 支持兼容模式普通搜索
                $this->search();
                exit();
            }
        }
        
        if (isset($path) && is_array($path)) {
            
            // 地址分隔符
            $url_break_char = $this->config('url_break_char') ?: '_';
            
            // 判断第一个参数中组合信息
            if (strpos($path[0], $url_break_char)) {
                $param = explode($url_break_char, $path[0]);
            } else {
                $param[] = $path[0];
            }
            
            // 判断第一个参数是模型还是自定义分类
            if (! ! ($model = $this->model->checkModelUrlname($param[0])) || preg_match('/^(list_[0-9]+)|(^about_[0-9]+)/', $path[0])) {
                $scode = $param[1];
                if (isset($param[2])) {
                    $_GET['page'] = $param[2]; // 分页
                }
            } else {
                define('CMS_PAGE_CUSTOM', true); // 自定义名称后比正常少了一个参数
                $scode = $param[0];
                if (isset($param[1])) {
                    $_GET['page'] = $param[1]; // 分页
                }
            }
            
            // 路由
            switch ($param[0]) {
                case 'search':
                case 'keyword':
                    $this->search();
                    break;
                case 'addMsg':
                    $this->addMsg();
                    break;
                case 'addForm':
                    $_GET['fcode'] = $path[2];
                    $this->addForm();
                    break;
                case 'sitemap':
                    $sitemap = new SitemapController();
                    $sitemap->index();
                    break;
                default:
                    if (count($path) > 1) {
                        if (! ! ($data = $this->model->getContent($path[1])) && ($data->scode == $scode || $data->sortfilename == $scode)) {
                            $this->getContent($data);
                        } else {
                            $this->_404('您访问的内容不存在，请核对后重试！');
                        }
                    } else {
                        if (! ! $sort = $this->model->getSort($scode)) {
                            if ($sort->type == 1) {
                                $this->getAbout($sort);
                            } else {
                                $this->getList($sort);
                            }
                        } else {
                            $this->_404('您访问的栏目不存在，请核对后重试！');
                        }
                    }
            }
        } else {
            $this->getIndex();
        }
    }

    // 首页
    private function getIndex()
    {
        $content = parent::parser('index.html'); // 框架标签解析
        $content = $this->parser->parserBefore($content); // CMS公共标签前置解析
        $content = $this->parser->parserPositionLabel($content, - 1, '首页', SITE_DIR . '/'); // CMS当前位置标签解析
        $content = $this->parser->parserSpecialPageSortLabel($content, 0, '', SITE_DIR . '/'); // 解析分类标签
        $content = $this->parser->parserAfter($content); // CMS公共标签后置解析
        $this->cache($content, true);
    }

    // 列表
    private function getList($sort)
    {
        if ($sort->listtpl) {
            define('CMS_PAGE', true); // 使用cms分页处理模型
            $content = parent::parser($sort->listtpl); // 框架标签解析
            $content = $this->parser->parserBefore($content); // CMS公共标签前置解析
            $pagetitle = $sort->title ? "{sort:title}" : "{sort:name}"; // 页面标题
            $content = str_replace('{pboot:pagetitle}', $pagetitle . '-{pboot:sitetitle}-{pboot:sitesubtitle}', $content);
            $content = str_replace('{pboot:pagekeywords}', '{sort:keywords}', $content);
            $content = str_replace('{pboot:pagedescription}', '{sort:description}', $content);
            $content = $this->parser->parserPositionLabel($content, $sort->scode); // CMS当前位置标签解析
            $content = $this->parser->parserSortLabel($content, $sort); // CMS分类信息标签解析
            $content = $this->parser->parserListLabel($content, $sort->scode); // CMS分类列表标签解析
            $content = $this->parser->parserAfter($content); // CMS公共标签后置解析
        } else {
            $this->_404('请到后台设置分类栏目列表页模板！');
        }
        $this->cache($content, true);
    }

    // 详情页
    private function getContent($data)
    {
        // 读取模板
        if (! ! $sort = $this->model->getSort($data->scode)) {
            if ($sort->contenttpl) {
                define('CMS_PAGE', true); // 使用cms分页处理模型
                $content = parent::parser($sort->contenttpl); // 框架标签解析
                $content = $this->parser->parserBefore($content); // CMS公共标签前置解析
                $content = str_replace('{pboot:pagetitle}', '{content:title}-{sort:name}-{pboot:sitetitle}-{pboot:sitesubtitle}', $content);
                $content = str_replace('{pboot:pagekeywords}', '{content:keywords}', $content);
                $content = str_replace('{pboot:pagedescription}', '{content:description}', $content);
                $content = $this->parser->parserPositionLabel($content, $sort->scode); // CMS当前位置标签解析
                $content = $this->parser->parserSortLabel($content, $sort); // CMS分类信息标签解析
                $content = $this->parser->parserCurrentContentLabel($content, $sort, $data); // CMS内容标签解析
                $content = $this->parser->parserAfter($content); // CMS公共标签后置解析
            } else {
                $this->_404('请到后台设置分类栏目内容页模板！');
            }
        } else {
            $this->_404('您访问内容的分类已经不存在，请核对后再试！');
        }
        $this->cache($content, true);
    }

    // 单页
    private function getAbout($sort)
    {
        // 读取数据
        if (! $data = $this->model->getAbout($sort->scode)) {
            $this->_404('您访问的内容不存在，请核对后重试！');
        }
        
        if ($sort->contenttpl) {
            define('CMS_PAGE', true); // 使用cms分页处理模型
            $content = parent::parser($sort->contenttpl); // 框架标签解析
            $content = $this->parser->parserBefore($content); // CMS公共标签前置解析
            $pagetitle = $sort->title ? "{sort:title}" : "{content:title}"; // 页面标题
            $content = str_replace('{pboot:pagetitle}', $pagetitle . '-{pboot:sitetitle}-{pboot:sitesubtitle}', $content);
            $content = str_replace('{pboot:pagekeywords}', '{content:keywords}', $content);
            $content = str_replace('{pboot:pagedescription}', '{content:description}', $content);
            $content = $this->parser->parserPositionLabel($content, $sort->scode); // CMS当前位置标签解析
            $content = $this->parser->parserSortLabel($content, $sort); // CMS分类信息标签解析
            $content = $this->parser->parserCurrentContentLabel($content, $sort, $data); // CMS内容标签解析
            $content = $this->parser->parserAfter($content); // CMS公共标签后置解析
        } else {
            $this->_404('请到后台设置分类栏目内容页模板！');
        }
        
        $this->cache($content, true);
    }

    // 内容搜索
    public function search()
    {
        $searchtpl = request('searchtpl');
        if (! preg_match('/^[\w\-\.\/]+$/', $searchtpl)) {
            $searchtpl = 'search.html';
        }
        
        $searchtpl = $content = parent::parser($searchtpl); // 框架标签解析
        $content = $this->parser->parserBefore($content); // CMS公共标签前置解析
        $content = $this->parser->parserPositionLabel($content, 0, '搜索', url('/home/Index/search')); // CMS当前位置标签解析
        $content = $this->parser->parserSpecialPageSortLabel($content, - 1, '搜索结果', url('/home/Index/search')); // 解析分类标签
        $content = $this->parser->parserSearchLabel($content); // 搜索结果标签
        $content = $this->parser->parserAfter($content); // CMS公共标签后置解析
        echo $content; // 搜索页面不缓存
        exit();
    }

    // 留言新增
    public function addMsg()
    {
        if ($_POST) {
            
            if (time() - session('lastsub') < 10) {
                alert_back('您提交太频繁了，请稍后再试！');
            }
            
            // 验证码验证
            $checkcode = strtolower(post('checkcode', 'var'));
            if ($this->config('message_check_code')) {
                if (! $checkcode) {
                    alert_back('验证码不能为空！');
                }
                
                if ($checkcode != session('checkcode')) {
                    alert_back('验证码错误！');
                }
            }
            
            // 读取字段
            if (! $form = $this->model->getFormField(1)) {
                alert_back('留言表单不存在任何字段，请核对后重试！');
            }
            
            // 接收数据
            $mail_body = '';
            foreach ($form as $value) {
                $field_data = post($value->name);
                if (is_array($field_data)) { // 如果是多选等情况时转换
                    $field_data = implode(',', $field_data);
                }
                if ($value->required && ! $field_data) {
                    alert_back($value->description . '不能为空！');
                } else {
                    $data[$value->name] = $field_data;
                    $mail_body .= $value->description . '：' . $field_data . '<br>';
                }
            }
            
            $status = $this->config('message_verify') == '0' ? 1 : 0;
            
            // 设置额外数据
            if ($data) {
                $data['acode'] = get_lg();
                $data['user_ip'] = ip2long(get_user_ip());
                $data['user_os'] = get_user_os();
                $data['user_bs'] = get_user_bs();
                $data['recontent'] = '';
                $data['status'] = $status;
                $data['create_user'] = 'guest';
                $data['update_user'] = 'guest';
            }
            
            if ($this->model->addMessage($data)) {
                session('lastsub', time()); // 记录最后提交时间
                $this->log('留言提交成功！');
                if ($this->config('message_send_mail') && $this->config('message_send_to')) {
                    $mail_subject = "【PbootCMS】您有新的" . $value->form_name . "信息，请注意查收！";
                    $mail_body .= '<br>来自网站 ' . get_http_url() . ' （' . date('Y-m-d H:i:s') . '）';
                    sendmail($this->config(), $this->config('message_send_to'), $mail_subject, $mail_body);
                }
                alert_location('提交成功！', '-1', 1);
            } else {
                $this->log('留言提交失败！');
                alert_back('提交失败！');
            }
        } else {
            alert_back('提交失败，请使用POST方式提交！');
        }
    }

    // 表单提交
    public function addForm()
    {
        if ($_POST) {
            
            if (time() - session('lastsub') < 10) {
                alert_back('您提交太频繁了，请稍后再试！');
            }
            
            if (! $fcode = get('fcode', 'var')) {
                alert_back('传递的表单编码有误！');
            }
            
            if ($fcode == 1) {
                alert_back('表单提交地址有误，留言提交请使用留言专用地址!');
            }
            
            // 验证码验证
            $checkcode = strtolower(post('checkcode', 'var'));
            if ($this->config('form_check_code')) {
                if (! $checkcode) {
                    alert_back('验证码不能为空！');
                }
                if ($checkcode != session('checkcode')) {
                    alert_back('验证码错误！');
                }
            }
            
            // 读取字段
            if (! $form = $this->model->getFormField($fcode)) {
                alert_back('接收表单不存在任何字段，请核对后重试！');
            }
            
            // 接收数据
            $mail_body = '';
            foreach ($form as $value) {
                $field_data = post($value->name);
                if (is_array($field_data)) { // 如果是多选等情况时转换
                    $field_data = implode(',', $field_data);
                }
                if ($value->required && ! $field_data) {
                    alert_back($value->description . '不能为空！');
                } else {
                    $data[$value->name] = $field_data;
                    $mail_body .= $value->description . '：' . $field_data . '<br>';
                }
            }
            
            // 设置创建时间
            if ($data) {
                $data['create_time'] = get_datetime();
            }
            
            // 写入数据
            if ($this->model->addForm($value->table_name, $data)) {
                session('lastsub', time()); // 记录最后提交时间
                $this->log('提交表单数据成功！');
                if ($this->config('form_send_mail') && $this->config('message_send_to')) {
                    $mail_subject = "【PbootCMS】您有新的" . $value->form_name . "信息，请注意查收！";
                    $mail_body .= '<br>来自网站 ' . get_http_url() . ' （' . date('Y-m-d H:i:s') . '）';
                    sendmail($this->config(), $this->config('message_send_to'), $mail_subject, $mail_body);
                }
                alert_location('提交成功！', '-1', 1);
            } else {
                $this->log('提交表单数据失败！');
                alert_back('提交失败！');
            }
        } else {
            alert_back('提交失败，请使用POST方式提交！');
        }
    }

    // 返回404页面
    private function _404($string)
    {
        header('HTTP/1.1 404 Not Found');
        header('status: 404 Not Found');
        $file_404 = ROOT_PATH . '/404.html';
        if (file_exists($file_404)) {
            require $file_404;
            exit();
        } else {
            error($string);
        }
    }
}