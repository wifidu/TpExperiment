<?php
namespace app\blog\controller;

use think\Controller;
use think\facade\Request;
use think\facade\Session;

class Index extends Controller
{
    public function index(){
        $this->assign([
            'Title' => '首页',
            'UserName'=> Session::get('NickName')
        ]);
        return $this->fetch();
    }

}
