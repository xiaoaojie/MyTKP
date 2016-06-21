<?php
namespace Home\Controller;
use Think\Controller;
use Home\Model\UserModel;
use Home\Model\MenuModel;
use Think\Model;




class UserController  extends Controller
{
    private $MenuModel;
    private $userModel;
    private $userModel1;
    public function __construct(){
        parent::__construct();
        $this->userModel= new UserModel();
        $this->MenuModel=new MenuModel();
        $this->userModel1= new Model("t_user");
    }
    
    public function loadUserByPage($pageNo=1, $pageSize=10){
        $page = $this->userModel->loadUserByPage($pageNo, $pageSize);
        $this->ajaxReturn($page);
        
    }
    public function login(){
        
        
        $userName = $_POST["userName"];
        $userPass = $_POST["userPass"];
        $i=$this->userModel->login($userName, $userPass);
        if($i==1){
            $user = $this->userModel->loginUserByName($userName);
            $_SESSION["loginUser"]=$user;
            $uid= $_SESSION["loginUser"][0];
          
            $secondMenu =$this-> MenuModel->loadTreeMenu($uid);
            $_SESSION["secondMenu"]=$secondMenu;
            header("location:http://localhost:8080/MyTKP/welcome.php");
        }elseif ($i==2){
            
            
            header("location:http://localhost:8080/MyTKP/login.php");
        }else {
            header("location:http://localhost:8080/MyTKP/login.php");
        }
    }
    /**
     * 查询班主任 回填班主任下拉菜单
     */
   public function loadAllHeader(){
       $options = array(array("uid"=>-1,"truename"=>"请指定合并后的班主任"));;
       $data=$this->userModel1->field("uid,trueName")->where("userType=2")->select();
       foreach ($data as $d){
           array_push($options, $d);
       }
       $this->ajaxReturn($options);
   }
  public function loadAllManager(){
      $options = array(array("uid"=>-1,"truename"=>"请指定合并后的项目经理"));;
      $data=$this->userModel1->field("uid,trueName")->where("userType=3")->select();
      foreach ($data as $d){
          array_push($options, $d);
      }
      $this->ajaxReturn($options);
  }  
    
}

?>