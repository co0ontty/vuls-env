<?php

class tags_tag extends tag {
    // 必须包含Tag属性 不可修改
    public $config = array(
        'list'     => array( 'block' => 1, 'level' => 4 ),
    );

    public function _list( $attr, $content ) {
        global $_M;
        $word    = isset($attr['word']) ? $attr['word'] : '';
        $php    = <<<str
<?php
    \$tags_list = load::sys_class('label', 'new')->get('tags')->get_tags_list(\$data);
    \$sub = count(\$result);
     foreach(\$tags_list as \$index=>\$v):
       
?>
str;
        $php .= $content;
        $php .= '<?php endforeach;?>';
        return $php;
    }

}