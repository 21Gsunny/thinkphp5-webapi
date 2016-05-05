<?php
/*
 * +-----------------------------------   
 * @author: Rommel/左俊光.
 * @E-mail:rommel.zuo@outlook.com
 * @Date: 16-2-17
 * @Time: 下午2:28
 * @Remarks : tbl_user数据表操作
 * +-------------------------------------
 */
namespace app\common\model;
use think\Model;

class Docter extends Model
{
    protected $trueTableName = 'tbl_user';

    public function getName($id)
    {
        return $this->findName($id);
    }

    protected function findName($id)
    {
        $name =  $this->field('UserName')->where("UserID = '{$id}'")->find();
        return ($name) ? $name['username'] : '未获取到信息';
    }
}