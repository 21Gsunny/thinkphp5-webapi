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
use components\various;
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

    public function getData()
    {
        $res = $this->tblTnbFind();
        if(is_array($res) && !empty($res))
        {
            $data['followUpId'] = $this->tnbsfID;
            $data['followUpDate'] = changeDate($res['sfrq']);
            $data['nextFollowUpDate'] = changeDate($res['xcsfrq']);
            $data['followUpDoc'] = D("common/Docter")->getName($res['sfys']);
            $data['followUpWav'] = _keyValue($res['sffs'],various::fllowType());
            $data['followUpClassification'] = _keyValue($res['sffl'],$this->suifangfenglei());
            $data['symptom'] = _keyarrValue($res['zz'],$this->zhengzhuang(),$res['qt']);
            $data['physicalSign']['bloodPressure'] = ($res['ssy']) ? $res['ssy'].'/'.$res['szy'].'(mmHg)' : '未填写';
            $data['physicalSign']['weight'] =($res['tz']) ? $res['tz'].'kg' : '未填写';
            $data['physicalSign']['bmi'] = ($res['tzzs']) ? $res['tzzs'] : '未填写';
            $data['physicalSign']['dorsalisPedisPulse'] = _keyValue($res['zbdmbd'],['未触及','触及']);
            $data['lifestyleGuidance']['smokePerDay'] = ($res['rxyl']) ? $res['rxyl'].'支/日' : '未填写';
            $data['lifestyleGuidance']['drinkPerDay'] = ($res['ryjl']) ? $res['ryjl'].'两/日' : '未填写';
            $data['lifestyleGuidance']['exercise'] = ($res['yd']) ? $res['yd'].'次/周' : '未填写';
            $data['lifestyleGuidance']['exercise'] .= ($res['ydsj']) ? ','.$res['ydsj'].'分钟/次' : '';
            $data['lifestyleGuidance']['food'] = ($res['zs']) ? $res['zs'].'克/天' : '未填写';
            $data['lifestyleGuidance']['psychologicalAdjustment'] = _keyValue($res['xltz'],$this->qkzt());
            $data['lifestyleGuidance']['medicalBehavior'] =  _keyValue($res['zyxw'],$this->qkzt());
            $data['lifestyleGuidance']['auxiliaryExamination']['fbsValues'] = ($res['kfxt']) ? $res['kfxt'].'mmol/L' : '未填写';
            $data['lifestyleGuidance']['auxiliaryExamination']['otherExamination'] = ($res['thxhdb']) ? '糖化血红蛋白'.$res['thxhdb'].'%,检查日期:'.extendDate($res['jcrq']) : '未填写';
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

    public function tblTnbFind()
    {
        return $this->where(['tnbsfID'=>$this->tnbsfID])->find();
    }

    /**
     *  症状
     */
    public function zhengzhuang()
    {
        return ['无症状','多饮','多食','多尿','视力模糊','感染','手脚麻木','下肢水肿','体重明显下降'];
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