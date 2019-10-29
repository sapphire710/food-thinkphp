<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2019/10/11
 * Time: 11:08
 */

namespace app\admin\controller;

//use think\Controller;
use think\Db;

class Goods extends Base
{
//    开启-插入页面
    public function openinsert()
    {
        $cate = Db::table('category')->order('num', 'asc')->select();
        $this->assign('cates', $cate);//挂载变量,用的时候用前面的名字
        return $this->fetch();//引页面，前提是要引入controller
    }

//    插入数据
    public function insert()
    {
        $method = $this->request->method();//面向对象,需要继承Controller类
//        $method = request()->method();//助手函数request
        if ($method != 'POST') {
            return json(['code' => 404, 'msg' => '请求方式错误']);
        }
        $data = input('post.');
        //助手函数把验证器引进来、验证规则
        $validate = validate('Goods');
        if (!$validate->check($data)) { //验证场景
            return json(['code' => 404, 'msg' => $validate->getError()]);
        }
        // $data = $_POST;
//        unset($data['file']);
        date_default_timezone_set('Asia/Shanghai');
        $data['create_time'] = date('Y-m-d h:i:s');//date格式化日期，(格式、)当前时间
        $result = Db::table('goods')->insert($data);
        if ($result > 0) {
            return json([
                'code' => 200,
                'msg' => '导航插入成功'
            ]);
        } else {
            return json([
                'code' => 404,
                'msg' => '导航插入失败'
            ]);
        }
    }

    //开启-查看页面
    public function index()
    {
        $cate = Db::table('category')->order('id', 'asc')->select();
        $this->assign('cates', $cate);
        return $this->fetch();
        /*$cate = Db::table('category')->select();
        $this->assign('');
        return $this->fetch();//引页面，前提是要引入controller*/
    }

    //查看页面，渲染数据
    public function query()
    {
        //当触发搜索按钮后开启搜索条件，

//        $data = Db::table('goods')->order('gid','asc')->select();
//        $count =count($data);//拿到个数
//        分页功能，传输：数据总数，当前页的数据select * from goods where [] order by gid asc limit offset,length
//        $qs = $this->request->get();

        $qs = $this->request->get();

        $where = [];

        if (isset($qs['cid']) && !empty($qs['cid'])) {

            if($qs['cid']==1){
                $whereOr['cid']= 2 && $whereOr['cid']= 3 && $whereOr['cid']= 4 && $whereOr['cid']= 5;
            }else{
                $where['cid'] = $qs['cid'];
            }

        }



        if (isset($qs['price_min']) && !empty($qs['price_min']) && isset($qs['price_max']) && !empty($qs['price_max'])) {
            if ($qs['price_min'] >= 0 && $qs['price_max'] && $qs['price_min'] < $qs['price_max']) {
                $where['gsale'] = ['between', [$qs['price_min'], $qs['price_max']]];

            }
        }

        if (isset($qs['gname']) && !empty($qs['gname'])) {
            $where['gname'] = ['like', "%{$qs['gname']}%"];
        }


        $page = $qs['page'];
        $limit = $qs['limit'];
        $count = Db::table('goods')->where($where)->count();
        $data = Db::table('goods')->where($where)->page($page, $limit)->select();

        return json([
            'code' => 0,
            'count' => $count,
            'data' => $data,
            'msg' => '数据获取成功',
        ]);


//        $page = $qs['page'];
//        $limit = $qs['limit'];
//        $offset = ($page - 1) * $limit;
//        $count = Db::table('goods')->where($where)->count();
//        $data = Db::table('goods')->where($where)->limit($offset, $limit)->select();
////        $data = Db::table('goods')->where($where)->page($page,$limit)->select();
//        return json([
//            'code' => 0,
//            'msg' => '查看成功',
//            'data' => $data,
//            'count' => $count,
//        ]);
    }

}