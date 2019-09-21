<?php


namespace app\blog\controller;

use think\facade\Session;
use app\common\controller\Base;

class Code extends Base{
    public function index(){
        $this->noLogin();
        $auth = Session::get('user_auth');
        $this->assign([
            'Title' => '新建笔记',
            'UserName'=>$auth['nickname'],
        ]);
        return $this->fetch();
    }
    public function blog(){
        $auth = Session::get('user_auth');
        $this->assign([
            'Title' => '新建博文',
            'UserName'=>$auth['nickname'],
        ]);
        return $this->fetch();
    }
}