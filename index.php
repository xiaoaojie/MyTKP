<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用入口文件

// 检测PHP环境
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');
//定义常量ROOT表示项目根目录的绝对路径
define("ROOT", str_replace("\\","/", dirname(__FILE__)."/"));
// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
define('APP_DEBUG',True);
header("Content-Type:text/html;charset=UTF-8");
// define("connect","mysql://root:15822827069@localhost:3306/sys#utf8");
// 定义应用目录
define('APP_PATH',ROOT.'./Application/');
// define("CONF_EXT",".ini");配置文件
// define("APP_STATUS", "");
// 引入ThinkPHP入口文件
require ROOT.'./ThinkPHP/ThinkPHP.php';

// 亲^_^ 后面不需要任何代码了 就是如此简单