<?php
namespace Home\Controller;

use Think\Controller;
use Home\Model\MenuModel;
class MenuController extends Controller
{
    private $menuModel;
    public function __construct(){
        parent::__construct();
        $this->menuModel=new MenuModel();
    }
    
    public function menuManage(){
        $this->display();
    }
    
    
    
    public function loadMenuByPage($pageNo=1,$pageSize=10){
        $page=$this->menuModel->loadMenuByPage($pageNo, $pageSize);
        $this->ajaxReturn($page);
    }
    public function load12Menu(){
        $load12Menu=$this->menuModel->load12Menu();
        $this->ajaxReturn($load12Menu);
        
    }
    public function deleteMenu($menuids){
        $deleteMenu=$this->menuModel->deleteMenu($menuids);
        $this->ajaxReturn("ok","eval");
        
    }
    public function saveOrupdataMenu($menuid,$name,$url,$parentid,$isshow ){
        if ($menuid == ""){
            $result = $this->menuModel->saveMenu($name, $url, $parentid, $isshow);
            $this->ajaxReturn("insertok","eval");
        }else {
            $result = $this->menuModel->UpdateMenu($name, $url, $parentid, $isshow, $menuid);
            $this->ajaxReturn("insertok","eval");
        }
    }
    public function loadMenuById($menuid){
        $menu = $this->menuModel->loadMenuById($menuid);
        $this->ajaxReturn($menu);
    }
    
}

?>