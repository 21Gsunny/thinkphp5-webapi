<?php
/*
 * +-----------------------------------
 * @author: Rommel/左俊光.
 * @E-mail:rommel.zuo@outlook.com
 * @Date: 16-2-16
 * @Time: 下午3:36
 * @Remarks :公共类，处理公共方法供其他控制器继承
 * +-------------------------------------
 */
namespace app\common\controller;
use think\Controller;
use app\gerendangan\model\Cardinfo;
use components\jsonReturn;
class Common extends Controller{

    public function _initialize()
    {

    }
    /**
     * 空方法用于404
     * @return 错误提示
     */
    public function _empty()
    {
       return $this->errorInfo();
    }

    /**
     * 必须访问逻辑处理，检测token和提交的证件号码
     * @return 提示信息|array|bool
     */
    protected function _check()
    {
        if($this->checkToken() !== false)
        {
            if($this->_isIdcard() === true)
            {
                if(checkIdCard(I('get.id')) === false) return $this->errorIdcard();
                return true;
            }
            else
            {
                return $this->_isIdcard();
            }
        }
        else
        {
            return $this->errorToken();
        }
    }
    /**
     * 检测Token值是否为空和是否存在
     * @return false
     */
    protected function checkToken()
    {
        if(!I('get.tokenid')) return false;
        if(D('Token')->getTokenID() === false) return false;
    }

    /**
     * 检测获取的身份证号码是否存在
     */
    public function checkCardInfo()
    {
        $card = new Cardinfo();
        if($card->checkCard() === false)
        {
            jsonReturn::$code = 404;
            jsonReturn::$status = 'error';
            jsonReturn::$data = '该档案不存在';
            jsonReturn::returnInfo();
            exit();
        }
    }
    protected function _checkHerID()
    {
        if($this->checkToken() !== false)
        {
            if($this->_isHERID() === true)
            {
                return true;
            }
            else
            {
                return $this->_isHERID();
            }
        }
        else
        {
            return $this->errorToken();
        }
    }
    /**
     * 检测身份证号码是否有值
     * @return array|bool|提示信息
     */
    private function _isIdcard()
    {
        return  (I('get.id')) ? true : ['code'=>0,'message'=>'证件号码为空'];
    }

    private function _isHERID()
    {
        return  (I('get.herid') || I('get.examId')) ? true : ['code'=>0,'message'=>'体检信息ID为空'];
    }
    protected function errorInfo()
    {
        return ['code'=>404,'message'=>'请求未找到资源'];
    }

    protected function errorToken()
    {
        return ['code'=>110,'message'=>'请填写Token'];
    }

    protected function errorIdcard()
    {
        return ['code'=>0,'message'=>'证件号码不符合规则'];
    }
}


?>
