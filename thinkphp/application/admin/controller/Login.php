<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2019/10/9
 * Time: 9:42
 */

namespace app\admin\controller;


use think\Db;
use think\Controller;
use think\Session;

class Login extends Controller
{
  public function index(){
      return view();
  }
  public function check(){ //判断密码
      if (!$this->request->ispost()) {
          return json(['code' => 404, 'msg' => '请求方式错误']);
      }
      $data = input('post.');

      $username = $data['username'];
//      $password = md5(crypt($data['password'],md5('qyt')));
      $password = crypt($data['password'],md5('qyt'));

      $result = Db::table('manager')->where(['username'=>$username,'password'=>$password])->find();

//      print_r($result['username']);

      if($result){
          Session::set('user',$result['username']);//赋值，当前作用域
          return json([
              'code'=>200,
              'msg'=>'登录成功'
          ]);
      }else{
          return json([
              'code'=>404,
              'msg'=>'登录失败'
          ]);
      }


  }
}