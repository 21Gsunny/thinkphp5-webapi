<?php
/*
 * +-----------------------------------
 * @author: Rommel/左俊光.
 * @E-mail:rommel.zuo@outlook.com
 * @Date: 16-2-17
 * @Time: 下午3:36
 * @Remarks : 个人档案，包括身份证号码信息、个人基本信息档案、所属特殊人群的档案。
 * +-------------------------------------
 */
namespace app\gerendangan\controller;
use app\common\controller\Common;
use app\gerendangan\model\personPast;
use components\jsonReturn;
class Index extends Common
{
    /**
     * 获取身份证信息
     */
    public function _initialize()
    {
        $this->checkCardInfo();
    }
    public function idcardInfo()
    {
           if($this->_check() === true)
           {
               $data = D('Cardinfo')->getCardinfo();
               if($data === false) return errorInfo();
               return successInfo($data);
           }
           else
           {
               return $this->_check();
           }
    }

    public function appPersonInfo()
    {
        if($this->_check() === true)
        {
            $cardinfo = D('Cardinfo')->getCardinfo();
            $infobse = D('PersonInfoBase')->getJiBenZhuangKuang();
            $personPast = new personPast();
            $data['baseInfo']['ID'] = $cardinfo['haoma'] ;
            $data['baseInfo']['name'] = $cardinfo['xingming'] ;
            $data['baseInfo']['sex'] = $cardinfo['xingbie'] ;
            $data['baseInfo']['dateBirth'] = $cardinfo['chushengriqi'] ;
            $data['baseInfo']['telNum'] = $infobse['benrendianhua'] ;
            $data['baseInfo']['contactName'] = $infobse['lianxiren'] ;
            $data['baseInfo']['contactPhone'] = $infobse['lianxirendianhua'] ;
            $data['baseInfo']['permanentType'] = $infobse['changzhuleixing'] ;
            $data['baseInfo']['nationalists'] = $cardinfo['minzu'] ;
            $data['baseInfo']['bloodType'] = $infobse['xuexing'] ;
            $data['baseInfo']['eduLevel'] = $infobse['wenhuachengdu'] ;
            $data['baseInfo']['job'] = $infobse['zhiye'] ;
            $data['baseInfo']['maritalStatus'] = $infobse['hunyin'] ;
            $data['baseInfo']['paymentMedicalCost'] = $infobse['zhifufangshi'] ;
            $data['baseInfo']['historyDrugAllergy'] = $infobse['yaowuguoming'] ;
            $data['baseInfo']['historyExposed'] = $infobse['baolushi'] ;
            $data['pastMedicalHistory'] = $personPast->getPersonPast(I('get.id'));
            $data['geneticHistory'] = $infobse['yichuanshi'];
            $data['disability'] = $infobse['canji'];
            $data['familyHistory']['father'] = $infobse['jiazusifu'];
            $data['familyHistory']['mother'] = $infobse['jiazusimu'];
            $data['familyHistory']['brotherSister'] = $infobse['jiazusixiong'];
            $data['familyHistory']['children'] = $infobse['jiazusizi'];
            jsonReturn::$code = 301;
            jsonReturn::$status = 'success';
            jsonReturn::$data = $data;
            return jsonReturn::response();
        }
        else
        {
            return $this->_check();
        }
    }
    /**
     *获取基本状况
     */

    public function personBaseInfo()
    {

        if($this->_check() === true)
        {
            $data = D('PersonInfoBase')->getJiBenZhuangKuang();
            if($data === false) return errorInfo();
            return successInfo($data);
        }
        else
        {
            return $this->_check();
        }
    }

   public function personPast()
   {
       if($this->_check() === true)
       {
           $personPast = new personPast();
           $data = $personPast->getPersonPast(I('get.id'));
           if($data === false) return errorInfo();
           return successInfo($data);
       }
       else
       {
           return $this->_check();
       }
   }
    /**
     * @return 提示信息|array|bool
     *
     */
    public function TnbInfo()
    {
        if($this->_check() === true)
        {
            $data = D('Tnbdj')->TnbdjInfo();
            if($data === false) return errorInfo();
            return successInfo($data);
        }
        else
        {
            return $this->_check();
        }
    }
}
