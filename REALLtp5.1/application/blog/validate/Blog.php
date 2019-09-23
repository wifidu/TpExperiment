<?php

namespace app\blog\validate;

use think\Validate;

class Blog extends Validate
{
	protected $rule = [
	    'title|标题' => 'require|length:3,50',
	    'content|文章内容' => 'require',
//        'user_id|作者' => 'require',
        'cate_id|栏目名称' => 'require',
    ];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [];
}
