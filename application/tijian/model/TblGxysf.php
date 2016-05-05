<?php
/**
 * Created by PhpStorm.
 * User: 俊光
 * author: Rommel
 * Email:rommel.zuo@gmail.com
 * Date: 2016/5/2
 * Time: 21:22
 * Remark: 高血压随访表 tbl_gxysf 的数据模型
 */
namespace app\tijian\model;
use components\various;
use think\Model;
class TblGxysf extends Model
{
    protected $trueTableName = 'tbl_gxysf';

    public $zjhm = '';
    public $gxysfID = 0;

    public function getCount()
    {
        return $this->where(['zjhm'=>$this->zjhm])->count();
    }

    public function getList()
    {
        $list = $this->where(['zjhm'=>$this->zjhm])->field('gxysfID,sfrq,sfys,sffs')->select();
        return $list;
    }

    public function getData()
    {
        $res = $this->tblGxysfFind();
        $data['followUpId'] = $this->gxysfID;
        $data['followUpDate'] = changeDate($res['sfrq']);
        $data['nextFollowUpDate'] = changeDate($res['xcsfrq']);
        $data['followUpDoc'] = D("common/Docter")->getName($res['sfys']);
        $data['followUpWav'] = _keyValue($res['sffs'],various::fllowType());
        $data['followUpClassification'] =
        $data['symptom']

    }

    public function tblGxysfFind()
    {
        return $this->where(['gxysfID'=>$this->gxysfID])->find();
    }

}