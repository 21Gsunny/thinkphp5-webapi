<?php
/*
 * +-----------------------------------   
 * @author: Rommel/左俊光.
 * @E-mail:rommel.zuo@gmail.com
 * @Date: 2016/5/9
 * @Time: 10:43
 * @Remarks : 康泰生命仪体检数据获取
 * +-------------------------------------
 */
namespace app\contec\controller;
use app\common\controller\Common;
use components\jsonReturn;
use app\contec\model\ContecEcg;
class Contec extends Common
{
    public function _initialize()
    {
        if($this->checkToken() === false)
        {
            jsonReturn::$code = 0;
            jsonReturn::$status = 'error';
            jsonReturn::$data = 'TokenID错误或者不存在!';
            jsonReturn::returnInfo();
            exit();
        }
        if(checkIdCard(I('get.id')) === false)
        {
            jsonReturn::$code = 0;
            jsonReturn::$status = 'error';
            jsonReturn::$data = '身份证号码格式错误或者不存在!';
            jsonReturn::returnInfo();
            exit();
        }
    }

    public function contecList()
    {
        $contec = new ContecEcg();
        $contec->userid = I('get.id');
        $userinfo = $contec->getUserInfo();
        $data['userinfo'] = $userinfo;
        $contec->type = 'select';
        $time = $this->getData();
        $info = $contec->getBloodPressure($time);
        $i=0;
        $heigth = (int)substr($data['userinfo']['height'],0,-2);
        if(!is_array($info))
        {
            $data['checkUpInfo'] = '无体检记录';
        }
        else
        {
            $contec->type = 'find';
            foreach($info as $k=>$v)
            {
                $data['checkUpInfo'][$i]['date'] = $v['date'];
                $data['checkUpInfo'][$i]['bloodpressure'] = $v['systolicpressure'].'/'.$v['diastolicpressure'].'(mmHg)';
                $data['checkUpInfo'][$i]['averagepressure'] = $v['averagepressure'].'(mmHg)';
                $data['checkUpInfo'][$i]['limosisbg'] = $contec->getBloodsugar($v['date']);
                $data['checkUpInfo'][$i]['heartrate'] = $contec->getHeartrate($v['date']);
                $data['checkUpInfo'][$i]['respiration'] = $contec->getRespiration($v['date']);
                $data['checkUpInfo'][$i]['pulserate'] = $contec->getPulseRate($v['date']);
                $data['checkUpInfo'][$i]['spo2'] = $contec->getSpo2($v['date']);
                $data['checkUpInfo'][$i]['temperature'] = $contec->getTemperature($v['date']);
                $data['checkUpInfo'][$i]['weigth'] = $contec->getWeigth($v['date']);
                $weigth = (int)substr($data['checkUpInfo'][$i]['weigth'],0,-2);
                if($heigth && $weigth)
                {
                    $data['checkUpInfo'][$i]['BMI'] = round($weigth/$heigth/$heigth*10000,1).'Kg/m^2';
                }
                $i++;
            }
        }
        jsonReturn::$data = $data;
        jsonReturn::returnInfo();
    }

    public function getData()
    {
        $checkTime = I('get.checkUpTime');
        if(empty($checkTime)) return date('Y-m-d',time());
        if(preg_match("/^(\d{4})-(0\d{1}|1[0-2])$/",$checkTime))
        {
            return $checkTime;
        }
        else
        {
            jsonReturn::$code = 0;
            jsonReturn::$status = 'error';
            jsonReturn::$data = 'checkUpTime参数错误';
            jsonReturn::returnInfo();
            exit();
        }

    }

    public function contecInfo()
    {
        $contec = new ContecEcg();
        $contec->userid = I('get.id');
        $data['userinfo'] = $contec->getUserInfo();
        $contec->type = 'select';
        $time = $this->getData();
        switch(trim(I('checkUpProject')))
        {
            case 'bloodpressure':
                  $data['checkUpInfo'] = $contec->getBloodPressure($time);
                break;
            case 'limosisbg':
                  $data['checkUpInfo'] = $contec->getBloodsugar($time);
                break;
            case 'heartrate':
                  $data['checkUpInfo'] = $contec->getHeartrate($time);
                break;
            case 'respiration':
                  $data['checkUpInfo'] = $contec->getRespiration($time);
                break;
            case 'pulserate':
                 $data['checkUpInfo'] = $contec->getPulseRate($time);
                break;
            case 'temperature':
                 $data['checkUpInfo'] = $contec->getTemperature($time);
                break;
            case 'weigth':
                 $data['checkUpInfo'] = $contec->getWeigth($time);
                break;
            case 'spo2':
                  $data['checkUpInfo'] = $contec->getSpo2($time);
                break;
            default:
                $data['checkUpInfo'] = '无该项检测记录';
                break;
        }
        jsonReturn::$code = 1;
        jsonReturn::$data = $data;
        jsonReturn::returnInfo();
    }

}