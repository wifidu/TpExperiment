<?php


namespace app\blog\model;

use app\blog\model\User;
use app\common;
use think\Db;
use think\Model;

class Blog extends Model {
	protected $autoWriteTimestamp = true;//开启自动时间戳
	//定义时间戳字段名：默认为create_time 和 create_time,如果一致可省略
	//如果想关闭某个时间戳字段，将值设置为false即可：$create_time = false
	protected $createTime = 'create_time';//创建时间字段
	protected $updateTime = 'update_time';//更新时间按字段
	protected $dateFormat = 'Y-m-d- H:i:s';//时间字段取出后的默认时间格式
	//开启自动设置
	protected $auto = []; //无论是新增或更新都要设置的字段
	//仅新增的有效
	protected $insert = ['create_time','status'=>1,'is_top'=>0,'is_hot'=>0];
	//仅更新的有效
	protected $update = ['update_time'];

	public function blogSave($data){
	    $res = $this->create($data);
	    if(!$res){
            return msg('error',500,'保存失败');
        }else{
	        User::where('Uid',$data['user_id'])->inc('BlogCount')->update();
	        return msg('success',200,'发布成功');
        }
    }

    public function blogFind($blogId){
        $blog = $this->where('id',($blogId))->find();
        $auth = User::where('Uid',($blog['user_id']))->find();
        $blog['auth'] = $auth['NickName'];
        $blog['authImg'] = $auth['UserImg'];
        $blog['blogCount'] = $auth['BlogCount'];
        $blog['stars'] = $auth['stars'];
        $blog['fans'] = $auth['Fans'];
        $blog['collection'] = $auth['collection'];
        $blog['starStatus'] =  UserStar::where('uid',session('user_auth.uid'))->where('bid',$blogId)->find()?1:0;
        $blog['collectStatus'] =  Db::table('think_user_collection')->where('uid',session('user_auth.uid'))->where('bid',$blogId)->find()?1:0;
//        $bd = array_merge($auth,$blog);//后来居上???????????????/
        return $blog;
    }
    public function blogStar($blogId,$uid,$auth,$status){
	    if(!$status){
	        try{
                $res0 = User::where('Uid',$auth)->inc('stars')->update();
                $res1 = Blog::where('id',$blogId)->inc('stars')->update();
                $res2 = UserStar::create(['uid'=>$uid,'bid'=>$blogId]);
            }catch (\Exception $e){
                return msg('error',500,$e->getMessage());
            }
            if($res0 and $res1 and $res2)
                return msg('success',1,'成功');
            else return msg('error',500,'点赞失败');
        }else{
            $res0 = User::where('Uid',$auth)->dec('stars')->update();
            $res1 = Blog::where('id',$blogId)->dec('stars')->update();
            $res2 = UserStar::where('uid',$uid)->where('bid',$blogId)->delete();
            if($res0 and $res1 and $res2)
                return msg('success',1,'成功');
            else return msg('error',500,'取消点赞失败');
        }
    }
    public function blogCollect($blogId,$uid,$auth,$status){
        if(!$status){
            try{
                $res0 = User::where('Uid',$auth)->inc('collection')->update();
                $res1 = Blog::where('id',$blogId)->inc('collection')->update();
                $res2 = Db::name('UserCollection')->insert(['uid'=>$uid,'bid'=>$blogId]);
            }catch (\Exception $e){
              return msg('error',500,$e->getMessage());
            }
            if($res0 and $res1 and $res2)
                return msg('success',1,'成功');
            else return msg('error',500,'收藏失败');
        }else{
            $res0 = User::where('Uid',$auth)->dec('collection')->update();
            $res1 = Blog::where('id',$blogId)->dec('collection')->update();
            $res2 = Db::name('UserCollection')->where('uid',$uid)->where('bid',$blogId)->delete();
            if($res0 and $res1 and $res2)
                return msg('success',1,'成功');
            else return msg('error',500,'取消收藏失败');
        }
    }
    public function blogAllFind($uid){
        $blogList = $this
            ->where('user_id', $uid)
            ->order('id', 'desc')
            ->paginate(10);
        $userData = User::get($uid);
        $userData['blogList'] = $blogList;
        return $userData;
    }
    public function blogCollectFind($uid){
        $bids = Db::table('think_user_collect')->where('uid',$uid)->column('bid');
    }

}
