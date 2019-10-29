<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2019/10/24
 * Time: 23:06
 */

namespace app\index\controller;


use think\Controller;
use think\Db;

class Newschild extends Controller

{
    public function index()
    {
        $nid = $this->request->get('nid');

        $news = Db::table('news')->where('nid', $nid)->find();
        $this->assign('newschild', $news);



        //上一页left
        $newid1=Db::table('news')->where('nid','<',$nid)->max('nid');
        $min=Db::table('news')->min('nid');
        $left = Db::table('news')->where('nid',$newid1)->find();
        $ntitle1 = $left['ntitle'];
        $id1=$left['nid'];
        if($left){
            $this->assign('ntitle1', $ntitle1);
            $this->assign('id1', $id1);
        }else{
            $this->assign('ntitle1', '没有啦！');
            $this->assign('id1', $min);
        }
        //下一页right
        $newid2=Db::table('news')->where('nid','>',$nid)->min('nid');
        $max=Db::table('news')->max('nid');
        $right = Db::table('news')->where('nid',$newid2)->find();
        $ntitle2 = $right['ntitle'];
        $id2=$right['nid'];
        if($right){
            $this->assign('ntitle2', $ntitle2);
            $this->assign('id2', $id2);
        }else{
            $this->assign('ntitle2', '没有啦！');
            $this->assign('id2', $max);
        }

        $id = $this->request->get('id');
        $news = Db::table('nav')->order('nsort', 'desc')->select();
        $this->assign('nav', $news);
        $this->assign('id', $id);

        return $this->fetch();
    }
}