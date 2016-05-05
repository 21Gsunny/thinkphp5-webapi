<?php
/*
 * +-----------------------------------
 * @author: Rommel/左俊光.
 * @E-mail:rommel.zuo@outlook.com
 * @Date: 16-2-18
 * @Time: 下午6:02
 * @Remarks : 对体检健康体检有关信息的操作路由
 * +-------------------------------------
 */
namespace app\tijian\controller;
use app\common\controller\Common;
use app\common\model\Docter;
use app\gerendangan\model\Cardinfo;
use app\gerendangan\model\PersonInfoBase;
use app\tijian\model\TblHer;
use components\jsonReturn;
use components\various;
class Home extends Common
{
    public function _initialize()
    {
        $this->checkCardInfo();
    }
    /**
     * @return 提示信息|array|
     * 获取健康体检列表
     */
    public function jktjList()
    {
        if($this->_check() === true)
        {
            $data = D('TblHer')->getList();
            if($data === false) return errorInfo();
            return successInfo($data);
        }
        else
        {
            return $this->_check();
        }
    }

    /**
     * @return \app\common\controller\提示信息|array|bool
     * 为app 提供体检记录
     */
    public function appJktjList()
    {
        if($this->_check() === true)
        {
            $data = [];
            $tj = D('TblHer')->getList();
            if($tj === false)
            {
                jsonReturn::$code = 302;
                jsonReturn::$status = 'fail';
                jsonReturn::$data = '该档案没有体检记录';
            }
            else
            {
                $card = new Cardinfo();
                $person = new PersonInfoBase();
                $cardinfo = $card->getCardinfo();
                $baseinfo = $person->getJiBenZhuangKuang();
                $data['userInfo']['name'] = $cardinfo['xingming'];
                $data['userInfo']['ID'] = $cardinfo['haoma'];
                $data['userInfo']['gender'] = $cardinfo['xingbie'];
                $data['userInfo']['phoneNum'] = $baseinfo['benrendianhua'];
                $data['userInfo']['hemotype'] = $baseinfo['xuexing'];
                $data['userInfo']['age'] = various::getAge($cardinfo['chushengriqi']);
                $data['physicalExamList'] = $tj;

                jsonReturn::$code = 302;
                jsonReturn::$status = 'success';
                jsonReturn::$data = $data;
            }
            jsonReturn::returnInfo();

        }
        else
        {
            return $this->_check();
        }
    }

    /**
     * @return array|bool
     * 为app获取体检内容（全部）
     */
    public function appJktjData()
    {
        if($this->_checkHerID() === true)
        {
            $check = new TblHer();
            $check->id = I('get.examId');
            $checkinfo = $check->getTiJian();
            if($checkinfo)
            {
                $card = new Cardinfo();
                $docer = new Docter();
                $cardinfo = $card->getCardinfo();
                $data['userInfo']['ID'] = $cardinfo['haoma'];
                $data['userInfo']['name'] = $cardinfo['xingming'];
                $data['userInfo']['physicalExaminationDate'] = changeDate($checkinfo['tjrq']);
                $data['userInfo']['responsibilityDoctor'] = $docer->getName($checkinfo['userid']);
                $data['userInfo']['symptom'] = $checkinfo['zz'];
                $data['generalSituation']['bodytemperature'] = $checkinfo['tw'];
                $data['generalSituation']['pulseRate'] = $checkinfo['ml'];
                $data['generalSituation']['breathRate'] = $checkinfo['hxpl'];
                $data['generalSituation']['bloodPressure'] = $checkinfo['zssy'] .'/'.  $checkinfo['zszy'].'mmHg';
                $data['generalSituation']['height'] = $checkinfo['sg'];
                $data['generalSituation']['weight'] = $checkinfo['tz'];
                $data['generalSituation']['waistline'] = $checkinfo['yw'];
                $data['generalSituation']['bmi'] = $checkinfo['tzzs'];
                $data['generalSituation']['elderlyHealthSelfAssessment'] = $checkinfo['jkzt'];
                $data['generalSituation']['elderlyLifeSelfCareAbilitySelfAssessment'] = $checkinfo['zlnl'];
                $data['generalSituation']['elderlyCognitiveFunction'] = $checkinfo['rzgn'];
                $data['generalSituation']['elderlyEmotionalState'] = $checkinfo['qgzt'];
                $data['lifeStyle']['physicalExercise']['exerciseFrequency'] = $checkinfo['dlpl'];
                $data['lifeStyle']['physicalExercise']['exerciseTimeEachTime'] = $checkinfo['dlsj'];
                $data['lifeStyle']['physicalExercise']['insistExerciseTime'] = $checkinfo['jcdlsj'];
                $data['lifeStyle']['physicalExercise']['exerciseWay'] = $checkinfo['dlfs'];
                $data['lifeStyle']['eatingHabits'] = $checkinfo['ysxg'];
                $data['lifeStyle']['smokingStatus']['smokStatus'] = $checkinfo['xyzk'];
                $data['lifeStyle']['smokingStatus']['smokePerDay'] = $checkinfo['rxyl'];
                $data['lifeStyle']['smokingStatus']['startSmokeAge'] = $checkinfo['xynl'];
                $data['lifeStyle']['smokingStatus']['quitSmokeAge'] = $checkinfo['jynl'];
                $data['lifeStyle']['drinkingStatus']['drinkFrequency'] = $checkinfo['yjpl'];
                $data['lifeStyle']['drinkingStatus']['dailyDrink'] = $checkinfo['ryjl'];
                $data['lifeStyle']['drinkingStatus']['temperance'] = $checkinfo['sfjj'];
                $data['lifeStyle']['drinkingStatus']['startDrinkingAge'] = $checkinfo['ksyjnl'];
                $data['lifeStyle']['drinkingStatus']['everDrunkNearlyOneYear'] = $checkinfo['zj'];
                $data['lifeStyle']['drinkingStatus']['drinkType'] = $checkinfo['yjzl'];
                if($checkinfo['jcs'] == '无')
                {
                    $data['lifeStyle']['contactOccupationalDiseaseInductiveFactors'] = '无职业病危险接触史';
                }
                else
                {
                    $data['lifeStyle']['contactOccupationalDiseaseInductiveFactors']['workType '] = $checkinfo['jcsgz'];
                    $data['lifeStyle']['contactOccupationalDiseaseInductiveFactors']['workTime '] = $checkinfo['jcscysj'].'年';
                    $data['lifeStyle']['contactOccupationalDiseaseInductiveFactors']['poisonType'] = $checkinfo['dwzl'];
                    $data['lifeStyle']['contactOccupationalDiseaseInductiveFactors']['protectiveMeasures'] = $checkinfo['zl'];
                }
                $data['visceraFunction']['mouth']['oral'] = $checkinfo['kc'];
                $data['visceraFunction']['mouth']['denture'] = $checkinfo['cl'];
                $data['visceraFunction']['mouth']['pharyngeal'] = $checkinfo['yb'];
                $data['visceraFunction']['vision']['leftEye'] = $checkinfo['zysl'];
                $data['visceraFunction']['vision']['rightEye'] = $checkinfo['yysl'];
                $data['visceraFunction']['hearing'] = $checkinfo['tl'];
                $data['visceraFunction']['motorFunction'] = $checkinfo['ydgn'];
                $data['physicalExamination']['fundus'] = $checkinfo['yd'];
                $data['physicalExamination']['skin'] = $checkinfo['pf'];
                $data['physicalExamination']['sclera'] = $checkinfo['gm'];
                $data['physicalExamination']['lymphNode'] = $checkinfo['lbj'];
                $data['physicalExamination']['lung']['barrelChest'] = $checkinfo['tzx'];
                $data['physicalExamination']['lung']['breathSounds'] = $checkinfo['hxy'];
                $data['physicalExamination']['lung']['rale'] = $checkinfo['ly'];
                $data['physicalExamination']['heart']['heartRate'] = $checkinfo['xl'];
                $data['physicalExamination']['heart']['heartrHythm'] = $checkinfo['xlv'];
                $data['physicalExamination']['heart']['noise'] = $checkinfo['zy'];
                $data['physicalExamination']['abdomen']['tenderness '] = $checkinfo['fbyt'];
                $data['physicalExamination']['abdomen']['bagPiece'] = $checkinfo['fbbk'];
                $data['physicalExamination']['abdomen']['hepatomegaly'] = $checkinfo['fbgd'];
                $data['physicalExamination']['abdomen']['splenauxe'] = $checkinfo['fbpd'];
                $data['physicalExamination']['abdomen']['shiftingDullness'] = $checkinfo['fbzy'];
                $data['physicalExamination']['lowerExtremityEdema'] = $checkinfo['xzsz'];
                $data['physicalExamination']['dorsalisPedisArteryPulse'] = $checkinfo['zbdm'];
                $data['physicalExamination']['anusDre'] = $checkinfo['gmzz'];
                $data['physicalExamination']['mammaryGland'] = $checkinfo['rx'];
                $data['physicalExamination']['gynecology']['vulva'] = $checkinfo['fkwy'];
                $data['physicalExamination']['gynecology']['vagina'] = $checkinfo['fkyd'];
                $data['physicalExamination']['gynecology']['cervical'] = $checkinfo['fkgj'];
                $data['physicalExamination']['gynecology']['corpus'] = $checkinfo['fkgt'];
                $data['physicalExamination']['gynecology']['accessory'] = $checkinfo['fkfj'];
                // 健康体检-辅助检查 血常规、尿常规、空腹血糖部分
                $data['physicalExamination']['routineBlood']['hemoglobin'] = $checkinfo['xhdb'];
                $data['physicalExamination']['routineBlood']['leukocyte'] = $checkinfo['bxb'];
                $data['physicalExamination']['routineBlood']['platelet'] = $checkinfo['xxb'];
                $data['physicalExamination']['routineUrine']['urinePro'] = '无';
                $data['physicalExamination']['routineUrine']['uglu'] = '无';
                $data['physicalExamination']['routineUrine']['ery'] = '无';
                //其中一个文档中没有这一项,需要核实
               // $data['physicalExamination']['analIndex'] = $checkinfo[''];
                $data['physicalExamination']['fbg'] = $checkinfo['kbft1'];
                //+------
                // 辅助检查部分
                //+------
                $data['auxiliaryExamination']['ecg'] = $checkinfo['xdt'];
                $data['auxiliaryExamination']['urineTraceAlbumin'] = $checkinfo['nwlbdb'];
                $data['auxiliaryExamination']['defecateOccultBlood'] = $checkinfo['dbqx'];
                $data['auxiliaryExamination']['glycatedHemoglobin'] = $checkinfo['thxhdb'];
                $data['auxiliaryExamination']['hepatitisBSurfaceAntigen'] = $checkinfo['ygky'];
                $data['auxiliaryExamination']['liverFunction']['serumAlt'] = $checkinfo['xqgbzam'];
                $data['auxiliaryExamination']['liverFunction']['serumAspertateAminotransferase'] = $checkinfo['xqgczam'];
                $data['auxiliaryExamination']['liverFunction']['albumin'] = $checkinfo['bdb'];
                $data['auxiliaryExamination']['liverFunction']['tBil'] = $checkinfo['zdhs'];
                $data['auxiliaryExamination']['liverFunction']['combiningBilirubin'] = $checkinfo['jhdhs'];
                $data['auxiliaryExamination']['renalFunction']['serumCreatinine'] = $checkinfo['xqjg'];
                $data['auxiliaryExamination']['renalFunction']['bloodUreaNitrogen'] = $checkinfo['xnsd'];
                $data['auxiliaryExamination']['renalFunction']['potassiumConcentration'] = $checkinfo['xjnd'];
                $data['auxiliaryExamination']['renalFunction']['serumNatriumLevel'] = $checkinfo['xnnd'];
                $data['auxiliaryExamination']['bloodFat']['totalCholesterol'] = $checkinfo['zdgc'];
                $data['auxiliaryExamination']['bloodFat']['triglyceride'] = $checkinfo['dmdgc'];
                $data['auxiliaryExamination']['bloodFat']['serumLevelsLowDensityLipoproteinCholesterol'] = $checkinfo['gysz'];
                $data['auxiliaryExamination']['bloodFat']['serumHighDensityLipoproteinCholesterol'] = $checkinfo['gmdgc'];
                $data['chestXray'] = $checkinfo['xxp'];
                $data['Bcan'] = $checkinfo['bc'];
                $data['cervicalSmear'] = $checkinfo['gjtp'];
                $data['constitutionTCMIdentification'] = $checkinfo['zytzbs'];
                $data['existingMajorHealthProblems'] = $checkinfo['jkwt'];
                $data['immunePlanningVaccinationHistory']['riskFactorsControl'] = $checkinfo['wxyskz'];
                $data['immunePlanningVaccinationHistory']['healthAssessment'] = $checkinfo['jkpj'];
                $data['immunePlanningVaccinationHistory']['healthGuidance']= $checkinfo['jkzd'];

                jsonReturn::$code = 303;
                jsonReturn::$status = 'success';
                jsonReturn::$data = $data;
            }
            else
            {
                jsonReturn::$status = 'fail';
                jsonReturn::$code = 303;
                jsonReturn::$data = '查询档案没有体检记录';
            }
            jsonReturn::returnInfo();
        }
        else
        {
            return $this->_checkHerID();
        }
    }
    public function jktjData()
    {
       if($this->_checkHerID() === true)
        {
            $data = D('TblHer')->getTiJianKT();
            if($data === false) return errorInfo();
            return successInfo($data);
        }
        else
        {
            return $this->_checkHerID();
        }

    }
}
