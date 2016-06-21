<?php
namespace Home\entity;
class Menu
{
//    isshow 1 表示是否在首页左边的树形菜单中展示1表示要展示
//    parentid 表示此菜单父级菜单的主键id，如果此菜单已经是最顶级菜单，则此列值为-1
//    url表示菜单被点击后要发送的超链接地址  如果此菜单不是最低级则此列为null
   public   $menuid ;
   public  $name;
   public  $url;
   public  $parentid;
   public  $isshow;
   
   //如果此菜单是二级菜单，则他的所有子菜单放在$children，如果此菜单是最低级菜单，$children则为空。
   private $children;
   
/**
     * @return $children
     */
    public function getChildren()
    {
        return $this->children;
    }

/**
     * @param !CodeTemplates.settercomment.paramtagcontent!
     */
    public function setChildren(array $children)
    {
        $this->children = $children;
    }

    /**
     * @return $menuid
     */
    public function getMenuid()
    {
        return $this->menuid;
    }

/**
     * @return $name
     */
    public function getName()
    {
        return $this->name;
    }

/**
     * @return $url
     */
    public function getUrl()
    {
        return $this->url;
    }

/**
     * @return $parentid
     */
    public function getParentid()
    {
        return $this->parentid;
    }

/**
     * @return $isshow
     */
    public function getIsshow()
    {
        return $this->isshow;
    }

/**
     * @param !CodeTemplates.settercomment.paramtagcontent!
     */
    public function setMenuid($menuid)
    {
        $this->menuid = $menuid;
    }

/**
     * @param !CodeTemplates.settercomment.paramtagcontent!
     */
    public function setName($name)
    {
        $this->name = $name;
    }

/**
     * @param !CodeTemplates.settercomment.paramtagcontent!
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

/**
     * @param !CodeTemplates.settercomment.paramtagcontent!
     */
    public function setParentid($parentid)
    {
        $this->parentid = $parentid;
    }

/**
     * @param !CodeTemplates.settercomment.paramtagcontent!
     */
    public function setIsshow($isshow)
    {
        $this->isshow = $isshow;
    }

}

?>

