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
\think\Route::get('hello','Index/index');
\think\Route::get('ceshi','Index/error');
\think\Route::get('infobase','gerendangan/Index/appPersonInfo');
\think\Route::get('personPast','gerendangan/Index/personPast');
\think\Route::get('healthCheck','tijian/Home/appJktjList');
\think\Route::get('checkupData','tijian/Home/appJktjData');
\think\Route::get('fllowList','tijian/Fllow/getFllowUpList');
\think\Route::get('fllowUp','tijian/Fllow/getFllowUp');
\think\Route::post('addcheckinfo','tijianche/Post/addInfo');

