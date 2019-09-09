<?php
namespace app\index\controller;

use think\Db;
use think\Controller;
use think\Env;

class Index extends Controller
{
    public function index()
    {
        try{
           // $model = Db::table('think_student')->select();
	   // $data = Db::table('think_student')->where('title','信息工程')->page(1,3)->select();
	   // $data  = Db::table('think_student')->field('name,max(id)')->group('title')->select();
		//查找出相同title的最大id，并显示其姓名。
	   // $data  = Db::table('think_student')->field('id,name,count(*)')->group('name')->select();
     	   // $data = Db::name('student')->whereTime('date','>=','1900-10-1')->select();
	   //$data = Db::name('student')->whereTime('date','y')->select();
            $data = Db::name('students')->select();
            dump($data);
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }
	public function test()
	{
		$data = Env::get('think_path');
		dump($data);
		phpinfo();
		//return	$this->fetch();
	}
}
