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
        $this->assign([
            'Title' => '新建笔记',
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
        $this->noLogin();
        $cateList = Cate::all();
        $this->assign([
            'Title' => '新建博文',
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
    public function blogStar(BlogModel $blogModel){
        $status = $this->noLogin();
        if($this->noLogin()){
            return $status;
        }elseif(Request::isAjax()){
            $data = Request::post();
            $data['uid'] = (int)$data['uid'];
            $data['bid'] = (int)$data['bid'];
            $data['authId'] = (int)$data['authId'];
            $data['status'] = (int)$data['status'];
//            return msg('asd',1,'asdas');
            return $blogModel->blogStar($data['bid'],$data['uid'],$data['authId'],$data['status']);
        }
    }
    public function blogSearch(){
        $blogMap = Request::get('search');
        $blogList = BlogModel::where('title','like','%'.$blogMap.'%')->order('id', 'desc')->paginate(10);
        $this->assign([
           'blogList'=>$blogList,
            'Title'=>'搜索结果',
        ]);
        return $this->fetch('blogSearch');
    }
}
