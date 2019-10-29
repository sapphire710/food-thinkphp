<?php
namespace app\index\controller;


use	think\Controller;

class	Index	extends	Base
{
    public	function index()
    {
        $this->assign('id','0');
        return	$this->fetch();
    }
}

