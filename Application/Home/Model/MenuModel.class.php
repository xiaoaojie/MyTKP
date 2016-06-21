<?php
namespace Home\Model;
use Home\util\DBUtil;
class MenuModel
{
    private $dbUtil;
    public function __construct(){
        $this->dbUtil = new DBUtil();
    }
    
    public function loadTreeMenu($uid){
     
        $menu2=array();
        $m2s=array();
        $sql = "select m.* from userrole ur,rolemenu rm,menu m where ur.rid=rm.rid and rm.menuid=m.menuid and ur.uid=? and m.parentid=?";
        
        
        //查询一级菜单 只有一个
        $menus = $this->dbUtil->executeQuery($sql,array($uid,-1));
        if(count($menus)>0){
            $menu1 = $menus[0];
            //查询二级菜单 通过一级菜单主键ID去查询
            $menu2=$this->dbUtil->executeQuery($sql,array($uid,$menu1[0]));
            foreach ($menu2 as $second){
                $m2=array();
                array_push($m2, $second[0],$second[1],$second[2],$second[3],$second[4]);
                $menu3=$this->dbUtil->executeQuery($sql,array($uid,$second[0]));
//                 $second->setChildren($menu3);
                array_push($m2,$menu3);
                array_push($m2s, $m2);
            }
        }
        return $m2s;
    }

    /**
     * 分页查询菜单列表
     * @param unknown $sql
     * @param unknown $pageNo
     */
    public function loadMenuByPage($pageNo,$pageSize){
        $begin = ($pageNo -1) *$pageSize;
        $sql = "select m.menuid,m.name,m.url,m2.name as parentName,m2.isshow from menu m,menu m2 where m.parentid=m2.menuid limit $begin,$pageSize";
        $sql2 = "select count(*) from menu";
        $page = $this->dbUtil->executePageSbQuery($sql,$sql2,$pageNo, $pageSize,NULL,\PDO::FETCH_ASSOC);
        return  $page;
    }
    
    public function load12Menu(){
        $sql = "select * from menu where parentid=?";
        $fsmenu = array();
        $menus = $this->dbUtil->executeQuery($sql,array(-1),\PDO::FETCH_OBJ,'Home\entity\Menu');
        $menu1 = $menus[0];
       
         $menu1->setName("一级->".$menu1->getName());
        
        array_push($fsmenu, $menu1);
     
//        
        $menu2 = $this->dbUtil->executeQuery($sql,array($menu1->getMenuid()),\PDO::FETCH_OBJ,'Home\entity\Menu');
        foreach ($menu2 as $second){
            $second->setName("二级->".$second->getName());
            array_push($fsmenu, $second);
        }
        
        return $fsmenu;
        
            
            
    }
    
    
    
    
    
    public function addMenu($name,$url,$parentid,$isshow){
        $sql="insert into menu(name,url,parentid,isshow) values(?,?,?,?)";
        
        if ($this->dbUtil->executeDML($sql,array($name,$url,$parentid,$isshow))){
            return "insertOK";
        }else {
            return "NO";
        }
    }
   public function deleteMenu($menuids){
       $sql = "delete from menu where menuid in ($menuids)";
       $this->dbUtil->executeDML($sql);
       
       
   } 
    public function saveMenu($name,$url,$parentid,$isshow){
        $sql = "insert into menu(name,url,parentid,isshow) values(?,?,?,?)";
        if ($this->dbUtil->executeDML($sql,array($name,$url,$parentid,$isshow))){
            return "insertOK";
        }else {
            return "NO";
        }
    }
        
    public function updateMenu($name,$url,$parentid,$isshow,$menuid){
        $sql = "update menu set name=?,url=?,parentid=?,isshow=? where menuid=?";
        if ($this->dbUtil->executeDML($sql,array($name,$url,$parentid,$isshow,$menuid))){
            return "updateOK";
        }else {
            return "NO";
        }
    }  
   public function loadMenuById($menuid){
       $sql = "select * from menu where menuid=?";
       $data = $this->dbUtil->executeQuery($sql,array($menuid),\PDO::FETCH_OBJ,'Home\entity\Menu');
       return $data[0];
   }
}

?>