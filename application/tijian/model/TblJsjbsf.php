<?php
/**
 * Created by PhpStorm.
 * User: 俊光
 * author: Rommel
 * Email:rommel.zuo@gmail.com
 * Date: 2016/5/2
 * Time: 21:24
 */

namespace app\tijian\model;
use think\Model;
class TblJsjbsf extends Model
{
    protected $trueTableName = 'tbl_jsjbsf';

    public $zjhm = '';
    public $gxysfID = 0;

    public function getCount()
    {
        return $this->where(['zjhm'=>$this->zjhm])->count();
    }

    public function getList()
    {
        $list = $this->where(['zjhm'=>$this->zjhm])->field('jsjbsfID,sfrq,sfys,sffs')->select();
        return $list;
    }

}