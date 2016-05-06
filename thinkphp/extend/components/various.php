<?php
/*
 * +-----------------------------------   
 * @author: Rommel/左俊光.
 * @E-mail:rommel.zuo@gmail.com
 * @Date: 2016/4/21
 * @Time: 14:16
 * @Remarks : 个别的系统参数处理以及系统业务逻辑和数据之外
 * +-------------------------------------
 */
namespace components;
class various
{
    public static function getAge($birthday)
    {
        $age = 0;
        $year = $month = $day = 0;
        if (is_array($birthday))
        {
            extract($birthday);
        }
        else
        {
            if (strpos($birthday, '-') !== false)
            {
                list($year, $month, $day) = explode('-', $birthday);
                $day = substr($day, 0, 2);
            }
        }
        $age = date('Y') - $year;
        if (date('m') < $month || (date('m') == $month && date('d') < $day)) $age--;
        return $age;
    }

    public static function is_has($has = false)
    {
        $has = $has ? '有:'.$has : '有';
        return ['无',$has];
    }

    public static function is_false($yc=false)
    {
        $yc = $yc ? '异常:'.$yc : '异常:无描述';
        return ['正常',$yc];
    }

    public static function is_positive()
    {
        return ['阴性','阳性'];
    }

    public static function fllowType()
    {
        return ['门诊','家庭','电话'];
    }

    public static function state()
    {
        return ['良好','一般','较差'];
    }
}