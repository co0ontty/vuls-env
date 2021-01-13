<?php
/**
 * @copyright (C)2016-2099 Hnaoyun Inc.
 * @author XingMeng
 * @email hnxsh@foxmail.com
 * @date  2017年12月15日
 *  单页内容控制器
 */
namespace app\admin\controller\content;

use core\basic\Controller;
use app\admin\model\content\SingleModel;

class SingleController extends Controller
{

    private $model;

    private $blank;

    public function __construct()
    {
        $this->model = new SingleModel();
    }

    // 单页内容列表
    public function index()
    {
        if ((! ! $id = get('id', 'int')) && $result = $this->model->getSingle($id)) {
            $this->assign('more', true);
            $this->assign('content', $result);
        } else {
            $this->assign('list', true);
            if (! $mcode = get('mcode', 'var')) {
                error('传递的模型编码参数有误，请核对后重试！');
            }
            
            if (! ! ($field = get('field', 'var')) && ! ! ($keyword = get('keyword', 'vars'))) {
                $result = $this->model->findSingle($mcode, $field, $keyword);
            } else {
                $result = $this->model->getList($mcode);
            }
            $this->assign('baidu_zz_token', $this->config('baidu_zz_token'));
            $this->assign('baidu_xzh_appid', $this->config('baidu_xzh_appid'));
            $this->assign('baidu_xzh_token', $this->config('baidu_xzh_token'));
            
            // 模型名称
            $this->assign('model_name', model('admin.content.Model')->getName($mcode));
            
            // 前端地址连接符判断
            $url_break_char = $this->config('url_break_char') ?: '_';
            $this->assign('url_break_char', $url_break_char);
            
            $this->assign('contents', $result);
        }
        $this->display('content/single.html');
    }

    // 单页内容删除
    public function del()
    {
        if (! $id = get('id', 'int')) {
            error('传递的参数值错误！', - 1);
        }
        
        if ($this->model->delSingle($id)) {
            $this->log('删除单页内容' . $id . '成功！');
            success('删除成功！', - 1);
        } else {
            $this->log('删除单页内容' . $id . '失败！');
            error('删除失败！', - 1);
        }
    }

    // 单页内容修改
    public function mod()
    {
        // 前端地址连接符判断
        if (get('baiduzz') || get('baiduxzh')) {
            $url_break_char = $this->config('url_break_char') ?: '_';
            $url_rule_sort_suffix = $this->config('url_rule_sort_suffix') ? true : false;
        }
        
        // 站长推送
        if (! ! $id = get('baiduzz')) {
            $domain = get_http_url();
            if (! $token = $this->config('baidu_zz_token')) {
                alert_back('请先到系统配置中填写百度链接推送token值！');
            }
            
            $api = "http://data.zz.baidu.com/urls?site=$domain&token=$token";
            $data = $this->model->getSingle($id);
            $data->urlname = $data->urlname ?: 'about';
            if ($data->outlink) {
                alert_back('链接类型不允许推送！');
            }
            if ($data->filename) {
                $urls[] = $domain . homeurl('/home/Index/' . $data->filename, $url_rule_sort_suffix);
            } else {
                $urls[] = $domain . homeurl('/home/Index/' . $data->urlname . $url_break_char . $data->scode, $url_rule_sort_suffix);
            }
            $result = post_baidu($api, $urls);
            if (isset($result->error)) {
                $this->log('百度推送失败：' . $urls[0]);
                alert_back('推送发生错误：' . $result->message);
            } elseif (isset($result->success)) {
                $this->log('百度推送成功：' . $urls[0]);
                alert_back('成功推送' . $result->success . '条，今天剩余可推送' . $result->remain . '条数!');
            } else {
                alert_back('发生未知错误！');
            }
        }
        
        // 熊掌号推送
        if (! ! $id = get('baiduxzh')) {
            $domain = get_http_url();
            $appid = $this->config('baidu_xzh_appid');
            $token = $this->config('baidu_xzh_token');
            $type = ($this->config('baidu_xzh_type')) ? 'batch' : 'realtime';
            
            if (! $appid || ! $token) {
                alert_back('请先到系统配置中填写百度熊掌号推送appid及token值！');
            }
            $api = "http://data.zz.baidu.com/urls?appid=$appid&token=$token&type=$type";
            $data = $this->model->getSingle($id);
            if ($data->outlink) {
                alert_back('链接类型不允许推送！');
            }
            $data->urlname = $data->urlname ?: 'about';
            if ($data->filename) {
                $urls[] = $domain . homeurl('/home/Index/' . $data->filename, $url_rule_sort_suffix);
            } else {
                $urls[] = $domain . homeurl('/home/Index/' . $data->urlname . $url_break_char . $data->scode, $url_rule_sort_suffix);
            }
            $result = post_baidu($api, $urls);
            
            if ($type == 'batch') {
                $success = 'success_batch';
                $remain = 'remain_batch';
            } else {
                $success = 'success_realtime';
                $remain = 'remain_realtime';
            }
            
            if (isset($result->error)) {
                $this->log('熊掌号推送失败：' . $urls[0]);
                alert_back('推送发生错误：' . $result->message);
            } elseif (isset($result->$success) || isset($result->$remain)) {
                $this->log('熊掌号推送成功：' . $urls[0]);
                alert_back('成功推送' . $result->$success . '条，今天剩余可推送' . $result->$remain . '条数!');
            } elseif (isset($result->success)) {
                $this->log('熊掌号推送失败：' . $urls[0]);
                alert_back('推送失败，不合规地址' . count($result->not_same_site) . '条！');
            } else {
                alert_back('发生未知错误！');
            }
        }
        
        if (! $id = get('id', 'int')) {
            error('传递的参数值错误！', - 1);
        }
        
        // 单独修改状态
        if (($field = get('field', 'var')) && ! is_null($value = get('value', 'var'))) {
            if ($this->model->modSingle($id, "$field='$value',update_user='" . session('username') . "'")) {
                location(- 1);
            } else {
                alert_back('修改失败！');
            }
        }
        
        // 修改操作
        if ($_POST) {
            
            // 获取数据
            $title = post('title');
            $author = post('author');
            $source = post('source');
            $ico = post('ico');
            $pics = post('pics');
            $content = post('content');
            $tags = str_replace('，', ',', post('tags'));
            $titlecolor = post('titlecolor');
            $subtitle = post('subtitle');
            $outlink = post('outlink');
            $date = post('date');
            $enclosure = post('enclosure');
            $keywords = post('keywords');
            $description = post('description');
            $status = post('status', 'int');
            
            if (! $title) {
                alert_back('单页内容标题不能为空！');
            }
            
            // 自动提起前一百个字符为描述
            if (! $description && isset($_POST['content'])) {
                $description = escape_string(clear_html_blank(substr_both(strip_tags($_POST['content']), 0, 150)));
            }
            
            // 缩放缩略图
            if ($ico) {
                resize_img(ROOT_PATH . $ico, '', $this->config('ico.max_width'), $this->config('ico.max_height'));
            }
            
            // 构建数据
            $data = array(
                'title' => $title,
                'content' => $content,
                'tags' => $tags,
                'author' => $author,
                'source' => $source,
                'ico' => $ico,
                'pics' => $pics,
                'titlecolor' => $titlecolor,
                'subtitle' => $subtitle,
                'outlink' => $outlink,
                'date' => $date,
                'enclosure' => $enclosure,
                'keywords' => $keywords,
                'description' => clear_html_blank($description),
                'status' => $status,
                'update_user' => session('username')
            );
            
            // 执行添加
            if ($this->model->modSingle($id, $data)) {
                
                // 扩展内容修改
                foreach ($_POST as $key => $value) {
                    if (preg_match('/^ext_[\w\-]+$/', $key)) {
                        $temp = post($key);
                        if (is_array($temp)) {
                            $data2[$key] = implode(',', $temp);
                        } else {
                            $data2[$key] = str_replace("\r\n", '<br>', $temp);
                        }
                    }
                }
                if (isset($data2)) {
                    if ($this->model->findContentExt($id)) {
                        $this->model->modContentExt($id, $data2);
                    } else {
                        $data2['contentid'] = $id;
                        $this->model->addContentExt($data2);
                    }
                }
                
                $this->log('修改单页内容' . $id . '成功！');
                if (! ! $backurl = get('backurl')) {
                    success('修改成功！', base64_decode($backurl));
                } else {
                    success('修改成功！', url('/admin/Single/index/mcode/1'));
                }
            } else {
                location(- 1);
            }
        } else {
            // 调取修改内容
            $this->assign('mod', true);
            if (! $result = $this->model->getSingle($id)) {
                error('编辑的内容已经不存在！', - 1);
            }
            $this->assign('content', $result);
            
            // 扩展字段
            if (! $mcode = get('mcode', 'var')) {
                error('传递的模型编码参数有误，请核对后重试！');
            }
            $this->assign('extfield', model('admin.content.ExtField')->getModelField($mcode));
            
            $this->display('content/single.html');
        }
    }
}