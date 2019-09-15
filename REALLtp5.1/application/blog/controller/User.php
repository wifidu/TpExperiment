<?php

namespace app\blog\controller;

use http\Message;
use think\Controller;
use think\facade\Request;
use app\blog\model\User as UserModel;
use think\facade\Session;
use think\Url;
use think\facade\Validate;

class User extends Controller
{
    public function login(){
        $this->assign('Title',"用户登录");
        return $this->fetch();
    }
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function check()
    {
        $rule = [
            'Email' => 'require',
            'Password' => 'require',
        ];

        $msg = [
            'Email.require' => '亲，你忘了写邮箱了。。。',
            'Password.require' => '亲，你忘了写密码了。。。',
        ];
        $validate   = Validate::make($rule,$msg);

        $data = Request::post();
        $result = $validate->check($data);

        if(!$result) {
            return ['status' => -1,'message'=>$validate->getError()];
        }else{
            $model = new UserModel();
            $personal = $model->where('Email',$data['Email'])->find();
            if(!$personal){
                return ['status' => -1,'message' => "邮箱不存在"];
            }elseif($data['Password']!==$personal['Password']){
                return ['status' => -1,'message' => "密码错误"];
            }else{
                Session::set('NickName',$personal['NickName']);
                Session::set('Email',$personal['Email']);
                return ['status' => 1,'message' => "登录成功"];
            }
        }
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function regist()
    {
        $this->assign('Title',"用户注册");
        return $this->fetch();
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save()
    {
        if(Request::isAjax()){
            //使用模型创建数据
            $data = Request::post();
            $rule = 'app\blog\validate\User';//自定义和的验证规则
            $res = $this->validate($data,$rule);
//            dump($res);
            if(true !== $res){
                return ['status' => -1 ,'message'=> $res ];
            }else{//true
                    $data = Request::except('Password_confirm','post');
                    $data['RegistrationTime'] = time();
                    $data['LastLoginTime'] = time();
                    if(UserModel::create($data)){
                        return ['status'=> 1 ,'message'=>"注册成功！"];
                    }else{
                        return ['status'=> 0 ,'message'=>"注册失败！"];
                    }
                }
            }else{
            $this->error("请求类型错误",'registe');
        }
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }
}
