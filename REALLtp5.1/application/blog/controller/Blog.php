<?php
////

namespace app\blog\controller;

use think\facade\Session;
use app\common\controller\Base;
use app\blog\model\Cate;
use think\facade\Request;
use app\blog\model\Blog as BlogModel;

class Blog extends Base{
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
        $cateList = Cate::all();
        $this->assign([
            'Title' => '新建博文',
            'UserName'=>$auth['nickname'],
            'cateList'=>$cateList,
        ]);
        return $this->fetch();
    }
    public function blogSave(BlogModel $blogModel){
        if(Request::isAjax()){
            $blogData = Request::post();
            $res = $this->validate($blogData,'app\blog\validate\Blog');
            if(true !== $res){
                return msg('error',500,$res);
            }else{
                $saveResult = $blogModel->blogSave($blogData);
                return $saveResult;
            }
        }else{
            $this->error('请求类型错误！');
        }
    }
}
