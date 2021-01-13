<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::sys_class('group');

class sys_group extends group
{
    /**
     * 会员组列表
     */
    public function json_group_list()
    {
        global $_M;
        $order = " access ";
        $where = " lang='{$_M['lang']}' ";
        $table = load::sys_class('tabledata', 'new');
        $grouplist = $table->getdata($_M['table']['user_group'], '*', $where, $order);
        #dump($grouplist);

        foreach ($grouplist as $val) {
            $list = array();
            $query = "SELECT `groupid`,`recharge_price`,`price`,`buyok`,`rechargeok` FROM {$_M['table']['user_group_pay']} WHERE groupid = '{$val['id']}'";
            $pay_group = DB::get_one($query);

            $list['id'] = $val['id'];
            $list['name-' . $val['id']] = $val['name'];
            if ($_M['config']['payment_open'] = 1) {
                $list['rechargeok-' . $val['id']]     = $pay_group['rechargeok'];
                $list['recharge_price-' . $val['id']] = $pay_group['recharge_price'];

                $list['buyok-' . $val['id']]          = $pay_group['buyok'];
                $list['group_pricr-' . $val['id']]    = $pay_group['group_pricr'];
            }else{
                $list['rechargeok-' . $val['id']]     = "{$_M['word']['useinfopay']}";
                $list['recharge_price-' . $val['id']] = $pay_group['recharge_price'];

                $list['buyok-' . $val['id']]          = "{$_M['word']['useinfopay']}";
                $list['group_pricr-' . $val['id']]    = $pay_group['group_pricr'];
            }
            $list['access-' . $val['id']]     = $val['access'];
            $list['del_url-' . $val['id']]    = "{$_M['url']['own_form']}a=dosave&allid={$val['id']}";
            $rarray[] = $list;
        }
        $table->rdata($rarray);
    }

    /**
     * 保存会员组信息
     * @param $allid
     * @param $type
     * @return bool
     */
    public function save_group()
    {
        global $_M;
        $redata = array();
        $allid  = $_M['form']['allid'];
        $type   = $_M['form']['submit_type'];
        $list   = explode(",", $allid);

        foreach ($list as $id) {
            if ($id) {
                if ($type == 'save') {
                    $name   = $_M['form']['name-' . $id];
                    $access = $_M['form']['access-' . $id] ? $_M['form']['access-' . $id] : 0;
                    $pricr  = $_M['form']['group_pricr-' . $id];
                    $buyok  = $_M['form']['buyok-' . $id] ? $_M['form']['buyok-' . $id] : 0;
                    $recharge_price = $_M['form']['recharge_price-' . $id];
                    $rechargeok     = $_M['form']['rechargeok-' . $id] ? $_M['form']['rechargeok-' . $id] : 0;

                    if (is_number($id)) {
                        //更新
                        if ($access < 1) {
                            $redata['status']   = 0;
                            $redata['msg']      = $_M['word']['opfailed'];
                            $redata['error']    = $_M['word']['usereadinfo'];
                            return $redata;
                        }

                        $query = "UPDATE {$_M['table']['user_group']} SET
						`name`      = '{$name}',
						`access`    = '{$access}' WHERE 
						`id`  = '{$id}' AND 
						`lang` = '{$_M['lang']}'";
                        DB::query($query);

                        //更新付费用户组
                        $this->updatePayGroup($id, $pricr, $buyok, $recharge_price, $rechargeok);
/*
                        $query1 = "UPDATE {$_M['table']['admin_array']} SET
						array_name = '{$name}',
						user_webpower = '{$access}'
						WHERE id = '{$id}' and lang = '{$_M['lang']}'";
                        DB::query($query1);*/

                    } else {
                        if ($name) {
                            if ($access < 1) {
                                $redata['status']   = 0;
                                $redata['msg']      = $_M['word']['opfailed'];
                                $redata['error']    = $_M['word']['usereadinfo'];
                                return $redata;
                            }

                            $query = "INSERT INTO {$_M['table']['user_group']} SET
							`name`    = '{$name}',
							`access`  = '{$access}',
							`lang`    = '{$_M['lang']}'";
                            DB::query($query);
                            $group_id = DB::insert_id();

                            //更新付费用户组
                            $this->updatePayGroup($group_id, $pricr, $buyok, $recharge_price, $rechargeok);

                            /*$query1 = "INSERT INTO {$_M['table']['admin_array']} SET
							id = '{$group_id}',
							array_name = '{$name}',
							user_webpower = '{$access}',
							array_type = 1,
							langok = '',
							lang  = '{$_M['lang']}'";
                            DB::query($query1);*/
                        }
                    }
                } elseif ($type == 'del') {
                    if (is_number($id)) {
                        $query = "DELETE FROM {$_M['table']['user_group']} WHERE id='{$id}' and lang='{$_M['lang']}' ";
                        DB::query($query);
                        /*$query1 = "DELETE FROM {$_M['table']['admin_array']} WHERE id='{$id}' and lang='{$_M['lang']}' ";
                        DB::query($query1);*/

                        $this->deltePayGroup($id);
                    }
                }
            }

        }
        cache::del('user', 'file');

        $redata['status'] = 1;
        $redata['msg'] = $_M['word']['jsok'];
        return $redata;
    }

    /**
     * 更新付费用戶组
     * @param string $groupid
     * @param string $pricr
     * @param string $buyok
     * @param string $recharge_price
     * @param string $rechargeok
     */
    public function updatePayGroup($groupid = '' , $pricr = '',$buyok = '', $recharge_price = '', $rechargeok = '')
    {
        global $_M;
        $query = "SELECT * FROM {$_M['table']['user_group_pay']} WHERE 
                        groupid = '{$groupid}' AND 
                        lang = '{$_M['lang']}'";
        $group_pay = DB::get_one($query);
        if ($group_pay) {
            $query = "UPDATE {$_M['table']['user_group_pay']} SET 
                            price = '{$pricr}', 
                            buyok = '{$buyok}',
                            recharge_price = '{$recharge_price}',
                            rechargeok = '{$rechargeok}' 
                            WHERE groupid = '{$groupid}' AND 
                            lang = '{$_M['lang']}'";
            DB::query($query);
        } else {
            $query = "INSERT INTO {$_M['table']['user_group_pay']} SET 
                            groupid = '{$groupid}',
                            recharge_price = '{$recharge_price}',
                            price = '{$pricr}',
                            buyok = '{$buyok}',
                            rechargeok = '{$rechargeok}',
                            lang = '{$_M['lang']}'";
            DB::query($query);
        }
    }

    /**
     * 删除付费用户组
     * @param string $groupid
     */
    public function deltePayGroup($groupid = '')
    {
        global $_M;
        $query = "DELETE FROM {$_M['table']['user_group_pay']} WHERE groupid='{$groupid}' and lang='{$_M['lang']}' ";
        DB::query($query);
        return;
    }

    public function get_paygroup_by_id($groupid)
    {
        global $_M;
        $query = "SELECT * FROM {$_M['table']['user_group_pay']} WHERE groupid = '{$groupid}'";
        return DB::get_one($query);
    }

    public function get_group_by_id($groupid)
    {
        global $_M;
        $query = "SELECT * FROM {$_M['table']['user_group']} WHERE id = '{$groupid}'";
        return DB::get_one($query);
    }

    public function get_paygroup_list_buyok()
    {
        global $_M;
        $query = "SELECT * FROM {$_M['table']['user_group_pay']} WHERE buyok = 1 ORDER BY price ";
        $res = DB::get_all($query);
        foreach ($res as $val) {
            $query = "SELECT * FROM {$_M['table']['user_group']} WHERE id = '{$val['groupid']}' AND  lang ='{$_M['lang']}'";
            $ugroup = DB::get_one($query);
            $val['name'] = $ugroup['name'];
            $val['access'] = $ugroup['access'];
            $paygroup_list[] = $val;
        }
        return $paygroup_list;
    }

    public function get_paygroup_list_recharge()
    {
        global $_M;
        $query = "SELECT * FROM {$_M['table']['user_group_pay']} WHERE rechargeok = 1 ORDER BY recharge_price ";
        $res = DB::get_all($query);
        foreach ($res as $val) {
            $query = "SELECT * FROM {$_M['table']['user_group']} WHERE id = '{$val['groupid']}' AND  lang ='{$_M['lang']}'";
            $ugroup = DB::get_one($query);
            $val['name'] = $ugroup['name'];
            $val['access'] = $ugroup['access'];
            $paygroup_list[] = $val;
        }
        return $paygroup_list;
    }

}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>