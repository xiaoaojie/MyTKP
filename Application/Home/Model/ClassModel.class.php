<?php
namespace Home\Model;

use Home\util\DBUtil;
class ClassModel
{
    private $dbUtil;
    public function __construct(){
        $this->dbUtil=new DBUtil();
    }
    
    
    public function loadClassById($cid){
        $sql = "select * from class where cid=?";
        $data = $this->dbUtil->executeQuery($sql,array($cid),\PDO::FETCH_OBJ,'entity\classes');
        return $data[0];
    }
}

?>