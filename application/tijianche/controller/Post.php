<?php
/*
 * +-----------------------------------   
 * @author: Rommel/左俊光.
 * @E-mail:rommel.zuo@outlook.com
 * @Date: 16-3-2
 * @Time: 上午8:46
 * @Remarks : 
 * +-------------------------------------
 */
namespace app\tijianche\controller;

use app\common\controller\Common;

class Post extends Common
{
    public function addInfo()
    {
        if(IS_POST)
        {
            $model = D('CheckInfo');
            if($model->checkZjhm())
            {
                return $model->addPost();
            }
            else
            {
                return $this->errorIdcard();
            }
        }
        else
        {
            return methodError();
        }

    }
}