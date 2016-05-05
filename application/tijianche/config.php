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

    'database' => [
        // 数据库类型
        'type'        => 'mysql',
        // 数据库连接DSN配置
        'dsn'         => '',
        // 服务器地址
        'hostname'    => '192.168.8.249',
        // 数据库名
        'database'    => 'cendata',
        // 数据库用户名
        'username'    => 'root',
        // 数据库密码
        'password'    => 'skycloud',
        // 数据库连接端口
        'hostport'    => '3306',
        // 数据库连接参数
        'params'      => [],
        // 数据库编码默认采用utf8
        'charset'     => 'utf8',
        // 数据库表前缀
        'prefix'      => '',
        // 数据库调试模式
        'debug'       => false,
        // 数据库部署方式:0 集中式(单一服务器),1 分布式(主从服务器)
        'deploy'      => 0,
        // 数据库读写是否分离 主从式有效
        'rw_separate' => false,
        // 读写分离后 主服务器数量
        'master_num'  => 1,
        // 指定从服务器序号
        'slave_no'    => '',
    ],
];
