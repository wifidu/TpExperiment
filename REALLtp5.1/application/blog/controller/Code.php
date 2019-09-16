<?php


namespace app\blog\controller;

use think\facade\Session;
use app\common\controller\Base;

class Code extends Base{
    public function index(){
        $this->noLogin();
        $this->assign('UserName',Session::get('NickName'));
        return $this->fetch();
    }
}