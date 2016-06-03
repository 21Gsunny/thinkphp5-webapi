<?php
/*
 * +-----------------------------------   
 * @author: Rommel/左俊光.
 * @E-mail:rommel.zuo@outlook.com
 * @Date: 2016/6/3
 * @Time: 13:57
 * @Remarks : app 后台去生命体征仪器的数据
 * +-------------------------------------
 */
namespace app\contec\model;
use think\Model;
class vitalSigns extends Model
{
    public $userid = '';
    public static $tablename;
    public $fields;
    public $where;
    public $type = 'find';

    public function user_info_search()
    {
        return M("userinfo")->db(2,DB_CONFIG2)->where("personid = '".$this->userid."'")->getField('heigth');
    }
    public function doCheckInfoFind()
    {
        if(count(M()->db(2,DB_CONFIG2)->query("show tables like '".self::$tablename."'"))==1)
        {
            return M(self::$tablename)->db(2, DB_CONFIG2)->field($this->fields)->where($this->where)->order('id desc')->find();
        }
        else
        {
            return false;
        }
    }

    public function doCheckInfoSelect()
    {
        if(count(M()->db(2,DB_CONFIG2)->query("show tables like '".self::$tablename."'")) != 1) return false;
        return M(self::$tablename)->db(2, DB_CONFIG2)->field($this->fields)->where($this->where)->order('date desc')->select();
    }

    public function getBloodPressure($date)
    {
        $tabend = substr(date('Ym',strtotime($date)), 2);
        self::$tablename = "bp".$tabend;
        $this->fields = 'id,systolicpressure,diastolicpressure,date';
        if($this->type == 'find')
        {
            $this->where = ['userid'=>$this->userid,'date'=>$date];
            $info = $this->doCheckInfoFind();
            return (!empty($info)) ? ['testingId'=>$info['id'],'time'=>$info['date'],'item'=>'xueya','value'=>'sbp-'.$info['systolicpressure'].',dbp-'.$info['diastolicpressure']] : false;
        }
        else
        {
            $this->where = ['userid'=>$this->userid];
            $info = $this->doCheckInfoSelect();
            return (!empty($info)) ? $info : '无该项检测记录';
        }

    }
    public function getBloodsugar($date)
    {
        $tabend = substr(date('Ym',strtotime($date)), 2);
        self::$tablename = "bloodsugar".$tabend;
        $this->fields = 'limosisbg';
        if($this->type == 'find')
        {
            $this->where = ['userid'=>$this->userid,'date'=>$date];
            $info = $this->doCheckInfoFind();
            return ($info) ? $info['limosisbg'].'mmol/L' : '无此项检测';
        }
        else
        {
            $this->where = ['userid'=>$this->userid];
            $info = $this->doCheckInfoSelect();
            return (!empty($info)) ? $info : '无该项检测记录';
        }
    }
}