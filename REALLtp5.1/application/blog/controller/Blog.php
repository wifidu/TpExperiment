<?php
////

namespace app\blog\controller;

use think\facade\Session;
use app\common\controller\Base;
use app\blog\model\Cate;
use think\facade\Request;
use app\blog\model\Blog as BlogModel;

class Blog extends Base{
    /**
     * @return mixed
     * @auther 杜韦凡 <875147715@qq.com>
     * @time:2019/9/22 下午7:03
     */
    public function index(){
        $this->noLogin();
        $auth = Session::get('user_auth');
        $this->assign([
            'Title' => '新建笔记',
            'UserName'=>$auth['nickname'],
        ]);
        return $this->fetch();
    }

    /**
     * 进入新建博客页面
     * @return mixed
     * @auther 杜韦凡 <875147715@qq.com>
     * @time:2019/9/22 下午7:03
     */
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

    /**
     * 保存blog数据
     * @param BlogModel $blogModel
     * @return false|string
     * @auther 杜韦凡 <875147715@qq.com>
     * @time:2019/9/22 下午7:03
     */
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
