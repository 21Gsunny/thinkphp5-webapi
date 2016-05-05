<?php
/*
 * +-----------------------------------   
 * @author: Rommel/左俊光.
 * @E-mail:rommel.zuo@outlook.com
 * @Date: 16-2-18
 * @Time: 下午2:10
 * @Remarks : tbl_tnbdj 数据表操作
 * +-------------------------------------
 */
namespace app\gerendangan\model;
use think\Model;

class Tnbdj extends Model
{
    protected $trueTableName = 'tbl_tnbdj';


    public function TnbdjInfo()
    {
        return $this->ResutlData();
    }


    private function FindOne()
    {
       return $this->field('zxkbh,bfz,kfxt,hxt,sjxt,xhdb,tnblx')->where("zjhm='".I('get.id')."'")->find();
    }


    private function ResutlData()
    {
        if($this->FindOne())
        {
            return $this->DataList($this->FindOne());
        }
        else
        {
            return false;
        }
    }


    private function DataList($info)
    {
        $list['zxkbh'] = $info['zxkbh'];
        $list['kongfuxuetang'] = $info['kfxt'] == null || $info['kfxt'] == '0' ? '未填写' : $info['kfxt'].'mmol/L';
        $list['2hxuetang'] = $info['hxt'] == null || $info['hxt'] == '0' ? '未填写' : $info['hxt'].'mmol/L';
        $list['suijixuetang'] = $info['sjxt'] == null || $info['sjxt'] == '0' ? '未填写' : $info['sjxt'].'mmol/L';
        $list['xuehongdanbai'] = $info['xhdb'] == null || $info['xhdb'] == '0' ? '未填写' : $info['xhdb'].'%';
        $list['tnblx'] = $this->getTnblx((int)$info['tnblx']);
        $list['bfzqk'] = $this->getBfz($info['bfz']);

        return $list;
    }
    /**
     * @param $str
     * @return array|string
     * 获取确诊时并发症情况
     */

    public function getBfz($str)
    {
        if(empty($str) || $str == null) return '为空';
        $code = ['高血压','脑卒中','视网膜病变','糖尿病足','冠心病','高血脂','糖尿病肾病','糖尿病精神病变'];
        if(strlen($str)==1)
        {
            return $code[(int)$str-1];
        }
        else
        {
            $arr = explode('、',$str);
            $result = [];
            foreach($arr as $v){
                $v = ($v)-1;
                $result[] = $code[$v];
            }
            unset($arr);
            return $result;
        }
    }

    /**
     * @param $id
     * @return string
     * 获取糖尿病类型
     */
    public function getTnblx($id)
    {
        return $id == 1 ? 'Ⅰ型糖尿病' : 'Ⅱ型糖尿病';
    }
}