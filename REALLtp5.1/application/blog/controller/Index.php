<?php
namespace app\blog\controller;

use app\common\controller\Base;
use think\facade\Request;
use think\facade\Session;

class Index extends Base
{
    public function index(){
        $this->assign([
            'Title' => '首页',
            'UserName'=>Session::has('NickName')?Session::get('NickName'):"游客",
        ]);
        return $this->fetch();
    }

}
