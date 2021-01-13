<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::sys_class('database');

/**
 * 系统标签类
 */

class admin_op {

  public function modify_admin_column_accsess($column_id) {
    global $_M;
      if (is_numeric($column_id)) {
          $admin_id = $_M['user']['admin_id'];
          $query = "SELECT * FROM {$_M['table']['admin_table']} WHERE id = '{$admin_id}'";
          $admin =  DB::get_one($query);
          if ($admin && $admin['admin_type'] != 'metinfo' && $admin['admin_group'] != 10000) {
              $admin_type = explode('-',trim($admin['admin_type'],'-'));
              $column_sty = 'c' . $column_id;
              $admin_type[] = $column_sty;
              $admin_type = implode('-', $admin_type);
              $admin_type = "-$admin_type-";

              $query = "UPDATE {$_M['table']['admin_table']} SET `admin_type` = '{$admin_type}' WHERE id = $admin_id";
              DB::query($query);
          }
      }
  }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
