<?php
namespace app\blog\controller;

use app\common\controller\Base;
use think\facade\Request;
use think\facade\Session;

class Index extends Base
{
    public function index(){
        $auth = Session::get('user_auth');
        $this->assign([
            'Title' => '首页',
            'UserName'=>$auth['nickname'],
        ]);
        return $this->fetch();
    }

}
