<?php
/**
 * Created by PhpStorm.
 * User: 俊光
 * author: Rommel
 * Email:rommel.zuo@gmail.com
 * Date: 2016/5/1
 * Time: 22:49
 * Remark : 随访记录的处理
 */

namespace app\tijian\controller;
use app\common\controller\Common;
use app\gerendangan\controller\ServerUserInfo;
use components\jsonReturn;
use app\tijian\model\TblTnbsf;
use app\tijian\model\TblGxysf;
use app\tijian\model\TblJsjbsf;
use app\common\model\Docter;
use components\various;
class Fllow extends Common
{

    public function _initialize()
    {
        $this->checkCardInfo();
    }

    /**
     *  function getFllowUpList() 获取随访记录列表
     */
    public function getFllowUpList()
    {
        if($this->_check() === true)
        {
            $zjhm = I('get.id');
            $userinfo = new ServerUserInfo();
            $userinfo->zjhm = $zjhm;
            $data['userInfo'] = $userinfo->getUserInfo();
            $tnbsf = new TblTnbsf();
            $gxysf = new TblGxysf();
            $jsjbsf = new TblJsjbsf();
            $docter = new Docter();
            $tnbsf->zjhm = $zjhm;
            $gxysf->zjhm = $zjhm;
            $jsjbsf->zjhm = $zjhm;
            $i = 0;
            foreach($tnbsf->getList() as $k=>$v)
            {
                $data['followUpList'][$i]['followUpId'] = 't'.$v['tnbsfid'];
                $data['followUpList'][$i]['followUpDate'] = date("Y-m-d",$v['sfrq']);
                $data['followUpList'][$i]['followUpMed'] = _keyValue($v['sffs'],various::fllowType());
                $data['followUpList'][$i]['followUpType'] = '糖尿病';
                $data['followUpList'][$i]['followUpDocName'] = $docter->getName($v['sfys']);
                $i++;
            }
            foreach($gxysf->getList() as $k=>$v)
            {
                $data['followUpList'][$i]['followUpId'] = 'g'.$v['gxysfid'];
                $data['followUpList'][$i]['followUpDate'] = date("Y-m-d",$v['sfrq']);
                $data['followUpList'][$i]['followUpMed'] = _keyValue($v['sffs'],various::fllowType());
                $data['followUpList'][$i]['followUpType'] = '高血压';
                $data['followUpList'][$i]['followUpDocName'] = $docter->getName($v['sfys']);
                $i++;
            }
            foreach($jsjbsf->getList() as $k=>$v)
            {
                $data['followUpList'][$i]['followUpId'] = 'j'.$v['jsjbsfid'];
                $data['followUpList'][$i]['followUpDate'] = date("Y-m-d",$v['sfrq']);
                $data['followUpList'][$i]['followUpMed'] = _keyValue($v['sffs'],various::fllowType());
                $data['followUpList'][$i]['followUpType'] = '精神疾病';
                $data['followUpList'][$i]['followUpDocName'] = $docter->getName($v['sfys']);
                $i++;
            }
            jsonReturn::$code = 304;
            jsonReturn::$status = 'success';
            jsonReturn::$data = $data;
            jsonReturn::returnInfo();
        }
        else
        {
            return $this->_check();
        }

    }

    public function getFllowUp()
    {

    }

}