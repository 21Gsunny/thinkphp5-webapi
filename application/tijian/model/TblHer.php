<?php
/*
 * +-----------------------------------   
 * @author: Rommel/左俊光.
 * @E-mail:rommel.zuo@outlook.com
 * @Date: 16-2-18
 * @Time: 下午6:39
 * @Remarks : 操作tbl_her数据表
 * +-------------------------------------
 */
namespace app\tijian\model;
use think\Model;
use components\various;
class TblHer extends Model
{

    public $id ;
    /**
     * @return array|bool
     * 获取体检记录列表
     */
    public function getList()
    {
        return $this->listResult($this->listFind());
    }
    private function listFind()
    {
        return $this->field('HERID,UserID,tjrq,jkpj')->where("zjhm='".I('get.id')."'")->select();
    }

    private function listResult($list)
    {
        if($list == null && empty($list)) return false;
        $result = [];
        foreach($list as $k=>$v){
            $result[$k]['examId'] = $v['herid'];
            $result[$k]['docName'] = ($v['userid']) ? D('common/Docter')->getName($v['userid']): '未填写';
            $result[$k]['date'] = changeDate($v['tjrq']);
            $result[$k]['evaluate'] = ($v['jkpj'] == '1') ? '体检无异常' : '有异常';
        }

        return $result;
    }

    public function checkHerID($id)
    {
        if($id)
        {
            return ($this->field('HERID')->where("HERID='{$id}'")->find()) ? true : false ;
        }
        else
        {
            return false;
        }
    }

    public function getTiJianKT()
    {
        return ($this->checkHerID(I('get.herid'))) ? $this->TiJianKTrestult($this->TiJianKTFind()) : false;

    }
    public function getTiJian()
    {
        $id = $this->id;
        return ($this->checkHerID($id)) ? $this->tijianResult($this->tiJianFind($id)) : false;
    }
    public function tiJianFind($id)
    {
        return $this->where("HERID='{$id}'")->find();
    }
    private function TiJianKTFind()
    {
         return $this->field('HERID,tw,ml,hxpl,zssy,zszy,sg,tz,yw,tzzs')->where("HERID='".I('get.herid')."'")->find();
    }

    protected function tijianResult($list)
    {
        $list['herid'] = $list['herid'];
        $list['tw'] = ($list['tw']) ? $list['tw'].'℃' : '未填写';
        $list['ml'] = ($list['ml']) ? $list['tw'].'次/分钟' : '未填写';
        $list['hxpl'] = ($list['hxpl']) ? $list['hxpl'].'次/分钟' : '未填写';
        $list['zssy'] = ($list['zssy']) ? $list['zssy'] : '未填写';
        $list['zszy'] = ($list['zszy']) ? $list['zszy'] : '未填写';
        $list['sg'] = ($list['sg']) ? $list['sg'].'cm' : '未填写';
        $list['tz'] = ($list['tz']) ? $list['tz'].'kg' : '未填写';
        $list['yw'] = ($list['yw']) ? $list['yw'].'cm' : '未填写';
        $list['tzzs'] = ($list['tzzs']) ? $list['tzzs'].'Kg/m^2' : '未填写';
        $list['zz'] = _keyarrValue($list['zz'],$this->getzz());
        $list['jkzt'] = _keyValue($list['jkzt'],$this->lnr_jkzt());
        $list['zlnl'] = _keyValue($list['zlnl'],$this->lnr_zlnl());
        $list['rzgn'] = _keyValue($list['rzgn'],$this->lnr_rzqg());
        $list['qgzt'] = _keyValue($list['qgzt'],$this->lnr_rzqg());
        $list['dlpl'] = _keyValue($list['dlpl'],$this->duanLianPinLv());
        $list['dlsj'] = ($list['dlsj']) ? $list['dlsj'].'分钟' : '未填写';
        $list['jcdlsj'] = ($list['jcdlsj']) ? $list['jcdlsj'].'年' : '未填写';
        $list['ysxg'] = _keyarrValue($list['ysxg'],$this->yinshixiguan());
        $list['xyzk'] = _keyValue($list['xyzk'],$this->xiyan());
        $list['rxyl'] = ($list['rxyl']) ? $list['rxyl'].'只' : '未填写';
        $list['xynl'] = ($list['xynl']) ? $list['xynl'].'年' : '未填写';
        $list['jynl'] = ($list['jynl']) ? $list['jynl'].'年' : '未填写';
        $list['yjpl'] = _keyValue($list['yjpl'],$this->yinjiupinlv());
        $list['ryjl'] = ($list['ryjl']) ? '平均'.$list['ryjl'].'两' : '未填写';
        $list['sfjj'] = _keyValue($list['sfjj'],['未戒酒','已戒酒']);
        $list['jjnl'] = ($list['jjnl']) ? $list['jjnl'].'岁' : '未填写';
        $list['ksyjnl'] = ($list['ksyjnl']) ? $list['ksyjnl'].'岁' : '未填写';
        $list['yjzl'] = _keyarrValue($list['yjzl'],$this->yinjiuzl(),$list['yjzlqt']);
        $list['zj'] = _keyValue($list['zj'],['是','否']);
        if($list['jcs'] == '2')
        {
           for($i=1;$i<=4;$i++)
           {
               if($list["dwzl{$i}"]) $list['dwzl'] .= $list["dwzl{$i}"].',';
               if($list["zl{$i}"]) $list['zl'] = _keyValue($list["zl{$i}"],various::is_has());
           }
        }
        else
        {
            $list['jcs'] = '无';
        }
        $list['kc'] = _keyValue($list['kc'],$this->kq_kc());
        $list['cl'] = _keyValue($list['cl'],$this->kq_cl());
        $list['yb'] = _keyValue($list['yb'],$this->kq_yb());
        $list['tl'] = _keyValue($list['tl'],$this->tingli());
        $list['ydgn'] = _keyValue($list['ydgn'],$this->yundong());
        $list['yd'] = _keyValue($list['yd'],various::is_false());
        $list['pf'] = _keyValue($list['pf'],$this->pifu($list['pfqt']));
        $list['gm'] = _keyValue($list['gm'],$this->gongmo($list['gmqt']));
        $list['lbj'] = _keyValue($list['lbj'],$this->linbajie($list['lbjqt']));
        $list['tzx'] = _keyValue($list['tzx'],various::is_has());
        $list['hxy'] = _keyValue($list['hxy'],various::is_false());
        $list['ly'] = _keyValue($list['ly'],$this->luoyin($list['lyqt']));
        $list['xl'] = ($list['xl']) ? $list['xl'].'次/分钟' : '未填写';
        $list['xlv'] = _keyValue($list['xlv'],$this->xinlv());
        $list['zy'] = _keyValue($list['zy'],various::is_has());
        $list['fbyt'] = _keyValue($list['fbyt'],various::is_has());
        $list['fbbk'] = _keyValue($list['fbbk'],various::is_has());
        $list['fbgd'] = _keyValue($list['fbgd'],various::is_has());
        $list['fbpd'] = _keyValue($list['fbpd'],various::is_has());
        $list['fbzy'] = _keyValue($list['fbzy'],various::is_has());
        $list['xzsz'] = _keyValue($list['xzsz'],$this->xiazhishuizhong());
        $list['zbdm'] = _keyValue($list['zbdm'],$this->zubeidongmai());
        $list['gmzz'] = _keyValue($list['gmzz'],$this->gangmen($list['gmzzqt']));
        $list['rx'] = _keyValue($list['rx'],$this->ruxian($list['rxqt']));
        $list['fkwy'] = _keyValue($list['fkwy'],$this->fuke($list['fkwyyc']));
        $list['fkyd'] = _keyValue($list['fkyd'],$this->fuke($list['fkydyc']));
        $list['fkgj'] = _keyValue($list['fkgj'],$this->fuke($list['fkgjyc']));
        $list['fkgt'] = _keyValue($list['fkgt'],$this->fuke($list['fkgtyc']));
        $list['fkfj'] = _keyValue($list['fkfj'],$this->fuke($list['fkfjyc']));
        $list['xhdb'] = ($list['xhdb']) ? $list['xhdb'].'g/L' : '未填写';
        $list['bxb'] = ($list['bxb']) ? $list['bxb'].'×10^9/L' : '未填写';
        $list['xxb'] = ($list['xxb']) ? $list['xxb'].'×10^9/L' : '未填写';
        $list['kfxt1'] = ($list['kfxt1']) ? $list['kfxt1'].'mmol/L' : '未填写';
        $list['xdt'] = _keyValue($list['xdt'],$this->xindiantu($list['xdtyc']));
        $list['nwlbdb'] = ($list['nwlbdb']) ? $list['nwlbdb'].'mg/dL' : '未填写';
        $list['thxhdb'] = ($list['thxhdb']) ? $list['thxhdb'].'%' : '未填写';
        $list['dbqx'] = _keyValue($list['dbqx'],various::is_positive());
        $list['ygky'] = _keyValue($list['ygky'],various::is_positive());
        $list['xqgbzam'] = ($list['xqgbzam']) ? $list['xqgbzam'].'U/L' : '未填写';
        $list['xqgczam'] = ($list['xqgczam']) ? $list['xqgczam'].'U/L' : '未填写';
        $list['bdb'] = ($list['bdb']) ? $list['bdb'].'g/L' : '未填写';
        $list['zdhs'] = ($list['zdhs']) ? $list['zdhs'].'μmol/L' : '未填写';
        $list['jhdhs'] = ($list['jhdhs']) ? $list['jhdhs'].'μmol/L' : '未填写';
        $list['xqjg'] = ($list['xqjg']) ? $list['xqjg'].'μmol/L' : '未填写';
        $list['xnsd'] = ($list['xnsd']) ? $list['xnsd'].'mmol/L' : '未填写';
        $list['xjnd'] = ($list['xjnd']) ? $list['xjnd'].'mmol/L' : '未填写';
        $list['xnnd'] = ($list['xnnd']) ? $list['xnnd'].'mmol/L' : '未填写';
        $list['zdgc'] = ($list['zdgc']) ? $list['zdgc'].'mmol/L' : '未填写';
        $list['dmdgc'] = ($list['dmdgc']) ? $list['dmdgc'].'mmol/L' : '未填写';
        $list['gysz'] = ($list['gysz']) ? $list['gysz'].'mmol/L' : '未填写';
        $list['gmdgc'] = ($list['gmdgc']) ? $list['gmdgc'].'mmol/L' : '未填写';
        $list['xxp'] = _keyValue($list['xxp'],various::is_false($list['xxpyc']));
        $list['bc'] = _keyValue($list['bc'],various::is_false($list['bcyc']));
        $list['gjtp'] = _keyValue($list['gjtp'],various::is_false($list['gjtpyc']));
        for($i=1;$i<=9;$i++)
        {
            if($list["bs{$i}"]) $list['zytzbs'] .= _keyValue(($i-1),$this->zhongyitizhi()).':'._keyValue($list["bs{$i}"],$this->zhongyi());
            unset($list["bs{$i}"]);
        }
        $list['jkwt'] = '';
        if($list['nxg']) $list['jkwt'] = _keyarrValue($list['nxg'],$this->naoxueguan());
        if($list['sz']) $list['jkwt'] .= _keyarrValue($list['sz'],$this->shenzang());
        if($list['xz']) $list['jkwt'] .= _keyarrValue($list['xz'],$this->xinzang());
        if($list['xg']) $list['jkwt'] .= _keyarrValue($list['xg'],$this->xueguan());
        if($list['rblyb']) $list['jkwt'] .= _keyarrValue($list['rblyb'],$this->yanbu());
        $yc1='';
        if($list['jkpj'] == '2')
        {
            for($i=1;$i<=4;$i++)
            {
                if($list["yc{$i}"]) $yc1 .= $i.'.'. $list["yc{$i}"];
            }
            unset($list["yc{$i}"]);
        }
        $list['jkpj'] = _keyValue($list['jkpj'],$this->jtpj($yc1));
        $list['jkzd'] = _keyarrValue($list['jkzd'],$this->jkzd());
        $list['wxyskz'] = _keyarrValue($list['wxyskz'],$this->weixian(),$list['wxysqt']);
        return $list;
    }
    private function TiJianKTrestult($list)
    {
        $result = [];

        $result['tijianid'] = $list['herid'];
        $result['tiwen'] = ($list['tw']) ? $list['tw'].'℃' : '未填写';
        $result['mailv'] = ($list['ml']) ? $list['tw'].'次/分钟' : '未填写';
        $result['huxipinlv'] = ($list['hxpl']) ? $list['hxpl'].'次/分钟' : '未填写';
        $result['zuoceshousuo'] = ($list['zssy']) ? $list['zssy'].'mmHg' : '未填写';
        $result['zuoceshuzhang'] = ($list['zszy']) ? $list['zszy'].'mmHg' : '未填写';
        $result['shengao'] = ($list['sg']) ? $list['sg'].'cm' : '未填写';
        $result['tizhong'] = ($list['tz']) ? $list['tz'].'kg' : '未填写';
        $result['yaowei'] = ($list['yw']) ? $list['yw'].'cm' : '未填写';
        $result['tizhizishu'] = ($list['tzzs']) ? $list['tzzs'].'Kg/m2' : '未填写';
        unset($list);
        return $result;
    }

    /**
     * @param $yc 异常描述
     * @return array 心电图
     */
    public function xindiantu($yc)
    {
        $yc = $yc ? '异常:'.$yc : '异常:无描述';
        return ['正常',$yc,'无'];
    }
    /**
     * @return array  健康体检-> 症状
     */
    public function getzz()
    {
        return ['无症状','头疼','头晕','心悸','胸闷','慢性咳嗽','咳痰','呼吸困难','多饮','多尿','体重下降','乏力','关节肿痛','视力模糊','手脚麻木','尿急','便秘','腹泻','恶心呕吐','眼花','耳鸣','乳房胀痛','其他'];
    }

    /**
     * @return array 健康体检-> 老年人健康状态
     */
    public function lnr_jkzt()
    {
      return  ['满意','基本满意','说不清楚','不太满意','不满意'];
    }

    /**
     * @return array 健康体检-> 老年人自理能力
     */
    public function lnr_zlnl()
    {
        return  ['可自理','轻度依赖','中度依赖','不能自理'];
    }

    /**
     * @return array  健康体检-> 老年人认知功能和情况状态
     */
    public function lnr_rzqg()
    {
        return  ['粗筛阴性','粗筛阳性'];
    }

    /**
     * @return array 锻炼频率
     */
    public function duanLianPinLv()
    {
        return ['每天','每周一次以上','偶尔','不锻炼'];
    }

    /**
     * @return array 饮食习惯
     */
    public function yinshixiguan()
    {
        return ['荤素均衡','荤食为主','素食为主','嗜盐','嗜油','嗜糖'];
    }

    /**
     * @return array 吸烟状况
     */
    public function xiyan()
    {
        return ['从不吸烟','已戒烟','吸烟'];
    }

    /**
     * @return array 饮酒情况
     */
    public function yinjiupinlv()
    {
        return ['从不','偶尔','经常','每天'];
    }

    /**
     * @return array 饮酒种类
     */
    public function yinjiuzl()
    {
        return ['白酒','啤酒','红酒','黄酒'];
    }

    /**
     * @return array 口腔-口唇
     */
    public function kq_kc()
    {
        return ['红润','苍白','发绀','皲裂','疱疹'];
    }

    /**
     * @return array 口腔-齿列
     */
    public function kq_cl()
    {
        return ['正常','缺齿','龋齿','义齿(假牙)'];
    }

    /**
     * @return array 口腔-咽部
     */
    public function kq_yb()
    {
        return ['无充血','充血','淋巴滤泡增生'];
    }

    /**
     * @return array 听力
     */
    public function tingli()
    {
        return ['听见','听不清或无法听清'];
    }

    /**
     * @return array 运动功能
     */
    public function yundong()
    {
        return ['可顺利完成','无法独立完成其中任意一个动作'];
    }

    /**
     * @return array 查体-皮肤
     */
    public function pifu($qt)
    {
        return ['正常','潮红','苍白','发绀','黄染','色素沉着',$qt];
    }

    /**
     * @return array 查体-巩膜
     */
    public function gongmo($qt)
    {
        return ['正常','黄染','充血',$qt];
    }

    /**
     * @return array 查体-淋巴结
     */
    public function linbajie($qt)
    {
        return ['未触及','锁骨上','腋窝',$qt];
    }

    /**
     * @return array 查体-肺部-啰音
     */
    public function luoyin($qt)
    {
        return ['无','干罗音','湿罗音',$qt];
    }

    /**
     * @return array 查体-心脏-心律
     */
    public function xinlv()
    {
        return ['齐','不齐','绝对不齐'];
    }
    /**
     * @return array 查体-下肢水肿
     */
    public function xiazhishuizhong()
    {
        return ['无','单侧','双侧不对称','双侧对称'];
    }

    /**
     * @return array 查体-足背动脉搏动
     */
    public function zubeidongmai()
    {
        return ['未触及','触及双侧对称','触及左侧弱或消失','触及右侧弱或消失'];
    }

    /**
     * @return array 查体-肛门指诊
     */
    public function gangmen($qt)
    {
        return ['未见异常','触痛','包块','前列腺异常',$qt];
    }

    /**
     * @return array 查体-乳腺
     */
    public function ruxian($qt)
    {
        return ['未见异常','乳房切除','异常泌乳','乳腺包块',$qt];
    }

    /**
     * @param $yc 有异常的异常描述
     * @return array 查体-妇科
     */
    public function fuke($yc)
    {
        $yc = $yc ? '异常:'.$yc : '异常';
        return ['未见异常',$yc];
    }
    /**
     * @return array 中医体质辨识
     */
    public function zhongyi()
    {
        return ['是','倾向是'];
    }
    public function zhongyitizhi()
    {
        return ['平和质','气虚质','阳虚质','阴虚质','痰湿质','湿热质','血瘀质','气郁质','特禀质'];
    }
    /**
     * @return array 主要健康问题-脑血管疾病
     */
    public function naoxueguan()
    {
        return ['未发现','缺血性卒中','脑出血','蛛网膜下腔出血','短暂性脑缺血发作'];
    }

    /**
     * @return array 主要健康问题-肾脏疾病
     */
    public function shenzang()
    {
        return ['未发现','糖尿肾病','肾功能衰竭','急性肾炎','慢性肾炎'];
    }
    /**
     * @return array 主要健康问题-心脏疾病
     */
    public function xinzang()
    {
        return ['未发现','心肌梗死','心绞痛','冠状动脉血运重建','充血性心力衰竭','心前区疼痛'];
    }
    /**
     * @return array 主要健康问题-血管疾病
     */
    public function xueguan()
    {
        return ['未发现','夹层动脉瘤','动脉闭塞性疾病'];
    }
    /**
     * @return array 主要健康问题-眼部疾病
     */
    public function yanbu()
    {
        return ['未发现','视网膜出血或渗出','视乳头水肿','白内障'];
    }

    /**
     * @return array 健康指导-健康评价
     */
    public function jtpj($yc)
    {
        return ['体检不异常','有异常:'.$yc];
    }

    /**
     * @return array 健康指导-危险因素控制
     */
    public function weixian()
    {
        return ['戒烟','健康饮酒','饮食','锻炼','减体重','建议接种疫苗'];
    }

    /**
     * @return array 健康指导-健康指导意见
     */
    public function jkzd()
    {
        return ['纳入慢性病患者健康管理','建议复查','建议转诊'];
    }
}