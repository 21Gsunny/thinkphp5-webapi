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
            $data['currentSymptoms'] = _keyarrValue($res['zz'],$this->zhengzhuang(),$res['qt']);
            $data['risk'] = ($res['wxx']) ? $res['wxx'].'级' : '未填写';
            $data['selfKnowledge'] = _keyValue($res['zzl'],$this->zizhili());
            $data['sleepQuality'] = _keyValue($res['sm'],various::state());
            $data['dietCondition'] = _keyValue($res['ys'],various::state());
            $data['socialFunction']['personalLife'] = _keyValue($res['shll'],various::state());
            $data['socialFunction']['housework'] = _keyValue($res['jwld'],various::state());
            $data['socialFunction']['productiveLaborWork'] = _keyValue($res['scld'],$this->laodong());
            $data['socialFunction']['learnAbility'] = _keyValue($res['xxnl'],various::state());
            $data['socialFunction']['socialInterpersonal'] = _keyValue($res['rjjw'],various::state());
            $data['illFamilySocialImpact']['mildDisturbances'] = ($res['zs']) ? $res['zs'].'次' : '未填写';
            $data['illFamilySocialImpact']['causeTrouble'] = ($res['zhs']) ? $res['zhs'].'次' : '未填写';
            $data['illFamilySocialImpact']['causeAccident'] =($res['zhh']) ? $res['zhh'].'次' : '未填写';
            $data['illFamilySocialImpact']['selfInjury'] =($res['zsh']) ? $res['zsh'].'次' : '未填写';
            $data['illFamilySocialImpact']['suicideAttempt'] =($res['ws']) ? $res['ws'].'次' : '未填写';
            $data['shutCase'] = _keyValue($res['gs'],$this->gsqk());
            $data['hospitalizationCondition'] = _keyValue($res['zy'],$this->zyqk());
            $data['laboratoryExamination'] = _keyValue($res['sys'],various::is_has($res['sysy']));
            $data['medicationAdherence'] = _keyValue($res['ycx'],$this->ywyc());
            $data['drugAdverseReaction'] = _keyValue($res['blfy'],various::is_has($res['blfyy']));
            $data['treatmentEffect'] = _keyValue($res['zlxg'],$this->zlxg());
            if($res['sfzz'] == '1')
            {
                $data['isReferral'] = '无';
            }
            else
            {
                $data['isReferral']['reason'] = ($res['zzyy']) ? $res['zzyy'] : '未填写';
                $data['isReferral']['organization'] = ($res['zzyk']) ? $res['zzyk'] : '未填写';
            }
            for($i=1;$i<=4;$i++)
            {
                if($res['ywmc'.$i])
                {
                    $data['medicationSituation'][$i-1]['medName'] = $res['ywmc'.$i];
                    $data['medicationSituation'][$i-1]['dosage'] = '每日'.$res['yf'.$i].'次,每次'.$res['yl'.$i].$res['yfdw'.$i];
                }

            }
            if(empty($data['medicationSituation']))$data['medicationSituation'] = '无';
            $data['recoveryMeasure'] = _keyarrValue($res['kfcs'],$this->kfcs(),$res['qtcs']);
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
        return ['幻觉','交流困难','猜疑','喜怒无常','行为怪异','兴奋话多','伤人毁物','悲观厌世','无故外走','自语自笑','孤僻懒散'];
    }
    public function zizhili()
    {
        return ['自知力完全','自知力不完全','自知力缺失'];
    }

    public function laodong()
    {
        return ['良好','一般','较差',8=>'此项不适应'];
    }

    public function gsqk()
    {
        return ['无关锁','关锁','关锁已解除'];
    }
    public function zyqk()
    {
        return ['从未住院','目前正在住院','既往住院,现未住院'];
    }

    public function ywyc()
    {
        return ['规律','间断','不服药'];
    }
    public function zlxg()
    {
        return ['痊愈','好转','无变化','加重'];
    }
    public function kfcs()
    {
        return ['生活劳动能力','职业训练','学习能力','社会交往'];
    }

}