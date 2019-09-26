<?php


namespace app\blog\model;

use app\common\Md5;
use think\facade\Env;
use think\Model;

class User extends Model {
    //默认主键
    protected $pk = 'Uid';
    //默认数据表
    protected $table = 'think_user';
    //自动写入时间戳
    protected $autoWriteTime = true;
    //设置自动写入时间戳字段名
    //设置自动写入时间戳字段名
    protected $createTime = 'CreateTime';
    protected $updateTime = 'UpdateTime';
    //设置时间输出格式
    protected $dataFormat = 'Y年m月d日';
    //获取器(自动获取。无需调用)
    public function getStatusAttr($value){
        $status = ['1' => '启用', '0' => '禁用'];
        return $status[$value];
   }
   public function getIsAdminAttr($value){
        $status = ['1' => '管理员','0' => '注册会员'];
        return $status[$value];
   }
   //对密码进行加密
   public function setPasswordAttr($value){
        return Md5::Make($value);
   }
   //获取注册ip
    public function setSignupIpAttr(){
        return get_client_ip(1);
    }

    /**
     * @param string $username
     * @param string $password
     * @param bool $rememberme
     * @return bool|false|string
     * @auther 杜韦凡 <875147715@qq.com>
     * @time:2019/9/21 下午12:46
     */

    public function login($username = '', $password = '', $rememberme = false)
    {
        // 匹配登录方式
        if (preg_match("/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/", $username)) {
            // 邮箱登录
            $map['Email'] = $username;
        } elseif (preg_match("/^1\d{10}$/", $username)) {
            // 手机号登录
            $map['Mobile'] = $username;
        } else {
            // 用户名登录
            $map['NickName'] = $username;
        }
        $map['status'] = 1;
        // 查找用户
        $user = $this->get($map);
        if (!$user) {
            return msg('error',500,"用户不存在或被禁用");
        } else {
            if (!Md5::check((string)$password, $user['Password'])) {
                return msg('error',500,"密码错误");
            } else {
                $uid = $user['Uid'];
                // 更新登录信息
                $user['LastLoginTime'] = request()->time();
                $user['LastLoginIp']   = request()->ip(1);
                if ($user->save()) {
                    // 自动登录
                    return $this->autoLogin($this::get($uid), $rememberme);
                } else {
                    // 更新登录信息失败
                    return msg('error',500,"保存数据错误");
                }
            }
        }
    }
    public function autoLogin($user, $rememberme = false)
    {
        // 记录登录SESSION和COOKIES
        $auth = array(
            'uid'             => $user->Uid,
            'nickname'        => $user->NickName,
            'last_login_time' => $user->LastLoginTime,
            'last_login_ip'   => get_client_ip(1),
            'userImg'         => '/uploads/'.$user->UserImg,
        );
        session('user_auth', $auth);
        session('user_auth_sign', data_auth_sign($auth));

        // 记住登录
//        if ($rememberme) {
//            $signin_token = $user->username.$user->id.$user->last_login_time;
//            cookie('uid', $user->id, 24 * 3600 * 7);
//            cookie('signin_token', data_auth_sign($signin_token), 24 * 3600 * 7);
//        }
//        return $user->id;\
        return msg('success',200,"成功登录");
    }

    /**
     * @param $data
     * @return false|string
     * @auther 杜韦凡 <875147715@qq.com>
     * @time:2019/9/21 下午2:16
     */
    public function registSave($data){
        $result = $this->allowField(true)->create($data);
        if(!$result){
            return msg('error',-1,"注册失败");
        }else{
            return msg('success',1,"注册成功");
        }
    }

    public function imgSave($uid,$imgPath){
        $user = $this->get($uid);
        $oldPath = $user->UserImg;
            if ($oldPath!=null ? !unlink(Env::get('root_path')."public/uploads/".$oldPath) : false) {
                return msg('error',500,"Error deleting ");
            }else {
            $user->UserImg = $imgPath;
            if(!$user->save()){
                return msg('error',500,'修改失败');
            }
            return msg('success',200,'修改成功');
        }
    }
}
