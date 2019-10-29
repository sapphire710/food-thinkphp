<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2019/10/14
 * Time: 16:00
 */

namespace app\index\controller;


use think\Db;
use think\Controller;

class Base extends Controller
{
    public function _initialize(){
        parent::_initialize();
        $nav = Db::table('nav')->order('nsort','desc')->select();
        $this->assign('nav', $nav);
    }
}