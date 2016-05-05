<?php

// 操作错误返回
function errorInfo($info)
{
     $str = $info ? $info : '操作失败';
     return ['code'=>0,'message'=>$str];
}

// 操作正确返回
function successInfo($data)
{
    return ['data'=>$data,'code'=>1,'message'=>'success'];
}

function methodError()
{
    return ['code'=>110,'message'=>'请求方式错误'];
}
function successReturn()
{
    return ['code'=>1,'message'=>'操作成功'];
}
function changeDate($time)
{
    if($time)
    {
        return (date("Y-m-d",strtotime($time)) == '1970-01-01') ? '未填写' : date("Y-m-d",strtotime($time));
    }
    else
    {
        return '未填写';
    }
}

// 验证身份证号码合法性
function checkIdCard($idcard)
{

    // 只能是18位
    if(strlen($idcard)!=18){
        return false;
    }

    // 取出本体码
    $idcard_base = substr($idcard, 0, 17);

    // 取出校验码
    $verify_code = substr($idcard, 17, 1);

    // 加权因子
    $factor = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);

    // 校验码对应值
    $verify_code_list = array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2');

    // 根据前17位计算校验码
    $total = 0;
    for($i=0; $i<17; $i++){
        $total += substr($idcard_base, $i, 1)*$factor[$i];
    }

    // 取模
    $mod = $total % 11;

    // 比较校验码
    if($verify_code == $verify_code_list[$mod]){
        return true;
    }else{
        return false;
    }

}

function _keyarrValue($karr,$res,$qt)
{
    if(empty($karr) || $karr == null) return '未填写';
    $karr =explode('、',$karr);
    if(count($karr) == 0) return '未填写';
    $data;
    foreach($karr as $k=>$v)
    {
        $i = (int)$v-1;
        $data[] = $res[$i];
    }
    if($qt) $data['qita'] = $qt;
    unset($res);
    return $data;
}

function _keyValue($k,$res=[])
{
    if(empty($k) || $k == null) return '未填写';
    $k = (int)$k - 1;
    return $res[$k];
}
?>
