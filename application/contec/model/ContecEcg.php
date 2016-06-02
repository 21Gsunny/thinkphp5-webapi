<?php
/*
 * +-----------------------------------   
 * @author: Rommel/左俊光.
 * @E-mail:rommel.zuo@outlook.com
 * @Date: 2016/3/28
 * @Class: ContecEcg Model
 * @Remarks : 体检数据获取 血压、身高、血糖、体重、心率、呼吸、血氧，脉率、体温、心电图
 * +-------------------------------------
 */
namespace app\contec\model;
use think\Model;

class ContecEcg extends Model
{
    public $userid = '';
    public static $tablename;
    public $fields;
    public $where;
    public $type = 'find';
    public function getUserInfo()
    {
        $info = $this->user_info_search();
        if($info)
        {
            $info['sex'] = ($info['sex'] == '0') ? '男' : '女';
            $info['height'] = $info['height'].'cm';
            return $info;
        }
        else
        {
            return false;
        }
    }

    public function user_info_search()
    {
        return M("userinfo")->db(2,DB_CONFIG2)->field('username,height,sex,birthday,address')->where("personid = '".$this->userid."'")->find();
    }

    public function doCheckInfoFind()
    {
        if(count(M()->db(2,DB_CONFIG2)->query("show tables like '".self::$tablename."'"))==1)
        {
            return M(self::$tablename)->db(2, DB_CONFIG2)->field($this->fields)->where($this->where)->find();
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
    public function getHeartrate($date)
    {
        $tabend = substr(date('Ym',strtotime($date)), 2);
        self::$tablename = "heartrate".$tabend;
        if($this->type == 'find')
        {
            $this->fields = 'heartrate';
            $this->where = ['userid'=>$this->userid,'date'=>$date];
            $info = $this->doCheckInfoFind();
            return ($info) ? $info['heartrate'].'次/分钟' : '无此项检测';
        }
        else
        {
            $this->fields = 'heartrate,date';
            $this->where = ['userid'=>$this->userid];
            $info = $this->doCheckInfoSelect();
            return (!empty($info)) ? $info : '无该项检测记录';
        }

    }
    public function getBloodsugar($date)
    {
        $tabend = substr(date('Ym',strtotime($date)), 2);
        self::$tablename = "bloodsugar".$tabend;
        if($this->type == 'find')
        {
            $this->fields = 'limosisbg';
            $this->where = ['userid'=>$this->userid,'date'=>$date];
            $info = $this->doCheckInfoFind();
            return ($info) ? $info['limosisbg'].'mmol/L' : '无此项检测';
        }
        else
        {
            $this->fields = 'limosisbg,date';
            $this->where = ['userid'=>$this->userid];
            $info = $this->doCheckInfoSelect();
            return (!empty($info)) ? $info : '无该项检测记录';
        }
    }

    public function getBloodPressure($date)
    {
        $tabend = substr(date('Ym',strtotime($date)), 2);
        self::$tablename = "bp".$tabend;
        if($this->type == 'find')
        {
            $this->fields = 'systolicpressure,diastolicpressure';
            $this->where = ['userid'=>$this->userid,'date'=>$date];
            $info = $this->doCheckInfoFind();
            return ($info) ? $info['systolicpressure'].'/'.$info['diastolicpressure'].'mmHg' : '无此项检测';
        }
        else
        {
            $this->fields = 'systolicpressure,diastolicpressure,averagepressure,date';
            $this->where = ['userid'=>$this->userid];
            $info = $this->doCheckInfoSelect();
            return (!empty($info)) ? $info : '无该项检测记录';
        }

    }

    public function getRespiration($date)
    {
        $tabend = substr(date('Ym',strtotime($date)), 2);
        self::$tablename = "respiration".$tabend;
        if($this->type == 'find')
        {
            $this->fields = 'resp';
            $this->where = ['userid'=>$this->userid,'date'=>$date];
            $info = $this->doCheckInfoFind();
            return ($info) ? $info['resp'].'次/分钟' : '无此项检测';
        }
        else
        {
            $this->fields = 'resp,date';
            $this->where = ['userid'=>$this->userid];
            $info = $this->doCheckInfoSelect();
            return (!empty($info)) ? $info : '无该项检测记录';
        }

    }

    public function getPulseRate($date)
    {
        $tabend = substr(date('Ym',strtotime($date)), 2);
        self::$tablename = "spo2".$tabend;
        if($this->type == 'find')
        {
            $this->fields = 'pulserate';
            $this->where = ['userid'=>$this->userid,'date'=>$date];
            $info = $this->doCheckInfoFind();
            return ($info) ? $info['pulserate'].'次/分钟' : '无此项检测';
        }
        else
        {
            $this->fields = 'pulserate,date';
            $this->where = ['userid'=>$this->userid];
            $info = $this->doCheckInfoSelect();
            return (!empty($info)) ? $info : '无该项检测记录';
        }

    }

    public function getSpo2($date)
    {
        $tabend = substr(date('Ym',strtotime($date)), 2);
        self::$tablename = "spo2".$tabend;
        if($this->type == 'find')
        {
            $this->fields = 'spo2';
            $this->where = ['userid'=>$this->userid,'date'=>$date];
            $info = $this->doCheckInfoFind();
            return ($info) ? $info['spo2'].'%' : '无此项检测';
        }
        else
        {
            $this->fields = 'spo2,date';
            $this->where = ['userid'=>$this->userid];
            $info = $this->doCheckInfoSelect();
            return (!empty($info)) ? $info : '无该项检测记录';
        }

    }

    public function getTemperature($date)
    {
        $tabend = substr(date('Ym',strtotime($date)), 2);
        self::$tablename = "temperature".$tabend;
        if($this->type == 'find')
        {
            $this->fields = 'temp';
            $this->where = ['userid'=>$this->userid,'date'=>$date];
            $info = $this->doCheckInfoFind();
            return ($info) ? $info['temp'].'℃' : '无此项检测';
        }
        else
        {
            $this->fields = 'temp,date';
            $this->where = ['userid'=>$this->userid];
            $info = $this->doCheckInfoSelect();
            return (!empty($info)) ? $info : '无该项检测记录';
        }
    }

    public function getWeigth($date)
    {
        $tabend = substr(date('Ym',strtotime($date)), 2);
        self::$tablename = "weight".$tabend;
        if($this->type == 'find')
        {
            $this->fields = 'weight';
            $this->where = ['userid'=>$this->userid,'date'=>$date];
            $info = $this->doCheckInfoFind();
            return ($info) ? $info['weight'].'kg' : '无此项检测';
        }
        else
        {
            $this->fields = 'weight,date';
            $this->where = ['userid'=>$this->userid];
            $info = $this->doCheckInfoSelect();
            return (!empty($info)) ? $info : '无该项检测记录';
        }
    }
}