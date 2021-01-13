<?php

class message_tag extends tag {
    // 必须包含Tag属性 不可修改
    public $config = array(
        'form'     => array( 'block' => 1, 'level' => 4 ),
        'list'     => array( 'block' => 1, 'level' => 4 ),
    );


    public function _form( $attr, $content ) {
        global $_M;
        $cid = isset( $attr['cid'] ) ? ( $attr['cid'][0] == '$' ? $attr['cid']
            : "'{$attr['cid']}'" ) : 0;
        $php = <<<str
<?php
    \$cid= $cid;
    \$cid= \$cid ? \$cid : \$data['classnow'];
    \$result = load::sys_class('label', 'new')->get('message')->get_module_form_html(\$cid);
    echo \$result;
?>
str;
        return $php;

    }


    public function _list( $attr, $content ) {
        global $_M;
        $cid    = isset( $attr['cid'] ) ? ( $attr['cid'][0] == '$' ? $attr['cid']
            : "'{$attr['cid']}'" ) : 0;
        $order  = isset($attr['order']) ? $attr['order'] : 'no_order';
        $num    = isset($attr['num']) ? $attr['num'] : 10;
        $php    = <<<str
<?php
    \$cid = $cid;
    if(\$cid == 0){
        \$cid = \$data['classnow'];
    }
    \$num = $num;
    \$order = "$order";
    \$result = load::sys_class('label', 'new')->get('message')->get_list_page(\$cid, \$data['page']);

    \$sub = count(\$result);
     foreach(\$result as \$index=>\$v):
        \$v['sub']      = \$sub;
        \$v['_index']   = \$index;
        \$v['_first']   = \$index == 0 ? true:false;
        \$v['_last']    = \$index == (count(\$result)-1) ? true : false;
        \$v['met_fd_content'] = load::sys_class('label', 'new')->get('message')->get_module_value('met_fd_content',\$cid);
        
?>
str;
        $php .= $content;
        $php .= '<?php endforeach;?>';
        return $php;
    }
}
