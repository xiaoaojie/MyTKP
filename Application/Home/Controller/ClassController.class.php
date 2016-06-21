<?php
namespace Home\Controller;

use Think\Controller;
use Think\Model;

class ClassController extends Controller
{
    private $classModel;
//     private static $connect=array(
//         'DB_TYPE' => 'mysql',
//         'DB_HOST' =>'localhost',
//         'DB_USER' => 'root',
//         'DB_PWD' => '15822827069',
//         'DB_PORT' => '3306',
//         'DB_NAME' => 'sys',
//         'DB_CHARSET' => 'utf8');
//     const DB_SDN="mysql://root:15822827069@localhost:3306/sys#utf8";
    public function __construct(){
        parent::__construct();
//         $dsn="mysql://root:15822827069@localhost:3306/sys#utf8";
//         $this->classModel=new Model("class");
            $this->classModel=new Model("class");
           
    }
  
  public function classManage(){
      $this->display();
  }
  public function loadClassByPage($pageNo=1,$pageSize=10,$className=null,$createtime1=null,$createtime2=null,$begintime1=null,$begintime2=null,$endtime1=null,$endtime2=null,$headerName=null,$managerName=null,$status=-1){
      $sql = " from class c,t_user u1,t_user u2 where c.headerid=u1.uid and c.manageid=u2.uid";                                                                                     
      if(null !=$className){
         $sql .= " and c.name like '%$className%'";
      }
      
      if(null !=$createtime1){
          $sql .= " and c.createTime >= '".$createtime1."'";
      }
      if(null !=$createtime2){
          $sql .= " and c.createTime <= '".$createtime2."'";
      }
      
      if(null !=$headerName){
          $sql .= " and u1.trueName like '%$headerName%'";
      }
      
      if(null !=$begintime1){
          $sql .= " and c.beginTime >= '".$begintime1."'";
      }
      if(null !=$begintime1){
          $sql .= " and c.beginTime <= '".$begintime2."'";
      }
      
      if(null !=$managerName){
          $sql .= " and u2.trueName like '%$managerName%'";
      }
      
      if(null !=$endtime1){
          $sql .= " and c.endTime >= '".$endtime1."'";
      }
      if(null !=$endtime2){
          $sql .= " and c.endTime <= '".$endtime2."'";
      }
      if($status>0){
          $sql .= " and c.status = $status";
      }
      
      
      $count = $this->classModel->query("select count(*) as cc".$sql)[0]["cc"];
      $page["total"] = $count;
      $begin = ($pageNo-1)*$pageSize;
      $rows = $this->classModel->query("select c.cid,c.name,c.classtype,c.createtime,c.begintime,c.endtime,u1.truename headername,u2.truename managename,c.stucount,c.status,c.remark".$sql." order by cid limit $begin,$pageSize");
      $page["rows"]=$rows;
      $this->ajaxReturn($page);
  }  
  
  public function loadClassById($cid){
      $sql = "select * from class where cid=?";
      $data = $this->classModel->query($sql)[0];
       
      
      $this->ajaxReturn($data);
      
  }
  /**
   * 检查所选班级今天是否有考试
   * @param unknown $cids 参数绑定格式为1,2,3
   */
  public function checkExamToday($cids=null){
//       print_r($cids);
      $d = date("Y-m-d");
      $db = $d." 00:00:00";
      $de = $d." 23:59:59";
      $data = $this->classModel->table("exam")->where("classid in($cids)and beginTime between '$db' and '$de'")->select();
//       $sql = "select * from exam where classid in($cids) and beginTime between $db and $de";
      if(count($data)>0){
          //获取到今天有考试的班级id，用于提示哪些班级有考试
          $classids = array();
          foreach ($data as $exam){
              array_push($classids,$exam["classid"]);
          }
          $str = implode(",", $classids);
          //查询今天有考试的班级名称
          $cname = $this->classModel->field("name")->where("cid in($str)")->select();
          $names = array();
          foreach ($cname as $n){
              array_push($names,$n["name"]);
              $this->ajaxReturn("对不起，".implode(",", $names)."今天有考试，不能合并","EVAL");
          }
      }else{
          $this->ajaxReturn("ok","EVAL");
      }
  }
  public function hebingeClass($cids=null,$combinedClassid=-1,$combinedHeaderid=-1,$combinedManageid=-1){
      try{
          $this->classModel->setProperty(\PDO::ATTR_AUTOCOMMIT, false);
          $this->classModel->startTrans();//开启事物
          
          
          $classes = $this->classModel->table("class")->where("cid in($cids)")->select();
          $totalCount = 0;
//           $str = array();
          foreach ($classes as $c){
              if($c["cid"]==$combinedClassid){
                  //要保留的班级
                  
              }else{
                  //不保留的班级
                  $totalCount += $c["stucount"];
                  $c["stucount"] = 0;//被合并后人数清0
                  $c["status"] = 2; //被合并
                  $this->classModel->save($c);
                  $sql = "update t_user set classid=%d where classid=%d";
                  $this->classModel->execute($sql,$combinedClassid,$c["cid"]);
//                     array_push($str, $c["cid"]);
                  
              }
          }
          $combinedClass=$this->classModel->table("class")->where("cid=%d",$combinedClassid)->find();
          $combinedClass["headerid"] = $combinedHeaderid;
          $combinedClass["manageid"] = $combinedManageid;
          $combinedClass["stucount"] += $totalCount;
          $this->classModel->save($combinedClass);
          
          
//           $str = implode(",", $str);
//           $sql = "update t_user set classid=%d where classid in($str)";
          
          
          
          
          $this->classModel->commit();//提交事务
      }catch(\Exception $e){
          $this->classModel->rollback();//事务回滚到上一次提交后的数据状态
      }
      $this->loadClassByPage();
  }
}

?>