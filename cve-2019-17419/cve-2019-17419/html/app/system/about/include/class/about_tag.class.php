<?php

class about_tag extends tag {
    // 必须包含Tag属性 不可修改
    public $config = array(
        'list'     => array( 'block' => 1, 'level' => 4 ),
    );


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
    \$result = load::sys_class('label', 'new')->get('news')->get_list_page(\$cid, \$data['page']);
    \$sub = count(\$result);
     foreach(\$result as \$index=>\$v):
        \$v['sub']      = \$sub;
        \$v['_index']   = \$index;
        \$v['_first']   = \$index == 0 ? true:false;
        \$v['_last']    = \$index == (count(\$result)-1) ? true : false;
?>
str;
        $php .= $content;
        $php .= '<?php endforeach;?>';
        return $php;
    }

    public function _page( $attr, $content)
    {
        global $_M;

    }

}
