<?php


namespace app\common\controller;


use think\Controller;
use think\facade\Session;
class Base extends Controller{



    //防止重复登录
    public function isLgoin(){
        if(Session::has('NickName')){
            $this->error('您已经登录了。','index/index');
        }
    }
    public function noLogin(){
        if(!Session::has('NickName')){
            $this->error('请你先登录。','index/index');
        }
    }
}