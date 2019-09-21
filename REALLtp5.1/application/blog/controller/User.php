<?php

namespace app\blog\controller;

use app\common\controller\Base;
use http\Message;
use think\Request;
use app\blog\model\User as UserModel;
use think\facade\Session;
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
            $validate = new UserValidate;
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
    public function userData(){
        $auth = Session::get('user_auth');
        $this->assign([
            'Title' => '首页',
            'UserName'=>$auth['nickname'],
        ]);
        return $this->fetch('userdata');
    }
}
