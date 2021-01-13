<?php

class online_tag extends tag {
    // 必须包含Tag属性 不可修改
    public $config = array(
        'list'     => array( 'block' => 1, 'level' => 4 ),
    );


    public function _list( $attr, $content ) {
        global $_M;
        $type = $attr['type'] ? $attr['type'] : 1;

        $php    = <<<str
<?php
    \$type = '$type';
    \$result = load::mod_class('online/online_label', 'new')->getOnlineList(\$type);
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

}
