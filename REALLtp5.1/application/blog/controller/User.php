<?php

namespace app\blog\controller;

use app\common\controller\Base;
use http\Message;
use think\facade\Env;
use think\Request;
use app\blog\model\User as UserModel;
use think\facade\Session;
use app\blog\model\Blog as BlogModel;
use app\blog\validate\User as UserValidate;
use think\facade\Validate;

class User extends Base
{
    /**
     * @return mixed
     * @auther 杜韦凡 <875147715@qq.com>
     * @time:2019/9/21 下午2:18
     */
    public function login(){
        $this->isLgoin();//防止重复登录
        $this->assign('Title',"用户登录");
        return $this->fetch();
    }

    /**
     * @return mixed
     * @auther 杜韦凡 <875147715@qq.com>
     * @time:2019/9/21 下午2:18
     */
    public function loginOut(){
        Session::clear();
		$this->assign('Title',"用户登录");
        return $this->fetch('user/login');
    }

    /**
     * 登录检测
     * @param UserModel $user
     * @return bool|false|string
     * @auther 杜韦凡 <875147715@qq.com>
     * @time:2019/9/21 下午1:56
     */
    public function loginCheck(Request $request, UserModel $user)
    {
        if($request->isAjax()){
            $data = $request->post();
            if($data['username'] == null or $data['Password'] == null) {
                return msg('error',500,"帐号密码不能为空");
            }else{
                $result = $user->login($data['username'],$data['Password']);
                return $result;
            }
        }else{
            $this->error("请求类型错误",'login');
        }
    }

    /**
     * 注册
     * @return mixed
     * @auther 杜韦凡 <875147715@qq.com>
     * @time:2019/9/21 下午2:18
     */
    public function regist()
    {
        $this->assign('Title',"用户注册");
        return $this->fetch();
    }

    /**
     * 保存注册帐号
     * @param Request $request
     * @param UserModel $user
     * @return false|string
     * @auther 杜韦凡 <875147715@qq.com>
     * @time:Times
     */
    public function registSave(Request $request,UserModel $user)
    {
        if($request->isAjax()){
            //使用模型创建数据
            $data = $request->post();
            $rule = 'app\blog\validate\User';//自定义和的验证规则
            $res = $this->validate($data,$rule);
            if(true !== $res){
                return msg('error',-1,$res);
            }else{//true
                    return $user->registSave($data);
                }
            }else{
            $this->error("请求类型错误",'regist');
        }
    }

    /**
     * 修改资料入口
     * @return mixed
     * @auther 杜韦凡 <875147715@qq.com>
     * @time:2019/9/24 下午6:40
     */
    public function userData(){
        $this->assign([
            'Title' => '个人信息',
        ]);
        return $this->fetch('userdata');
    }

    /**
     * 修改头像
     * @return mixed
     * @auther 杜韦凡 <875147715@qq.com>
     * @time:2019/9/24 下午6:54
     */
    public function userImg(){
        $this->assign([
            'Title' => '修改头像',
        ]);
        return $this->fetch('chimg');
    }

    /**
     * 保存头像
     * @auther 杜韦凡 <875147715@qq.com>
     * @time:2019/9/24 下午6:54
     */
    public function saveImg($uid,UserModel $user){
        if($this->request->isPost()){
            $file = request()->file('userImg');
            $info = $file->move( '../public/uploads');
            if($info){
                return $user->imgSave($uid,$info->getSaveName());
            }else{
                return msg('error',500,$file->getError());
            }
        }else{
            $this->error('请求类型错误.');
        }
        return msg('success',200,'保存成功');
    }

    /**
     * 用户收藏过得文章
     * @param BlogModel $blogModel
     * @return mixed
     * @auther 杜韦凡 <875147715@qq.com>
     * @time:Times
     */
    public function myCollect(BlogModel $blogModel){
        $uid = session('user_auth.uid');
        $blogCollectList = $blogModel->blogCollectFind($uid);
        $userData = UserModel::get($uid);
        $this->assign([
            'Title'=> session('user_auth.nickname').'|个人中心',
            'userTitle'=>$userData['NickName'].' 的收藏夹',
            'blogCollectList'=>$blogCollectList,
            'authImg'=>'/uploads/'.$userData['UserImg'],
            'nickname'=>$userData['NickName'],
            'blogCount'=>$userData['BlogCount'],
            'stars'=>$userData['stars'],
            'fans'=>$userData['Fans'],
            'collection'=>$userData['collection'],
        ]);
        return $this->fetch('myCollect');
    }
    public function myStar(BlogModel $blogModel){
        $uid = session('user_auth.uid');
        $blogStarList = $blogModel->blogStarFind($uid);
        $userData = UserModel::get($uid);
        $this->assign([
            'Title'=> session('user_auth.nickname').'|个人中心',
            'userTitle'=>$userData['NickName'].' 赞过的内容',
            'blogStarList'=>$blogStarList,
            'authImg'=>'/uploads/'.$userData['UserImg'],
            'nickname'=>$userData['NickName'],
            'blogCount'=>$userData['BlogCount'],
            'stars'=>$userData['stars'],
            'fans'=>$userData['Fans'],
            'collection'=>$userData['collection'],
        ]);
        return $this->fetch('myStarBlog');
    }
    public function myBlog(BlogModel $blogModel){
        $uid = session('user_auth.uid');
        $userBlog = $blogModel->blogAllFind($uid);
        $this->assign([
            'Title' => '我的博客',
            'userTitle'=>$userBlog['NickName'].' 的文章',
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
    public function myTweet(UserModel $userModel){
        $uid = session('user_auth.uid');
        $userTweet = $userModel->userTweet($uid);
        $userData = UserModel::get($uid);
        $this->assign([
            'Title' => '我的博客',
            'userTitle'=>$userData['NickName'].' 的动态',
            'authImg'=>'/uploads/'.$userData['UserImg'],
            'nickname'=>$userData['NickName'],
            'blogCount'=>$userData['BlogCount'],
            'stars'=>$userData['stars'],
            'fans'=>$userData['Fans'],
            'collection'=>$userData['collection'],
            'tweetList'=>$userTweet,
        ]);
        return $this->fetch('myTweet');
    }
}
