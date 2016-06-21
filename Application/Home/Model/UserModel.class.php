<?php
namespace Home\Model;

use Home\util\DBUtil;
class UserModel
{
    private $dbUtil;
    /**
     * 所有的二级菜单，每个菜单里的都包含自己的子菜单
     *
     *
     */
    
    
    
    public function __construct(){
        $this->dbUtil = new DBUtil();
    }
    
    public function login($userName,$userPass){
        $sql = "select * from t_user where userName=?";
        $datas = $this ->dbUtil->executeQuery($sql,array($userName));
        if(count($datas)>0){
            //用户名正确
            if(count($datas)==1){
                //密码正确
                return 1;
            }else{
                //密码错误
                return 3;
            }
        }else{
            return 2;
        }
    }
    
    
    
    /**
     * 通过
     * @param unknown $userName
     * @return mixed|NULL
     */
    public function loginUserByName($userName){
        $sql = "select * from t_user where userName=?";
//         ,\PDO::FETCH_OBJ,'Home\entiey\User'
        $datas = $this ->dbUtil->executeQuery($sql,array($userName));
        if(count($datas)==1){
    
            if(count($datas)==1){
    
                return $datas[0];
            }else{
    
                return null;
            }
             
        }
    }
    
    public function loadUserByPage($pageNo,$pageSize){
        $begin = ($pageNo-1)*$pageSize;
        $sql="select t.*,r.name userType,s.name status,e.name education,p.name pid,c.name cid  from t_user t,role r,status s,education e,province p,city c where t.userType=r.rid and t.status=s.staid and t.education=e.eduid and t.pid=p.pid and t.cid=c.cid limit $begin,$pageSize";
        $sql1 = "select count(*)from t_user";
        $page = $this->dbUtil->executePageSbQuery($sql, $sql1, $pageNo, $pageSize,NULL,\PDO::FETCH_ASSOC);
    
        return  $page;
    }  
    
    
    
    
    
    
    
}

?>