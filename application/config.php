<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// $Id$

return [
    'url_route_on' => true,
   // 'url_route_must'=>  true,
    'default_return_type'=>'json',
  /* 'log' => [
        'type'             => 'socket', // 支持 socket trace file
        // 以下为socket类型配置
        'host'             => '127.0.0.1',
        //日志强制记录到配置的client_id
        'force_client_ids' => [],
        //限制允许读取日志的client_id
        'allow_client_ids' => [],
    ],*/
    'db_config2' => 'mysql://root:skycloud@192.168.8.249:3306/contec_ecg#utf8',
];
