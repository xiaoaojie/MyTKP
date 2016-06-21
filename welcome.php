<?php 
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link type="text/css" rel="stylesheet" href="Public/easyui/themes/default/easyui.css">
        <link type="text/css" rel="stylesheet" href="Public/easyui/themes/icon.css">
        
        <script type="text/javascript" src="Public/easyui/jquery.min.js"></script>
        <script type="text/javascript" src="Public/easyui/jquery.easyui.min.js"></script>
        <script type="text/javascript" src="Public/easyui/locale/easyui-lang-zh_CN.js"></script>
        <title></title>
        <script type="text/javascript">
		
		function addTabs(url,name){
			if($('#tabs').tabs("exists",name)){
				//如果当前面板已存在，则直接选中它
				$('#tabs').tabs("select",name);
			}else{
				//添加一个选中状态的选项卡面板
				$('#tabs').tabs('add',{
					title: name,
					selected: true,
					closable:true,
					content:"<iframe name='"+name+"' src='"+url+"' width=100% height=100% frameborder='0' scrolling='no'></iframe>"
				});
			}				
		}
        </script>
    </head>

    <body class="easyui-layout">   
        <div data-options="region:'north',split:true" style="height:100px;background-color:#fdfffc;">
        	<div id="top_left">
        		<img alt="" src="img/logol.png" height=95px>
        	</div> 
        	<div id="top_right">
        		<?php 
                    if(array_key_exists("loginUser", $_SESSION)){
                        echo $_SESSION["loginUser"][4];
                    }    
    	        ?> 
    			 欢迎您！<a href="index.php">取消登录</a>
            	 
        	</div>
        
        
        </div>   
        
         
        <div data-options="region:'west',title:'菜单',split:true" style="width:100px;">
    		<ul id="tree" class="easyui-tree">  
			<?php 
			if(array_key_exists("secondMenu", $_SESSION)){
			    $secondMenu=$_SESSION["secondMenu"];
                foreach($secondMenu as $menu2){
                	echo "<li><span>{$menu2[1]}</span><ul>";
                	foreach ($menu2[5] as $menu3){
                	    echo "<li><span><a href=\"javascript:addTabs('{$menu3[2]}','{$menu3[1]}')\">{$menu3[1]}</a></span></li>";
                	}
                	echo "</ul></li>";
                }
			}
//             ?>
			</ul>  

    		
        </div>   
        <div data-options="region:'center'," style="padding:5px;background:#eee;">
			<div id="tabs" class="easyui-tabs"  data-options="fit:true">   
                <div title="欢迎" style="padding:20px;" data-options="closable:true" style="overflow:auto;padding:20px;display:none;">   
                   	 欢迎你！    
                </div>   
      
			</div>  

        </div> 
        
        
        
    </body>  

    	

</html>
