<?php
/**
 * Created by PhpStorm.
 * User: 俊光
 * author: Rommel
 * Email:rommel.zuo@gmail.com
 * Date: 2016/5/2
 * Time: 18:46
 * Remark : tbl_tnbsf 数据Model
 */
namespace app\tijian\model;
use think\Model;
class TblTnbsf extends Model
{
    protected $trueTableName = 'tbl_tnbsf';

    public $zjhm = '';
    public $tnbsfID = 0;

    public function getCount()
    {
        return $this->where(['zjhm'=>$this->zjhm])->count();
    }

    public function getList()
    {
        $list = $this->where(['zjhm'=>$this->zjhm])->field('tnbsfID,sfrq,sfys,sffs')->select();
        return $list;
    }

}