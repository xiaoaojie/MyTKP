<?php
return array(
	//'配置项'=>'配置值'
	//修改默认的模版目录结构为  改成控制器类名称_操作方法名.html
//     'TMPL_FILE_DEPR'=>'_',
    //控制器级别
//     'CONTROLLER_LEVEL'=>2,
    //Action参数绑定
//     'URL_PARAMS_BIND' => true,
//  //开启路由   
//     'URL_ROUTER_ON'=>true,
//     'URL_ROUTE_RULES'=>array(
//         'ttt'=>"Home/Index/index",//静态规则路由
//         'tttt/:name/:uid'=>"Home/Index/index",//静态的规则路由和动态的地址结合
//         'login'=>"Home/User/login",
//         '/^bbb\/(\d{4})\/(\d{2})$/'=>"Home/Index/test?year=:1&month=:2"
        
//     )
//     //静态
//     'URL_MAP_RULES'=>array(
//         'ttt'=>"Home/Index/index",//静态规则路由
        
//         'login'=>"Home/User/login"
        
//     )
    //'配置项'=>'配置值'
    //数据库PDO配置
    // 	'DSN'=>'mysql:host=localhost;dbname=sys',
    //     'DBUSER'=>'root',
    //     'DBPASS'=>'15822827069',
    //     'DBPORT'=>3306,
    //     'PDOOPTIONS'=>array(\PDO::ATTR_ERRMODE=>\PDO::ERRMODE_EXCEPTION),
    
            'DB_TYPE' => 'mysql',
            'DB_HOST' =>'localhost',
            'DB_USER' => 'root',
            'DB_PWD' => '15822827069',
            'DB_PORT' => '3306',
            'DB_NAME' => 'sys',
            'DB_CHARSET' => 'utf8',
            'DB_PARAMS' =>array(\PDO::ATTR_ERRMODE=>\PDO::ERRMODE_EXCEPTION)
//     'DB_DSN'=>'mysql://root:15822827069@localhost:3306/sys#utf8',
//     'connect' => array(
//         'DB_TYPE' => 'mysql',
//         'DB_HOST' =>'localhost',
//         'DB_USER' => 'root',
//         'DB_PWD' => '15822827069',
//         'DB_PORT' => '3306',
//         'DB_NAME' => 'sys',
//         'DB_CHARSET' => 'utf8'
//     )
    
);