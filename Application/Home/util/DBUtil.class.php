<?php
namespace Home\util;

/**
 * 
 * 通用的DML语句执行方法
 * @param unknow $sql将要执行的DML语句，可以带有问号
 * @param array $param 可选参数，当￥sql中有问号时，此参数必填;问好个数必须与此数组内元素个数相同且注意顺序；
 * @author j
 *@throws PDOException
 *@return true 表示执行成功
 */

class DBUtil{
    //保存pdo连接数据的dsn、用户名、密码的数组
    private $pdoMysql;
    //PDO对象
    private $pdo;
    
    public function __construct(){
        
        
//         $this->pdoMysql = XMLParse::parseDBXML();
//         $this->pdo = new \PDO($this->pdoMysql[0], $this->pdoMysql[1], $this->pdoMysql[2], array(\PDO::ATTR_ERRMODE=>\PDO::ERRMODE_EXCEPTION));
        $this->pdo = new \PDO(C("DB_TYPE").":host=".C("DB_HOST").";dbname=".C("DB_NAME"), C("DB_USER"), C("DB_PWD"),C("DB_PARAMS"));
        
    }
    
    
    
    public function executeDML($sql,array $params=null){
        $b=true;
        try{
            
            $ps =$this->pdo->prepare($sql);
            
            //参数数组不为空 并且元素个数大于0 需要绑定参数
            if($params !=null && count($params)>0){
                $ps->execute($params);
            }else {
                $ps->execute();
            }
            return true;
            
            
            
            
        }catch(\PDOException $e){
            $b = false;
            
        }
        $this->free($this->pdo,$ps);
        return $b;
        
    }
    
    
    /**
     *
     * 通用的查询语句执行方法
     * @param unknow $sql将要执行查询语句字符串，可以带有问号
     * @param array $param 可选参数，当$sql中有问号时，此参数必填;问好个数必须与此数组内元素个数相同且注意顺序；若$sql中无问好，此参数可不填，或者填一个null、array（）
     * @param unknow $fetchStyle 可选参数，提取数据的方式，默认为\PDO::FETCH_NUM，可选值有\PDO::FETCH_ASSOC 或\PDO::FETCH_OBJ
     * @param unknow $className 可选参数，当$fetchStyle的值为\PDO::FETCH_OBJ时，要求必须填入实体类的全名(空间命名\类名)，当$fetchStyle的值不为\PDO::FETCH_OBJ时，此参数可以不填
     * @author j
     *@throws PDOException
     *@return array 当查询有数据则返回数据组成的组数，党务数据时返回array()
     */
    
    public function executeQuery($sql,array $params=null,$fetchStyle=\PDO::FETCH_NUM,$className=null){
        try{
             $ps =$this->pdo->prepare($sql);
        
            //参数数组不为空 并且元素个数大于0 需要绑定参数
            if($params !=null && count($params)>0){
                $ps->execute($params);
            }else {
                $ps->execute();
            }
            
            if($fetchStyle == \PDO::FETCH_OBJ){
               $objs = array();
               while ($obj = $ps->fetchObject($className)){
                   array_push($objs, $obj);
               }
               return $objs; 
            }else{
               return $ps->fetchAll($fetchStyle);
            }
        
        
        
        
        }catch(\PDOException $e){
            throw $e;
        
        }
        //如果出现异常返回一个空数组
        return array();
        
    }


    /**
     *
     * 通用的查询语句执行方法并分页
     * @param string $sql 将要执行的查询语句字符串 可以带问好
     * @param int $pageNo 当前显示页数
     * @param int $pageSize 当前显示多少行数据
     * @param unknow $sql将要执行查询语句字符串，可以带有问号
     * @param array $param 可选参数，当$sql中有问号时，此参数必填;问好个数必须与此数组内元素个数相同且注意顺序；若$sql中无问好，此参数可不填，或者填一个null、array（）
     * @param unknow $fetchStyle 可选参数，提取数据的方式，默认为\PDO::FETCH_NUM，可选值有\PDO::FETCH_ASSOC 或\PDO::FETCH_OBJ
     * @param unknow $className 可选参数，当$fetchStyle的值为\PDO::FETCH_OBJ时，要求必须填入实体类的全名(空间命名\类名)，当$fetchStyle的值不为\PDO::FETCH_OBJ时，此参数可以不填
     * @author j
     *@throws PDOException
     *@return array 当查询有数据则返回数据组成的组数，党务数据时返回array()
     */
    public function executePageQuery($sql,$pageNo,$pageSize,array $params=null,$fetchStyle=\PDO::FETCH_NUM,$className=null){
        $page = array("total"=>0,"rows"=>array());
        try{
            //查询总共多少行数据
            $index1 = strpos($sql,"from");
            $index2 = strpos($sql,"limit");
            $sql2 = "select count(*) ".substr($sql,$index1,$index2-$index1);
            $ps = $this->pdo->prepare($sql2);
            $ps->execute();
          
            $page["total"] = $ps->fetch(\PDO::FETCH_NUM)[0];
        
            //查询当前页数
            $ps = $this->pdo->prepare($sql);
            //手动绑定limit后的两个问号
            $begin = ($pageNo-1)*$pageSize;
            //统计原sql中包含多少个问号 最少包含两个（limit后）
            $countWH = 0;
            str_replace("?", "?", $sql,$countWH);
            $ps->bindParam($countWH-1, $begin,\PDO::PARAM_INT);
            $ps->bindParam($countWH, $pageSize,\PDO::PARAM_INT);
            //参数数组不为空 并且元素个数大于0 需要绑定参数
            if($params !=null && count($params)>0){
                $ps->execute($params);
            }else {
                $ps->execute();
            }
      
            if($fetchStyle == \PDO::FETCH_OBJ){
                $objs = array();
                while ($obj = $ps->fetchObject($className)){
                    array_push($objs, $obj);
                }
                $page['rows'] =$objs;
            }else{
                $page['rows']= $ps->fetchAll($fetchStyle);
            }
        }catch(\PDOException $e){
            throw $e;
        }
//         如果出现异常返回一个空数组
        return $page;
        $this->free($this->pdo,$ps);
    }
     
    
    
    
    
    /**
     *
     * 通用的查询语句执行方法并分页-带子查询的
     * @param 将要执行的查询语句字符串，可以带问号
     * @param 查询数据行数的sql语句
     * @param
     * @param string $sql 将要执行的查询语句字符串 可以带问好
     * @param int $pageNo 当前显示页数
     * @param int $pageSize 当前显示多少行数据
     * @param unknow $sql将要执行查询语句字符串，可以带有问号
     * @param array $param 可选参数，当$sql中有问号时，此参数必填;问好个数必须与此数组内元素个数相同且注意顺序；若$sql中无问好，此参数可不填，或者填一个null、array（）
     * @param unknow $fetchStyle 可选参数，提取数据的方式，默认为\PDO::FETCH_NUM，可选值有\PDO::FETCH_ASSOC 或\PDO::FETCH_OBJ
     * @param unknow $className 可选参数，当$fetchStyle的值为\PDO::FETCH_OBJ时，要求必须填入实体类的全名(空间命名\类名)，当$fetchStyle的值不为\PDO::FETCH_OBJ时，此参数可以不填
     * @author j
     *@throws PDOException
     *@return array 当查询有数据则返回数据组成的组数，党务数据时返回array()
     */
    public function executePageSbQuery($dataSql,$countSql,$pageNo,$pageSize,array $params=null,$fetchStyle=\PDO::FETCH_NUM,$className=null){
        $page = array("total"=>0,"rows"=>array());
        try{
 
            //查询当前页数
            $ps = $this->pdo->prepare($dataSql);
            
            //手动绑定limit后的两个问号
            $begin = ($pageNo-1)*$pageSize;
            //统计原sql中包含多少个问号 最少包含两个（limit后）
            $countWH = 0;
            str_replace("?", "?", $dataSql,$countWH);
            if($countWH > 0){
                $ps->bindParam($countWH-1, $begin,\PDO::PARAM_INT);
                $ps->bindParam($countWH, $pageSize,\PDO::PARAM_INT);
            }
            $ps->execute();
    
            if($fetchStyle == \PDO::FETCH_OBJ){
                $objs = array();
                while ($obj = $ps->fetchObject($className)){
                    array_push($objs, $obj);
                }
                $page['rows'] =$objs;
            }else{
                $objs = array();
                while ($obj = $ps->fetch($fetchStyle)){
                    array_push($objs, $obj);
                }
                $page['rows'] = $objs;
//                 $page['rows'] = $ps->fetchAll($fetchStyle);
            }
            
            
            $ps = $this->pdo->prepare($countSql);
        //参数数组不为空 并且元素个数大于0 需要绑定参数
            if($params !=null && count($params)>0){
                $ps->execute($params);
            }else {
                $ps->execute();
            }
            
            $page["total"] = $ps->fetch(\PDO::FETCH_NUM)[0];
            
            
        }catch(\PDOException $e){
            throw $e;
        }
        //         如果出现异常返回一个空数组
        $this->free($this->pdo,$ps);
        return $page;
         
    }
    
    
    private function free($pdo,$ps){
        if ($pdo != null){
            $pdo = null;
        }
        if ($ps != null){
            $ps = null;
        }
    }
    
    
}


?>