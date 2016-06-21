<?php
/**
 * XML解析的工具类
 * @author j
 * @return 数据库dsn 用户名 密码组成的数组
 */
namespace Home\util;
class XMLParse{
    
    public static function parseDBXML(){
        //得到根节点
        $sx = simplexml_load_file(dirname(__DIR__)."/config/db.xml");
        //获取某个节点下所有子节点 返回数组
        $children = $sx->children();
        $pdoMysql = array((string)$children[0]->dsn,(string)$children[0]->userName,(string)$children[0]->passWord);
        return $pdoMysql ;
    }
}
/*
 * 基于事件的Expat 解析器
 *
 */
// $parser = xml_parser_create();
// // xml_set_element_handler($parser, "tagBegin", "tagEnd");
// // xml_set_character_data_handler($parser,"tagText");
// $str = file_get_contents("db.xml");


// function tagBegin($parse,$element_name,$elemenr_attrs){

// }
// function tagEnd($parse,$element_name){

// }
// function tagText($parse,$data){

// }





/**
 * 基于DOM解析XML
 *
 */
// //初始化解析器
// $document = new DOMDocument();
// //加载xml文件
// $document->load("db.xml");
// //通过元素名获取元素数组
// $dsn = $document->getElementsByTagName("dsn");
// $userName = $document->getElementsByTagName("userName");
// $passWord = $document->getElementsByTagName("passWord");
// // echo $dsn ->item(0)->nodeValue;//获取元素的文本内容；

// $pdoMysql = array($dsn ->item(0)->nodeValue,$userName ->item(0)->nodeValue,$passWord ->item(0)->nodeValue);

// print_r($podMysql) ;

/**
 * SimpleXML解析
 */
// //得到根节点
// $sx = simplexml_load_file(dirname(__FILE__)."/db.xml");
// //获取某个节点下所有子节点 返回数组
// $children = $sx->children();
// $pdoMysql = array((string)$children[0]->dsn,(string)$children[0]->userName,(string)$children[0]->passWord);



// var obj =eval("("+txt+")");

?>
