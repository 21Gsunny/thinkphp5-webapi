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
use components\various;
class TblJsjbsf extends Model
{
    protected $trueTableName = 'tbl_jsjbsf';

    public $zjhm = '';
    public $jsjbsfID = 0;

    public function getCount()
    {
        return $this->where(['zjhm'=>$this->zjhm])->count();
    }

    public function getList()
    {
        $list = $this->where(['zjhm'=>$this->zjhm])->field('jsjbsfID,sfrq,sfys,sffs')->select();
        return $list;
    }

    public function getData()
    {
        $res = $this->tblJsjbFind();
        if(is_array($res) && !empty($res))
        {
            $data['followUpId'] = $this->jsjbsfID;
            $data['followUpDate'] = extendDate($res['sfrq']);
            $data['nextFollowUpDate'] = extendDate($res['xcsfrq']);
            $data['followUpDoc'] = D("common/Docter")->getName($res['sfys']);
           // $data['followUpWav'] = _keyValue($res['sffs'],various::fllowType());
            $data['followUpClassification'] = _keyValue($res['sffl'],$this->suifangfenglei());
            $data['symptom'] = _keyarrValue($res['zz'],$this->zhengzhuang(),$res['qt']);
            $data['risk']
            $data['currentSymptoms']
            $data['selfKnowledge']
            $data['selfKnowledge']
            $data['selfKnowledge']
            return $data;
        }
        else
        {
            return false;
        }
    }
    public function tblJsjbFind()
    {
        return $this->where(['jsjbsfID'=>$this->jsjbsfID])->find();
    }

    public function suifangfenglei()
    {
        return ['不稳定','基本稳定','稳定','未访问到'];
    }
    public function zhengzhuang()
    {
        return ['幻觉','交流困难','猜疑','多尿','视力模糊','感染','手脚麻木','下肢水肿','体重明显下降'];
    }
}