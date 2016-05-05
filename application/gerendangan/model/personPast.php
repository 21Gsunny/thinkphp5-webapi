<?php
/*
 * +-----------------------------------   
 * @author: Rommel/左俊光.
 * @E-mail:rommel.zuo@outlook.com
 * @Date: 2016/3/22
 * @Time: 15:36
 * @Remarks : 既往史
 * +-------------------------------------
 */

namespace app\gerendangan\model;
use think\Model;

class personPast extends Model
{
    protected $trueTableName = 'tbl_personpast';

    protected static $_lx = ['1'=>'疾病','2'=>'手术','3'=>'外伤','4'=>'输血'];

    public function getlx($k)
    {
        return self::$_lx[$k];
    }

    public function search($id)
    {
        return $this->where("zjhm = '".$id."' ")->select();
    }

    public function getPersonPast($id)
    {
        $list = [];
        $res = $this->search($id);
        foreach($res as $k=>$v)
        {
            $list[$k]['leixing'] = $this->getlx($v['lx']);
            if($v['lx'] == '1')
            {
                $list[$k]['jbmc'] = $v['bz'] ? $v['bz'] : $this->code_jbmc($v['jbmc']);
            }
            else
            {
                $list[$k]['jbmc'] = $v['jbmc'];
            }
            $list[$k]['riqi'] = empty($v['jwsrq']) ? '未填写' : date('Y-m-d',$v['jwsrq']);
        }
        unset($res);
        return $list;
    }
    public function code_jbmc($v)
    {
        return M('code_jbmc')->where("CodeType = 'jws' and CodeID='{$v}'")->getField('CodeName');
    }
}