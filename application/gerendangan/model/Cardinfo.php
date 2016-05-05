<?php
/*
 * +-----------------------------------   
 * @author: Rommel/左俊光.
 * @E-mail:rommel.zuo@outlook.com
 * @Date: 16-2-17
 * @Time: 下午4:26
 * @Remarks : 
 * +-------------------------------------
 */
namespace app\gerendangan\model;
use think\Model;

class Cardinfo extends Model
{
    protected $trueTableName = 'tbl_cardinfo';
    /*
     * 获取身份证信息
     */
    public function getCardinfo()
    {
        return $this->cardInfoResult($this->cardInfoFind());
    }

    public function checkCard()
    {
        $id = I('get.id');
       return ($this->where("IDCARDNO= '{$id}'")->find()) ? 1 : false;
    }
    private function cardInfoFind()
    {
        return $this->field('IDCARDNO,NAME,SEX,RACE,BIRTHDATE,ADDRESS')->where("IDCARDNO='".I('get.id')."'")->find();
    }

    private function cardInfoResult($info)
    {
        $result = [];
        if($info != null || !empty($info))
        {
            $result['haoma'] = $info['idcardno'];
            $result['xingming'] = $info['name'];
            $result['xingbie'] = $info['sex'] == '2' ? '女' : '男';
            $result['minzu'] = $info['race'];
            $result['chushengriqi'] = changeDate($info['birthdate']);
            $result['jvzhudizhi'] = $info['address'];
            return $result;
        }
        else
        {
            return false;
        }
    }
}