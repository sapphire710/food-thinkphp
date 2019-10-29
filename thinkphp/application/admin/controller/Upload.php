<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2019/10/11
 * Time: 15:45
 */

namespace app\admin\controller;


class Upload
{
    public function index()
    {
        //上传验证
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('file');
        if ($file) {
            $info = $file->validate(['size' => 200 * 1024, 'ext' => 'png,jpg,gif,webp'])
                ->move(ROOT_PATH . 'public' . DS . 'uploads');
            //POOT_PATH为常量，不用加$,框架应用根目录,可以自定义常量，在base.php中自定义
            //了一个常量UPLOAD_PATH，为/thinkphp/public/uploads
            // 移动到框架应用根目录/public/uploads/ 目录下
            if ($info) {
                // 成功上传后 获取上传信息
                // 输出 jpg
                // echo $info->getExtension();
                // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
                  $src = UPLOAD_PATH .$info->getSaveName();
                // 输出 42a79759f284b767dfcb2a0197904287.jpg
                // echo $info->getFilename();
                return json([
                   'code'=>0,
                    'msg'=>'上传成功',
                    'data'=>[
                        'src'=>$src,
                    ]
                ]);
            } else {
                // 上传失败获取错误信息
                echo $file->getError();
            }
        }


    }
}