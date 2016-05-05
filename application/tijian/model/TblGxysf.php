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
        if(is_array($res) && !empty($res))
        {
            $data['followUpId'] = $this->gxysfID;
            $data['followUpDate'] = changeDate($res['sfrq']);
            $data['nextFollowUpDate'] = changeDate($res['xcsfrq']);
            $data['followUpDoc'] = D("common/Docter")->getName($res['sfys']);
            $data['followUpWav'] = _keyValue($res['sffs'],various::fllowType());
            $data['followUpClassification'] = _keyValue($res['sffl'],$this->suifangfenglei());
            $data['symptom'] = _keyarrValue($res['zz'],$this->zhengzhuang(),$res['qt']);
            $data['physicalSign']['bloodPressure'] = ($res['ssy']) ? $res['ssy'].'/'.$res['szy'].'(mmHg)' : '未填写';
            $data['physicalSign']['weight'] =($res['tz']) ? $res['tz'].'kg' : '未填写';
            $data['physicalSign']['bmi'] = ($res['tzzs']) ? $res['tzzs'] : '未填写';
            $data['physicalSign']['heartRate'] = ($res['xl']) ? $res['xl'].'次/分钟' : '未填写';
            $data['lifestyleGuidance']['smokePerDay'] = ($res['rxyl']) ? $res['rxyl'].'支/日' : '未填写';
            $data['lifestyleGuidance']['drinkPerDay'] = ($res['ryjl']) ? $res['ryjl'].'两/日' : '未填写';
            $data['lifestyleGuidance']['exercise'] = ($res['yd']) ? $res['yd'].'次/周' : '未填写';
            $data['lifestyleGuidance']['exercise'] .= ($res['ydsj']) ? ','.$res['ydsj'].'分钟/次' : '';
            $data['lifestyleGuidance']['takenSaltSituation'] = _keyValue($res['syqk'],$this->syqk());
            $data['lifestyleGuidance']['psychologicalAdjustment'] = _keyValue($res['xltz'],$this->qkzt());
            $data['lifestyleGuidance']['medicalBehavior'] =  _keyValue($res['zyxw'],$this->qkzt());
            $data['lifestyleGuidance']['auxiliaryExamination'] = ($res['fzjc']) ? $res['fzjc'] : '未填写';
            $data['medicationAdherence'] = _keyValue($res['ycx'],$this->ywycx());
            $data['drugAdverseReaction'] = _keyValue($res['blfy'],$this->ycfy($res['blfyqt']));
            for($i=1;$i<=4;$i++)
            {
                if($res['ywmc'.$i])
                {
                    $data['medicationSituation'][$i-1]['medName'] = $res['ywmc'.$i];
                    $data['medicationSituation'][$i-1]['dosage'] = '每日'.$res['yf'.$i].'次,每次'.$res['yl'.$i].$res['yfdw'.$i];
                }

            }
            if(empty($data['medicationSituation']))$data['medicationSituation'] = '无';
            $data['referral']['reason'] = ($res['zzyy']) ? $res['zzyy'] : '未填写';
            $data['referral']['organization'] = ($res['zzyk']) ? $res['zzyk'] : '未填写';
            unset($res);
            return $data;
        }
        else
        {
            return false;
        }

    }

    public function tblGxysfFind()
    {
        return $this->where(['gxysfID'=>$this->gxysfID])->find();
    }

    /**
     *  症状
     */
    public function zhengzhuang()
    {
        return ['无症状','头痛头晕','恶心呕吐','眼花耳鸣','呼吸困难','心悸胸闷','鼻衄出血不止','四肢发麻','下肢水肿'];
    }

    public function suifangfenglei()
    {
        return ['控制满意','控制不满意','不良反应','并发症'];
    }

    public function syqk()
    {
        return ['轻','中','重'];
    }

    public function qkzt()
    {
        return ['良好','一般','差'];
    }

    public function ywycx()
    {
        return ['规律','间断','不服药'];
    }
    public function ycfy($yc)
    {
        return ['无','有,'.$yc];
    }

}