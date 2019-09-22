<?php


namespace app\blog\model;

use app\common;
use think\Model;

class Blog extends Model {
	protected $autoWriteTimestamp = true;//开启自动时间戳
	//定义时间戳字段名：默认为create_time 和 create_time,如果一致可省略
	//如果想关闭某个时间戳字段，将值设置为false即可：$create_time = false
	protected $createTime = 'create_time';//创建时间字段
	protected $updateTime = 'update_time';//更新时间按字段
	protected $dateFormat = 'Y年m月d日';//时间字段取出后的默认时间格式
	//开启自动设置
	protected $auto = []; //无论是新增或更新都要设置的字段
	//仅新增的有效
	protected $insert = ['create_time','status'=>1,'is_top'=>0,'is_hot'=>0];
	//仅更新的有效
	protected $update = ['update_time'];

	public function blogSave($data){
	    $res = $this->create($data);
	    if(!$res){
            return msg('error',500,'保存失败');
        }else{
	        return msg('success',200,'发布成功');
        }
    }

}
