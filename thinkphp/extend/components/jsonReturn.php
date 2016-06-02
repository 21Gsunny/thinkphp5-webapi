<?php
/*
 * +-----------------------------------   
 * @author: Rommel/左俊光.
 * @E-mail:rommel.zuo@gmail.com
 * @Date: 2016/3/23
 * @Time: 13:45
 * @Remarks : 结果集返回
 * +-------------------------------------
 */
namespace components;
use think\Response;
class jsonReturn
{
    public static $status = 'success';

    public static $code = 1;

    public static $data;

    private static $result=[];
    public static function response()
    {
        self::$result = ['response'=>[
                'status'=>self::$status,
                'code'=>self::$code,
                'data'=>self::$data,
        ]];
        return self::$result;
    }

    public static function returnInfo()
    {
        self::$result = ['response'=>[
            'status'=>self::$status,
            'code'=>self::$code,
            'data'=>self::$data,
        ]];
        Response::data(self::$result);
        Response::type('json');
        Response::send();
        exit();
    }
}