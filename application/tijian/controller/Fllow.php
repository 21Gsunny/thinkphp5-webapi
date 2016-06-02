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
            $page = I('get.page') ? I('get.page') : 1;
            $num = I('get.num');
            $data['userInfo'] = $this->userInfo();
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
                $data['followUpList'][$i]['followUpId'] = 't-'.$v['tnbsfid'];
                $data['followUpList'][$i]['followUpDate'] = date("Y-m-d",$v['sfrq']);
                $data['followUpList'][$i]['followUpMed'] = _keyValue($v['sffs'],various::fllowType());
                $data['followUpList'][$i]['followUpType'] = '糖尿病';
                $data['followUpList'][$i]['followUpDocName'] = $docter->getName($v['sfys']);
                $i++;
            }
            foreach($gxysf->getList() as $k=>$v)
            {
                $data['followUpList'][$i]['followUpId'] = 'g-'.$v['gxysfid'];
                $data['followUpList'][$i]['followUpDate'] = date("Y-m-d",$v['sfrq']);
                $data['followUpList'][$i]['followUpMed'] = _keyValue($v['sffs'],various::fllowType());
                $data['followUpList'][$i]['followUpType'] = '高血压';
                $data['followUpList'][$i]['followUpDocName'] = $docter->getName($v['sfys']);
                $i++;
            }
            foreach($jsjbsf->getList() as $k=>$v)
            {
                $data['followUpList'][$i]['followUpId'] = 'j-'.$v['jsjbsfid'];
                $data['followUpList'][$i]['followUpDate'] = date("Y-m-d",$v['sfrq']);
                $data['followUpList'][$i]['followUpMed'] = _keyValue($v['sffs'],various::fllowType());
                $data['followUpList'][$i]['followUpType'] = '精神疾病';
                $data['followUpList'][$i]['followUpDocName'] = $docter->getName($v['sfys']);
                $i++;
            }
            $result ;
            if($i > $num && !empty($num))
            {
                $page = (int)$page-1;
                for($page;$page < $num;$page++)
                {
                    $result[] = $data['followUpList'][$page];
                }
            }
            else
            {
                $result = $data;
            }
            jsonReturn::$code = 304;
            jsonReturn::$status = 'success';
            jsonReturn::$data = $result;
            jsonReturn::returnInfo();
        }
        else
        {
            return $this->_check();
        }

    }

    public function getFllowUp()
    {
        if($this->_check() === true)
        {
            $this->_checkFllowID();
            $fllowid = explode('-',I('get.followUpId'));
            switch($fllowid[0])
            {
                case 'g':
                    $this->gxySf($fllowid[1]);
                    break;
                case 't':
                    $this->tnbSf($fllowid[1]);
                    break;
                case 'j':
                     $this->jsjbSf($fllowid[1]);
                    break;
                default:
                    jsonReturn::$code = 404404;
                    jsonReturn::$status = 'fail';
                    jsonReturn::$data = '请求ID错误';
                    jsonReturn::returnInfo();
                    break;
            }
        }
        else
        {
            return $this->_check();
        }
    }
    public function gxySf($id)
    {
        $gxy = new TblGxysf();
        $gxy->gxysfID = $id;
        $data = [];
        if($gxy->getData())
        {
            $data['userInfo'] = $this->userInfo();
            $data['testingData'] = $gxy->getData();
            jsonReturn::$code = 305;
            jsonReturn::$data = $data;
        }
        else
        {
            jsonReturn::$code = 305;
            jsonReturn::$status = 'fail';
            jsonReturn::$data = '没有随访记录';

        }
        jsonReturn::returnInfo();
    }

    public function tnbSf($id)
    {
        $tnb = new TblTnbsf();
        $tnb->tnbsfID = $id;
        $data = [];
        if($tnb->getData())
        {
            $data['userInfo'] = $this->userInfo();
            $data['testingData'] = $tnb->getData();
            jsonReturn::$data = $data;
        }
        else
        {
            jsonReturn::$status = 'fail';
            jsonReturn::$data = '没有随访记录';

        }
        jsonReturn::$code = 306;
        jsonReturn::returnInfo();
    }

    public function jsjbSf($id)
    {
        $jsjb = new TblJsjbsf();
        $jsjb->jsjbsfID = $id;
        $data = [];
        if($jsjb->getData())
        {
            $data['userInfo'] = $this->userInfo();
            $data['testingData'] = $jsjb->getData();
            jsonReturn::$data = $data;
        }
        else
        {
            jsonReturn::$status = 'fail';
            jsonReturn::$data = '没有随访记录';

        }
        jsonReturn::$code = 307;
        jsonReturn::returnInfo();
    }
    public function userInfo()
    {
        $zjhm = I('get.id');
        $userinfo = new ServerUserInfo();
        $userinfo->zjhm = $zjhm;
        return $userinfo->getUserInfo();
    }
    protected function _checkFllowID()
    {
        if(!I('get.followUpId'))
        {
            jsonReturn::$code = 110;
            jsonReturn::$status = 'error';
            jsonReturn::$data = '随访记录ID错误或者为空';
            jsonReturn::returnInfo();
            die();
        }
    }
}