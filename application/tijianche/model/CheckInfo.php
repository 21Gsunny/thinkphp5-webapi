<?php
/*
 * +-----------------------------------   
 * @author: Rommel/左俊光.
 * @E-mail:rommel.zuo@outlook.com
 * @Date: 16-3-1
 * @Time: 下午7:31
 * @Remarks : 
 * +-------------------------------------
 */
namespace app\tijianche\model;
use think\Model;

class CheckInfo extends Model
{

    protected $trueTableName = 'tjc_checkinfo';
    protected $id = '';
    public function checkZjhm()
    {
        if(I('post.ID'))
        {
            return checkIdCard(I('post.ID'));
        }
        else
        {
            return false;
        }
    }

    public function addPost()
    {
        $this->id = $this->addCheckInfo();
        if($this->id)
        {
            if(!$this->addBlood()) return errorInfo('添加血液检查失败');
            if(!$this->addBiochemistry()) return errorInfo('添加生化检测失败');
            return successReturn();
        }
        else
        {
            return errorInfo();
        }
    }

    private function addCheckInfo()
    {
        $this->zjhm = I('post.ID');
        $this->personName = I('post.Name');
        $this->CheckDate = I('post.CheckDate') ? strtotime(I('post.CheckDate')) : strtotime(date('Y-m-d'));
        $this->SG = I('post.SG');
        $this->TZ = I('post.TZ');
        $this->TW = I('post.TW');
        $this->ML = I('post.ML');
        $this->HX = I('post.HX');
        $this->YW = I('post.YW');
        $this->BCHAO = I('post.BCHAO');
        $this->BCHAOQT = I('post.BCHAOQT');
        $this->sex = I('post.XB');
        $this->XZQHBM = I('post.XZQHBM');
        $this->XZQHMC = I('post.XZQHMC');
        $this->JBJGID = I('post.JBJGID');
        $this->JBJGName = I('post.JBJGName');
        $this->JBJGCode = I('post.JBJGCode');
        $this->JBJGPath = I('post.JBJGPath');

        $id = $this->add();

        return $id ? $id : false;
    }

    private function addBlood()
    {
        $M = M('tjc_blood');
        $M->checkID = $this->id;
        $M->XCG_WBC = I('post.XCG_WBC');
        $M->XCG_HGB = I('post.XCG_HGB');
        $M->XCG_PLT = I('post.XCG_PLT');
        $M->XZ_CHO = I('post.XZ_CHO');
        $M->XZ_TG = I('post.XZ_TG');
        $M->KFXT =  I('post.KFXT');
        $M->XDT_OPT =  I('post.XDT_OPT');
        $M->XDT_EXP =  I('post.XDT_EXP');
        $M->ZCSSY =  I('post.ZCSSY');
        $M->ZCSZY =  I('post.ZCSZY');
        $M->YCSSY =  I('post.YCSSY');
        $M->YCSZY =  I('post.YCSZY');
        $M->XZXL =  I('post.XZXL');
        $M->XZ_HDLC =  I('post.XZ_HDLC');
        $M->XZ_LDLC =  I('post.XZ_LDLC');

        return $M->add() ? true : false;
    }

    private function addBiochemistry()
    {
        $M = M('tjc_biochemistry');
        $M->checkID = $this->id;
        $M->NCG_NDB = I('post.NCG_NDB');
        $M->NCG_NT = I('post.NCG_NT');
        $M->NCG_NTT = I('post.NCG_NTT');
        $M->NCG_NQX = I('post.NCG_NQX');
        $M->GGN_ALT = I('post.GGN_ALT');
        $M->GGN_AST = I('post.GGN_AST');
        $M->GGN_ALB = I('post.GGN_ALB');
        $M->GGN_TBIL = I('post.GGN_TBIL');
        $M->GGN_DBIL = I('post.GGN_DBIL');
        $M->SGN_SCR = I('post.SGN_SCR');
        $M->SGN_BUN = I('post.SGN_BUN');

        return $M->add() ? true : false;
    }
}