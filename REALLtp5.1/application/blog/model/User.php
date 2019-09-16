<?php


namespace app\blog\model;


use think\Model;

class User extends Model {
   // protected $pk = 'id';//默认主键 
   // protected $table = 'think_user';//默认数据表
   protected $autoWriteTime = true;
   //protected $createTime = 'create_time';
   //protected $updateTime = 'update_time';
   //protected $dataFormat = 'Y年m月d日';
   //获取器(自动获取。无需调用)
//   public function getStatusAttr($value){
//        $status = ['1' => '启用', '0' => '禁用'];
//        return $status[$value];
//   }
//   public function getIsAdminAttr($vakue){
//        $status = ['1' => '管理员','0' => '注册会员'];
//        return $status[$value];
//   }
//   //修改器
//   public function setPasswordAttr($value){
//        return sha1($value);
//   }
}
