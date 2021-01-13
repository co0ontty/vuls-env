<?php
/**
 * @copyright (C)2016-2099 Hnaoyun Inc.
 * @author XingMeng
 * @email hnxsh@foxmail.com
 * @date 2018年2月14日
 *  标签解析引擎模型
 */
namespace app\home\model;

use core\basic\Model;

class ParserModel extends Model
{

    // 存储分类及子编码
    protected $scodes = array();

    // 存储分类查询数据
    protected $sorts;

    // 存储栏目位置
    protected $position = array();

    // 上一篇
    protected $pre;

    // 下一篇
    protected $next;

    // 获取模型数据
    public function checkModelUrlname($urlname)
    {
        return parent::table('ay_model')->where("urlname='$urlname'")->find();
    }

    // 站点配置信息
    public function getSite()
    {
        return parent::table('ay_site')->where("acode='" . get_lg() . "'")->find();
    }

    // 公司信息
    public function getCompany()
    {
        return parent::table('ay_company')->where("acode='" . get_lg() . "'")->find();
    }

    // 自定义标签
    public function getLabel()
    {
        return parent::table('ay_label')->decode()->column('value,type', 'name');
    }

    // 单个分类信息，不区分语言，兼容跨语言
    public function getSort($scode)
    {
        $field = array(
            'a.*',
            'c.name AS parentname',
            'b.type',
            'b.urlname'
        );
        $join = array(
            array(
                'ay_model b',
                'a.mcode=b.mcode',
                'LEFT'
            ),
            array(
                'ay_content_sort c',
                'a.pcode=c.scode',
                'LEFT'
            )
        );
        return parent::table('ay_content_sort a')->field($field)
            ->where("a.scode='$scode' OR a.filename='$scode'")
            ->join($join)
            ->find();
    }

    // 多个分类信息
    public function getMultSort($scodes)
    {
        $field = array(
            'a.*',
            'c.name AS parentname',
            'b.type',
            'b.urlname'
        );
        $join = array(
            array(
                'ay_model b',
                'a.mcode=b.mcode',
                'LEFT'
            ),
            array(
                'ay_content_sort c',
                'a.pcode=c.scode',
                'LEFT'
            )
        );
        return parent::table('ay_content_sort a')->field($field)
            ->where("a.acode='" . get_lg() . "'")
            ->in('a.scode', $scodes)
            ->join($join)
            ->order('a.sorting,a.id')
            ->select();
    }

    // 指定分类数量
    public function getSortRows($scode)
    {
        $this->scodes = array(); // 先清空
                                 
        // 获取多分类子类
        $arr = explode(',', $scode);
        foreach ($arr as $value) {
            $scodes = $this->getSubScodes(trim($value));
        }
        
        // 拼接条件
        $where1 = array(
            "scode in (" . implode_quot(',', $scodes) . ")",
            "subscode='$scode'"
        );
        $where2 = array(
            "acode='" . get_lg() . "'",
            'status=1',
            "date<'" . date('Y-m-d H:i:s') . "'"
        );
        
        $result = parent::table('ay_content')->where($where1, 'OR')
            ->where($where2)
            ->column('id');
        return count($result);
    }

    // 分类栏目列表关系树
    public function getSortsTree()
    {
        $fields = array(
            'a.*',
            'b.type',
            'b.urlname'
        );
        $join = array(
            'ay_model b',
            'a.mcode=b.mcode',
            'LEFT'
        );
        $result = parent::table('ay_content_sort a')->where("a.acode='" . get_lg() . "'")
            ->where('a.status=1')
            ->join($join)
            ->order('a.pcode,a.sorting,a.id')
            ->column($fields, 'scode');
        
        foreach ($result as $key => $value) {
            if ($value['pcode']) {
                $result[$value['pcode']]['son'][] = $value; // 记录到关系树
            } else {
                $data['top'][] = $value; // 记录顶级菜单
            }
        }
        $data['tree'] = $result;
        return $data;
    }

    // 获取分类名称
    public function getSortName($scode)
    {
        $result = $this->getSortList();
        return $result[$scode]['name'];
    }

    // 分类顶级编码
    public function getSortTopScode($scode)
    {
        $result = $this->getSortList();
        return $this->getTopParent($scode, $result);
    }

    // 获取位置
    public function getPosition($scode)
    {
        $result = $this->getSortList();
        $this->position = array(); // 重置
        $this->getTopParent($scode, $result);
        return array_reverse($this->position);
    }

    // 分类顶级编码
    private function getTopParent($scode, $sorts)
    {
        if (! $scode || ! $sorts) {
            return;
        }
        $this->position[] = $sorts[$scode];
        if ($sorts[$scode]['pcode']) {
            return $this->getTopParent($sorts[$scode]['pcode'], $sorts);
        } else {
            return $sorts[$scode]['scode'];
        }
    }

    // 分类子类集
    private function getSubScodes($scode)
    {
        if (! $scode) {
            return;
        }
        $this->scodes[] = $scode;
        $subs = parent::table('ay_content_sort')->where("pcode='$scode'")->column('scode');
        if ($subs) {
            foreach ($subs as $value) {
                $this->getSubScodes($value);
            }
        }
        return $this->scodes;
    }

    // 获取栏目清单
    private function getSortList()
    {
        if (! isset($this->sorts)) {
            $fields = array(
                'a.id',
                'a.pcode',
                'a.scode',
                'a.name',
                'a.filename',
                'a.outlink',
                'b.type',
                'b.urlname'
            );
            $join = array(
                'ay_model b',
                'a.mcode=b.mcode',
                'LEFT'
            );
            $this->sorts = parent::table('ay_content_sort a')->where("a.acode='" . get_lg() . "'")
                ->join($join)
                ->column($fields, 'scode');
        }
        return $this->sorts;
    }

    // 获取筛选字段数据
    public function getSelect($field)
    {
        return parent::table('ay_extfield')->where("name='$field'")->value('value');
    }

    // 列表内容,带分页，不区分语言，兼容跨语言
    public function getLists($scode, $num, $order, $filter = array(), $tags = array(), $select = array(), $fuzzy = true, $start = 1)
    {
        $fields = array(
            'a.*',
            'b.name as sortname',
            'b.filename as sortfilename',
            'c.name as subsortname',
            'c.filename as subfilename',
            'd.type',
            'd.name as modelname',
            'd.urlname',
            'e.*'
        );
        $join = array(
            array(
                'ay_content_sort b',
                'a.scode=b.scode',
                'LEFT'
            ),
            array(
                'ay_content_sort c',
                'a.subscode=c.scode',
                'LEFT'
            ),
            array(
                'ay_model d',
                'b.mcode=d.mcode',
                'LEFT'
            ),
            array(
                'ay_content_ext e',
                'a.id=e.contentid',
                'LEFT'
            )
        );
        
        $scode_arr = array();
        if ($scode) {
            // 获取所有子类分类编码
            $this->scodes = array(); // 先清空
            $arr = explode(',', $scode); // 传递有多个分类时进行遍历
            foreach ($arr as $value) {
                $scodes = $this->getSubScodes(trim($value));
            }
            // 拼接条件
            $scode_arr = array(
                "a.scode in (" . implode_quot(',', $scodes) . ")",
                "a.subscode='$scode'"
            );
        }
        
        $where = array(
            'a.status=1',
            'd.type=2',
            "a.date<'" . date('Y-m-d H:i:s') . "'"
        );
        
        // 筛选条件支持模糊匹配
        return parent::table('ay_content a')->field($fields)
            ->where($scode_arr, 'OR')
            ->where($where)
            ->where($select, 'AND', 'AND', $fuzzy)
            ->where($filter, 'OR')
            ->where($tags, 'OR')
            ->join($join)
            ->order($order)
            ->page(1, $num, $start)
            ->decode()
            ->select();
    }

    // 列表内容，不带分页，不区分语言，兼容跨语言
    public function getList($scode, $num, $order, $filter = array(), $tags = array(), $select = array(), $fuzzy = true, $start = 1)
    {
        $fields = array(
            'a.*',
            'b.name as sortname',
            'b.filename as sortfilename',
            'c.name as subsortname',
            'c.filename as subfilename',
            'd.type',
            'd.name as modelname',
            'd.urlname',
            'e.*'
        );
        $join = array(
            array(
                'ay_content_sort b',
                'a.scode=b.scode',
                'LEFT'
            ),
            array(
                'ay_content_sort c',
                'a.subscode=c.scode',
                'LEFT'
            ),
            array(
                'ay_model d',
                'b.mcode=d.mcode',
                'LEFT'
            ),
            array(
                'ay_content_ext e',
                'a.id=e.contentid',
                'LEFT'
            )
        );
        
        $scode_arr = array();
        if ($scode) {
            // 获取所有子类分类编码
            $this->scodes = array(); // 先清空
            $arr = explode(',', $scode); // 传递有多个分类时进行遍历
            foreach ($arr as $value) {
                $scodes = $this->getSubScodes(trim($value));
            }
            // 拼接条件
            $scode_arr = array(
                "a.scode in (" . implode_quot(',', $scodes) . ")",
                "a.subscode='$scode'"
            );
        }
        
        $where = array(
            'a.status=1',
            'd.type=2',
            "a.date<'" . date('Y-m-d H:i:s') . "'"
        );
        
        // 筛选条件支持模糊匹配
        return parent::table('ay_content a')->field($fields)
            ->where($scode_arr, 'OR')
            ->where($where)
            ->where($select, 'AND', 'AND', $fuzzy)
            ->where($filter, 'OR')
            ->where($tags, 'OR')
            ->join($join)
            ->order($order)
            ->limit($start - 1, $num)
            ->decode()
            ->select();
    }

    // 内容详情，不区分语言，兼容跨语言
    public function getContent($id)
    {
        $field = array(
            'a.*',
            'b.name as sortname',
            'b.filename as sortfilename',
            'b.outlink as sortoutlink',
            'c.name as subsortname',
            'c.filename as subfilename',
            'd.type',
            'd.name as modelname',
            'd.urlname',
            'e.*'
        );
        $join = array(
            array(
                'ay_content_sort b',
                'a.scode=b.scode',
                'LEFT'
            ),
            array(
                'ay_content_sort c',
                'a.subscode=c.scode',
                'LEFT'
            ),
            array(
                'ay_model d',
                'b.mcode=d.mcode',
                'LEFT'
            ),
            array(
                'ay_content_ext e',
                'a.id=e.contentid',
                'LEFT'
            )
        );
        $result = parent::table('ay_content a')->field($field)
            ->where("a.id='$id' OR a.filename='$id'")
            ->where('a.status=1')
            ->join($join)
            ->decode()
            ->find();
        return $result;
    }

    // 单篇详情,不区分语言，兼容跨语言
    public function getAbout($scode)
    {
        $field = array(
            'a.*',
            'b.name as sortname',
            'b.filename as sortfilename',
            'c.name as subsortname',
            'c.filename as subfilename',
            'd.type',
            'd.name as modelname',
            'd.urlname',
            'e.*'
        );
        $join = array(
            array(
                'ay_content_sort b',
                'a.scode=b.scode',
                'LEFT'
            ),
            array(
                'ay_content_sort c',
                'a.subscode=c.scode',
                'LEFT'
            ),
            array(
                'ay_model d',
                'b.mcode=d.mcode',
                'LEFT'
            ),
            array(
                'ay_content_ext e',
                'a.id=e.contentid',
                'LEFT'
            )
        );
        $result = parent::table('ay_content a')->field($field)
            ->where("a.scode='$scode' OR b.filename='$scode'")
            ->where('a.status=1')
            ->join($join)
            ->decode()
            ->order('id DESC')
            ->find();
        return $result;
    }

    // 指定内容多图,不区分语言，兼容跨语言
    public function getContentPics($id)
    {
        $result = parent::table('ay_content')->where("id='$id'")
            ->where('status=1')
            ->value('pics');
        return $result;
    }

    // 指定内容多选调用
    public function getContentCheckbox($id, $field)
    {
        $result = parent::table('ay_content_ext')->where("contentid='$id'")->value($field);
        return $result;
    }

    // 指定内容标签调用
    public function getContentTags($id)
    {
        $result = parent::table('ay_content')->field('scode,tags')
            ->where("id='$id'")
            ->find();
        return $result;
    }

    // 指定分类标签调用
    public function getSortTags($scode)
    {
        $join = array(
            array(
                'ay_content_sort b',
                'a.scode=b.scode',
                'LEFT'
            ),
            array(
                'ay_model c',
                'b.mcode=c.mcode',
                'LEFT'
            )
        );
        
        $scode_arr = array();
        if ($scode) {
            // 获取所有子类分类编码
            $this->scodes = array(); // 先清空
            $scodes = $this->getSubScodes(trim($scode)); // 获取子类
                                                         
            // 拼接条件
            $scode_arr = array(
                "a.scode in (" . implode_quot(',', $scodes) . ")",
                "a.subscode='$scode'"
            );
        }
        
        $result = parent::table('ay_content a')->where("c.type=2 AND a.tags<>''")
            ->where($scode_arr, 'OR')
            ->join($join)
            ->order('a.visits DESC')
            ->column('a.tags');
        return $result;
    }

    // 上一篇内容
    public function getContentPre($scode, $id)
    {
        if (! $this->pre) {
            $this->scodes = array();
            $scodes = $this->getSubScodes($scode);
            
            $field = array(
                'a.id',
                'a.title',
                'a.filename',
                'a.ico',
                'a.scode',
                'b.filename as sortfilename',
                'c.type',
                'c.urlname'
            );
            
            $join = array(
                array(
                    'ay_content_sort b',
                    'a.scode=b.scode',
                    'LEFT'
                ),
                array(
                    'ay_model c',
                    'b.mcode=c.mcode',
                    'LEFT'
                )
            );
            
            $this->pre = parent::table('ay_content a')->field($field)
                ->where("a.id<$id")
                ->join($join)
                ->in('a.scode', $scodes)
                ->where("a.acode='" . get_lg() . "'")
                ->where('a.status=1')
                ->order('a.id DESC')
                ->find();
        }
        return $this->pre;
    }

    // 下一篇内容
    public function getContentNext($scode, $id)
    {
        if (! $this->next) {
            $this->scodes = array();
            $scodes = $this->getSubScodes($scode);
            
            $field = array(
                'a.id',
                'a.title',
                'a.filename',
                'a.ico',
                'a.scode',
                'b.filename as sortfilename',
                'c.type',
                'c.urlname'
            );
            
            $join = array(
                array(
                    'ay_content_sort b',
                    'a.scode=b.scode',
                    'LEFT'
                ),
                array(
                    'ay_model c',
                    'b.mcode=c.mcode',
                    'LEFT'
                )
            );
            
            $this->next = parent::table('ay_content a')->field($field)
                ->where("a.id>$id")
                ->join($join)
                ->in('a.scode', $scodes)
                ->where("a.acode='" . get_lg() . "'")
                ->where('a.status=1')
                ->order('a.id ASC')
                ->find();
        }
        return $this->next;
    }

    // 幻灯片
    public function getSlides($gid, $num, $start = 1)
    {
        $result = parent::table('ay_slide')->where("gid='$gid'")
            ->order('sorting ASC,id ASC')
            ->limit($start - 1, $num)
            ->select();
        return $result;
    }

    // 友情链接
    public function getLinks($gid, $num, $start = 1)
    {
        $result = parent::table('ay_link')->where("gid='$gid'")
            ->order('sorting ASC,id ASC')
            ->limit($start - 1, $num)
            ->select();
        return $result;
    }

    // 获取留言
    public function getMessage($num, $page = true, $start = 1, $lg = null)
    {
        if ($lg == 'all') {
            $where = array();
        } elseif ($lg) {
            $where = array(
                'acode' => $lg
            );
        } else {
            $where = array(
                'acode' => get_lg()
            );
        }
        if ($page) {
            return parent::table('ay_message')->where("status=1")
                ->where($where)
                ->order('id DESC')
                ->decode(false)
                ->page(1, $num, $start)
                ->select();
        } else {
            return parent::table('ay_message')->where("status=1")
                ->where($where)
                ->order('id DESC')
                ->decode(false)
                ->limit($start - 1, $num)
                ->select();
        }
    }

    // 新增留言
    public function addMessage($data)
    {
        return parent::table('ay_message')->autoTime()->insert($data);
    }

    // 获取表单字段
    public function getFormField($fcode)
    {
        $field = array(
            'a.table_name',
            'a.form_name',
            'b.name',
            'b.required',
            'b.description'
        );
        
        $join = array(
            'ay_form_field b',
            'a.fcode=b.fcode',
            'LEFT'
        );
        
        return parent::table('ay_form a')->field($field)
            ->where("a.fcode='$fcode'")
            ->join($join)
            ->order('b.sorting ASC,b.id ASC')
            ->select();
    }

    // 获取表单表名称
    public function getFormTable($fcode)
    {
        return parent::table('ay_form')->where("fcode='$fcode'")->value('table_name');
    }

    // 获取表单数据
    public function getForm($table, $num, $page = true, $start = 1)
    {
        if ($page) {
            return parent::table($table)->order('id DESC')
                ->decode(false)
                ->page(1, $num, $start)
                ->select();
        } else {
            return parent::table($table)->order('id DESC')
                ->decode(false)
                ->limit($start - 1, $num)
                ->select();
        }
    }

    // 新增表单数据
    public function addForm($table, $data)
    {
        return parent::table($table)->insert($data);
    }

    // 文章内链
    public function getTags()
    {
        return parent::table('ay_tags')->field('name,link')
            ->where("acode='" . get_lg() . "'")
            ->order('length(name) desc')
            ->select();
    }
}