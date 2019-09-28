<?php
namespace app\blog\controller;

use app\common\controller\Base;
use think\exception\DbException;
use think\facade\Request;
use think\facade\Session;
use app\blog\model\Blog ;

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

}
