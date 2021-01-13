<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved. 

defined('IN_MET') or exit('No permission');

class csv {
	
/**
 * csv文件生成
 * $filename 文件名称，不要带 .csv
 * $array    表格内容，二位数组
 * $head     列名称，一维数组
 * $foot     底部追加内容，一般用于统计，一维数组
 */
	public function get_csv($filename, $array, $head, $foot = array()) {
	
		// 输出Excel文件头
		header ( 'Content-Type: application/vnd.ms-excel' );
		header ( 'Content-Disposition: attachment;filename="'.$filename.'.csv"' );
		header ( 'Cache-Control: max-age=0' );
		
		// 打开PHP文件句柄，php://output 表示直接输出到浏览器
		$fp = fopen ( 'php://output', 'a' );
		
		// 输出Excel列名信息
		foreach ( $head as $i => $v ) {
			// CSV的Excel支持GBK编码，一定要转换，否则乱码
			$head [$i] = iconv ( 'utf-8', 'gbk', $v );
		}
		
		// 将数据通过fputcsv写到文件句柄
		fputcsv ( $fp, $head );
		
		// 计数器
		$cnt = 0;
		// 每隔$limit行，刷新一下输出buffer，不要太大，也不要太小
		$limit = 8000;
		foreach ( $array as $row ) {
			$cnt ++;
			if ($limit == $cnt) { // 刷新一下输出buffer，防止由于数据过多造成问题
				ob_flush ();
				flush ();
				$cnt = 0;
			}
			$content = array ();
			foreach ( $head as $i => $v ) {
				$content [] = iconv ( 'utf-8', 'gbk', $row [$i]);
			}
			fputcsv ( $fp, $content );
		}
		
		if($foot){
			foreach ($foot as $i => $v ) {
				$foot[$i] = iconv ( 'utf-8', 'gbk', $v );
			}
			fputcsv ( $fp, $foot);
		}
		
	}
	
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>