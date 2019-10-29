<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2019/10/8
 * Time: 17:57
 */

namespace app\index\controller;


use think\Db;

class Category extends Base
{
    public function xiangqing()
    {
        //基本渲染页面内容
        $id = $this->request->get('id');//页码id
        $gid = $this->request->get('gid');//商品id
        $newgid = Db::table('goods')->where('gid', $gid)->find();
        $banner = explode(',',$newgid['gbanner']);//banner
        $this->assign('banner', $banner);

        //开启header
        $news = Db::table('nav')->order('nsort', 'desc')->select();
        $this->assign('nav', $news);
        $this->assign('id', $id);
        $this->assign('goods', $newgid);

        //实现上一页，下一页
//        $str='';
        //上一页left
        $newid=Db::table('goods')->where('gid','<',$gid)->max('gid');
        $min=Db::table('goods')->min('gid');
        $left = Db::table('goods')->where('gid',$newid)->find();
        $gname = $left['gname'];
        $gid1=$left['gid'];
        if($left){
            $this->assign('gname', $gname);
            $this->assign('gid1', $gid1);
        }else{
            $this->assign('gname', '没有啦！');
            $this->assign('gid1', $min);
        }
        //下一页right
        $newsid=Db::table('goods')->where('gid','>',$gid)->min('gid');
        $max=Db::table('goods')->max('gid');
        $right = Db::table('goods')->where('gid',$newsid)->find();
        $gnames = $right['gname'];
        $gids=$right['gid'];
        if($right){
            $this->assign('gnames', $gnames);
            $this->assign('gids', $gids);
        }else{
            $this->assign('gnames', '没有啦！');
            $this->assign('gids', $max);
        }


        return $this->fetch();

    }

    public function index()
    {
        //点击那条nav就传相应的id
        $id = $this->request->get('id');
        $currentnav = Db::table('nav')->where('id', $id)->find();
        $tpl = $currentnav['ntpl'];
        $this->assign('title', $currentnav['nname']);


        $goods = Db::table('goods')->select();
        $currentcate = Db::table('category')->select();
        $news = Db::table('news')->select();

        /*  $nnav = Db::table('nav')->select();
          foreach ($nnav as $key => $value) {
              $this->assign('id', $value['id']);
          }*/

        switch ($tpl) {
            case 'News';
                $this->assign('news', $news);
                break;
            case 'Products';
                $len = count($currentcate);
                for ($i = 0; $i < $len; $i++) {
                    $items = $currentcate[$i];
                    $id = $items['num'];
                    if ($i == 0) {
                        $currentcate[$i]['goods'] = $goods;
                        continue;
                    }
                    $good = array_filter($goods, function ($v) use ($id) {
                        return $v['cid'] == $id;
                    });
                    $currentcate[$i]['goods'] = $good;
                }
                $this->assign('goods', $good);
                $this->assign('cate', $currentcate);
                break;
        }

        $news = Db::table('nav')->order('nsort', 'desc')->select();
        $this->assign('nav', $news);
        $this->assign('id', $id);

        return $this->fetch($tpl);
    }

}