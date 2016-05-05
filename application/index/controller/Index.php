<?php

namespace app\index\controller;
use app\common\controller\Common;
class Index extends Common{

    public function index()
    {
        $data = ['name'=>I('get.name'),'url'=>'thinkphp.cn',];
        return successInfo($data);
    }

    public function home()
    {
        if($this->checkToken() === false) return $this->errorToken();
    }
    public function idcardno()
    {
       $id = '130722199011230037';
       var_dump(checkIdCard($id));
    }
}
