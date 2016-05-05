<?php
/*
 * +-----------------------------------   
 * @author: Rommel/左俊光.
 * @E-mail:rommel.zuo@outlook.com
 * @Date: 16-2-17
 * @Time: 下午2:28
 * @Remarks : 
 * +-------------------------------------
 */
namespace app\common\model;
use think\Model;

class Token extends Model
{
    protected $trueTableName = 'api_token';

    public function getTokenID()
    {
        $id =  $this->field('id')->where("token_name = '".I('get.tokenid')."'")->find();
        return ($id) ? true : false;
    }
}