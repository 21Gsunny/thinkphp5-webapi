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
namespace app\tijian\model;
use think\Model;

class ContecEcg extends Model
{
    protected $connection = [

        'hostname'=>'192.168.8.249',
        'database'=>'contec_ecg',
        'username'=>'root',
        'password'=>'skycloud'
    ];

    private $tabname;
    private $where=[];
    private $data = [];
    public $userid;
    public $date;
    private $field;
    public function user_info_search()
    {
        $this->tabname = 'userinfo';
        $this->field = 'heigth';
        $info = M($this->tabname)->field($this->field)->where("personid = '".$this->userid."'")->find();
        return $info ? $info : false;
    }
}