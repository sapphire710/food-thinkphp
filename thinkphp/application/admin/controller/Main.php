<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2019/10/9
 * Time: 16:21
 */

namespace app\admin\controller;

use think\Session;


class Main extends Base
{
    public function index(){
        $username= Session::get('user');
        $this->assign('user',$username);
        return view();
    }
}