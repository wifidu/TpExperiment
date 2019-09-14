<?php

namespace app\blog\controller;

use http\Message;
use think\Controller;
use think\facade\Request;
use app\blog\model\User as UserModel;
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
    public function index()
    {
        //
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
    public function save(Request $request)
    {
        if(Request::isAjax()){
            //使用模型创建数据
            $data = Request::except('Confirm','post');
            if(UserModel::create($data)){
                return ['status'=>1,'message'=>"注册成功！"];
            }else{
                return ['status'=>0,'message'=>"注册失败！"];
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
