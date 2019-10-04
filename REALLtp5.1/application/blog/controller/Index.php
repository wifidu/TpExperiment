<?php
namespace app\blog\controller;

use app\common\controller\Base;
use think\exception\DbException;
use think\facade\Request;
use think\facade\Session;
use app\blog\model\Blog ;
use app\blog\model\User;

class Index extends Base
{
    /**
     * @return mixed
     * @auther 杜韦凡 <875147715@qq.com>
     * @time:2019/9/22 下午7:31
     */
    public function index(){
        try {
            $blogList = Blog::where('status', '1')->order('id', 'desc')->paginate(10);
        } catch (DbException $e) {
            $this->error($e->getMessage());
        }
        $this->assign([
            'Title' => '首页',
            'blogList' =>$blogList,
        ]);
        return $this->fetch();
    }
    public function blogRead($blogId,Blog $blogModel){
        $blogData = $blogModel->blogFind($blogId);
        $this->assign([
            'Title' => $blogData->title,
            'Auth'=>$blogData['auth'],
            'authImg'=>'/uploads/'.$blogData['authImg'],
            'content'=>$blogData->content,
            'blogCount'=>$blogData['blogCount'],
            'fans'=>$blogData['fans'],
            'stars'=>$blogData['stars'],
            'bid'=>$blogId,
            'authId'=>$blogData['user_id'],
            'starStatus'=>$blogData['starStatus'],
            'collection'=>$blogData['collection'],
            'createTime'=>$blogData->create_time,
        ]);
        return $this->fetch('blogRead');
    }
    public function myBlog(Blog $blogModel){
        $uid = session('user_auth.uid');
        $userBlog = $blogModel->blogAllFind($uid);
        $this->assign([
            'Title' => '我的博客',
            'blogList' =>$userBlog['blogList'],
            'authImg'=>'/uploads/'.$userBlog['UserImg'],
            'nickname'=>$userBlog['NickName'],
            'blogCount'=>$userBlog['BlogCount'],
            'stars'=>$userBlog['stars'],
            'fans'=>$userBlog['Fans'],
            'collection'=>$userBlog['collection'],
        ]);
        return $this->fetch('myBlog');
    }
    public function othersBlog($authId,Blog $blogModel){
        $authBlog = $blogModel->blogAllFind($authId);
        $this->assign([
            'Title' => $authBlog['NickName'],
            'nickname'=>$authBlog['NickName'],
            'authImg'=>'/uploads/'.$authBlog['UserImg'],
            'fans'=>$authBlog['Fans'],
            'blogCount'=>$authBlog['BlogCount'],
            'stars'=>$authBlog['stars'],
            'authId'=>$authBlog['Uid'],
            'collection'=>$authBlog['collection'],
            'blogList'=>$authBlog['blogList'],
        ]);
        return $this->fetch('othersBlog');
    }

}
