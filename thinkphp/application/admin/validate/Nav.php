<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2019/10/10
 * Time: 16:15
 */

namespace app\admin\validate;


use think\Validate;

class Nav extends Validate
{
//验证器  规则
    protected  $rule =[
        'nname'=>'require',
        'ename'=>'require',
        'nsort'=>'require',
        'ntpl'=>'require',
        'id'=>'number',
        'field'=>'require',
        'value'=>'require',//require必填
    ];
    /*protected $message  =   [
        'name.require' => '名称必须',
        'name.max'     => '名称最多不能超过25个字符',
        'age.number'   => '年龄必须是数字',
        'age.between'  => '年龄只能在1-120之间',
        'email'        => '邮箱格式错误',
   ];*/
    protected $scene = [
        'edit'  =>  ['id'],
        'insert' => ['nname','ename','nsort','ntpl'],
        'update'=>['id','field','value']
    ];

}