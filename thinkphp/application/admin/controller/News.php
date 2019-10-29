<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2019/10/9
 * Time: 9:43
 */

namespace app\admin\controller;



use think\Controller;
use think\Db;

class News extends Base
{
    //查看导航
    public function index()
    {
        return $this->fetch();//引页面，前提是要引入controller
    }

    //展示插入页面
    public function openinsert()
    {
        return view();
    }

    //查看页面，渲染数据
    public function query()
    {
        $data = Db::table('news')->select();
        $count = Db::table('news')->count();//拿到个数
        return json([
            'code' => 0,
            'msg' => '查看成功',
            'data' => $data,
            'count' => 1000,
        ]);
    }

    //删除导航
    public function delete()
    {
//        验证请求方式
        if (!$this->request->isPost()) {
            return json(['code' => 404, 'msg' => '请求方式错误']);
        }
        $data = input('post.');
        $result = Db::table('news')->where('nid', $data['nid'])->delete();
        if ($result) {
            return json([
                'code' => 200,
                'msg' => '导航删除成功'
            ]);
        } else {
            return json([
                'code' => 404,
                'msg' => '导航删除失败'
            ]);
        }
    }

    //修改导航
    public function update()
    {
        if (!$this->request->isPost()) {
            return json(['code' => 404, 'msg' => '请求方式错误']);
        }
        $data = input('post.');

        $result = Db::table('news')->where('nid', $data['nid'])->update([$data['field']=>$data['value']]);
        if ($result > 0) {
            return json([
                'code' => 200,
                'msg' => '导航修改成功'
            ]);
        } else {
            return json([
                'code' => 404,
                'msg' => '导航修改失败'
            ]);
        }
    }

    //添加导航
    public function insert()
    {
//权限、请求方式、参数
        $method = $this->request->method();//面向对象,需要继承Controller类
//        $method = request()->method();//助手函数request
        if ($method != 'POST') {
            return json(['code' => 404, 'msg' => '请求方式错误']);
        }
        $data = input('post.');

        date_default_timezone_set('Asia/Shanghai');
        $data['create_time'] = date('Y-m-d h:i:s');//date格式化日期，(格式、)当前时间
        // $data = $_POST;
        $result = Db::table('news')->insert($data);
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

}