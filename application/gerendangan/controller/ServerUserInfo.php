<?php
/**
 * Created by PhpStorm.
 * User: 俊光
 * author: Rommel
 * Email:rommel.zuo@gmail.com
 * Date: 2016/5/1
 * Time: 22:20
 */
namespace app\gerendangan\controller;
use app\gerendangan\model\Cardinfo;
use app\gerendangan\model\PersonInfoBase;
use components\various;
use components\jsonReturn;
class ServerUserInfo
{
    public $zjhm='';

    public function getUserInfo()
    {
        $card = new Cardinfo();
        $person = new PersonInfoBase();
        $cardinfo = $card->getCardinfo();
        if(empty($cardinfo) || !is_array($cardinfo))
        {
            jsonReturn::$status = 'fail';
            jsonReturn::$data = '未建档号码!!';
            jsonReturn::$code = 101;
            jsonReturn::returnInfo();
        }
        else
        {
            $personinfo = $person->field('brdh,XueXing')->where(['zjhm'=>$this->zjhm])->find();
            $data['name'] = $cardinfo['xingming'];
            $data['gender'] = $cardinfo['xingbie'];
            $data['ID'] = $cardinfo['haoma'];
            $data['phoneNum'] = $personinfo['brdh'] ? $personinfo['brdh'] : '未填写';
            $data['hemotype'] = $person->xuexing($personinfo['xuexing']);
            $data['age'] = various::getAge($cardinfo['chushengriqi']);
            return $data;
        }

    }
}