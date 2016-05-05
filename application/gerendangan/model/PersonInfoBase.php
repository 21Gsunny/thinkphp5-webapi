<?php
/*
 * +-----------------------------------   
 * @author: Rommel/左俊光.
 * @E-mail:rommel.zuo@outlook.com
 * @Date: 16-2-17
 * @Time: 下午6:57
 * @Remarks : tbl_person 数据表操作
 * +-------------------------------------
 */

namespace app\gerendangan\model;
use think\Model;

class PersonInfoBase extends Model
{
    protected $trueTableName = 'tbl_person';

    private $ylfyzffs = [1=>'城镇职工基本医疗保险',2=>'城镇居民基本医疗保险',3=>'新型农村合作医疗',4=>'贫困救助',5=>'商业医疗保险',6=>'全公费',7=>'全自费',8=>'其他'];
    private $yaowuguomin = [1=>'无',2=>'青霉素',3=>'磺胺',4=>'链霉素',5=>'其他'];

    private $baolushi = [1=>'无',2=>'化学品',3=>'毒物',4=>'射线'];

    private $canji = [1=>'无',2=>'视力残疾',3=>'听力残疾',4=>'言语残疾',5=>'肢体残疾',6=>'智力残疾',7=>'精神残疾',8=>'其他残疾'];
    //获取基本状况包括 血型、文化程度、本人电话、职业、婚姻状况

    public function getJiBenZhuangKuang()
    {
        $info = $this->field('brdh,czlx,XueXing,whcd,zy,hyzk,lxr,lxrdh,zffs,qtzffs,GuoMin,GuoMinQT,BaoLu,YiChuan,YiChuanName,CanJi,CanJiQT,JiaZuF,JiaZuM,JiaZuX,JiaZuZ')->where("zjhm='".I('get.id')."'")->find();
        if($info != null || !empty($info))
        {
            $info = $this->jbzkList($info);
            return $info;
        }
        else
        {
            return false;
        }
    }

    private function jbzkList($info)
    {
        $list = [];
        $list['benrendianhua'] = ($info['brdh']==null || empty($info['brdh'])) ? '无' : $info['brdh'];
        $list['lianxiren'] = ($info['lxr']==null || empty($info['lxr'])) ? '无' : $info['lxr'];
        $list['lianxirendianhua'] = $info['lxrdh']==null ? '无' : $info['lxrdh'];
        $list['xuexing'] =$this->xuexing($info['XueXing']);
        $list['wenhuachengdu'] = $this->checkList($info['whcd'],1);
        $list['zhiye'] = $this->checkList($info['zy'],2);
        $list['hunyin'] = $this->checkList($info['hyzk'],3);
        $list['zhifufangshi'] = $this->getylfyzffs($info['zffs'],$info['zffsqt']);
        $list['baolushi'] = $this->getbaolushi($info['baolu']);
        $list['yichuanshi'] = $info['yichuanname'] ? $info['yichuanname']  : $this->_yichuan($info['yichuan']);
        $list['yaowuguoming'] = $this->getYaoWuGuoMin($info['guomin'],$info['guominqt']);
        $list['canji'] = $this->getCanji($info['canji'],$info['canjiqt']);
        $list['changzhuleixing'] = $info['czlx'] == '1' ? '户籍' : '非户籍';
        $list['jiazusifu'] = $this->getJiZu($info['jiazuf']);
        $list['jiazusimu'] = $this->getJiZu($info['jiazum']);
        $list['jiazusixiong'] = $this->getJiZu($info['jiazux']);
        $list['jiazusizi'] = $this->getJiZu($info['jiazuz']);
        unset($info);
        return $list;
    }

    public function _ylfyzffs($k)
    {
        return $this->ylfyzffs[$k];
    }

    public function getylfyzffs($arr,$qt)
    {
        $res =explode('、',$arr);
        $data =[];
        if(count($res) == 0) return '未填写';
        foreach($res as $k=>$v)
        {
            $data[] = $this->_ylfyzffs($v);
        }
        if($qt) $data['qita'] = $qt;
        unset($res);
        return $data;
    }
    public function _baolushi($k)
    {
        return  $this->baolushi[$k];
    }

     public function getbaolushi($arr)
     {
         $res =explode('、',$arr);
         $data =[];
         if(count($res) == 0) return '未填写';
         foreach($res as $k=>$v)
         {
             $data[] = $this->_baolushi($v);
         }
         unset($res);
         return $data;
     }
    public function _yaowuguomin($k)
    {
        return $this->yaowuguomin[$k];
    }

     public function getYaoWuGuoMin($arr,$qt)
     {
         $res = explode("、", $arr);
         $data =[];
         if(count($res) == 0) return '未填写';
         foreach($res as $k=>$v)
         {
             $data[] = $this->_yaowuguomin($v);
         }
         if($qt) $data['qita'] = $qt;
         unset($res);
         return $data;
     }
    public function _yichuan($k)
    {
        return ($k && $k != '2') ? '无' : '未填写';
    }

    public function _canji($k)
    {
        return $this->canji[$k];
    }

     public function getCanji($arr,$qt)
     {
         $res =explode('、',$arr);
         $data =[];
         if(count($res) == 0) return '未填写';
         foreach($res as $k=>$v)
         {
             $data[] = $this->_canji($v);
         }
         if($qt) $data['qita'] = $qt;
         unset($res);
         return $data;
     }

    public function getJiZu($arr)
    {
        $res =explode('、',$arr);
        $data =[];
        if(count($res) == 0) return '未填写';
        foreach($res as $k=>$v)
        {
            $data[] = $this->_jiazu($v);
        }
        unset($res);
        return $data;
    }

    public function _jiazu($k)
    {
        $list = ['无','高血压','糖尿病','冠心病','慢性阻塞性肺疾病','恶性肿瘤','脑卒中','重性精神疾病','结核病','肝炎','先天畸形'];
        $k = (int)$k-1;
        return $list[$k];
    }
    public function xuexing($k)
    {
        if($k)
        {
            $arr = ['A型','B型','O型','AB型','不详'];
            $k = (int)$k-1;
            return $arr[$k];
        }
        else
        {
            return '未填写';
        }
    }

    private function checkList($k,$p)
    {
        if($k == null)
        {
            return '未填写';
        }
        else
        {
            switch($p)
            {
                case 1:
                    $res =  M('code_degree')->field('DegreeName')->where("DegreeID = '$k'")->find();
                    return $res['degreename'];
                break;
                case 2:
                    $res = M('code_career')->field('CareerName')->where("CareerID = '$k'")->find();
                    return $res['careername'];
                break;
                case 3:
                    $res = M('code_marital')->field('MaritalName')->where("MaritalID = '$k'")->find();
                    return $res['maritalname'];
                break;
            }

        }
    }
}