<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
        <link type="text/css" rel="stylesheet" href="http://localhost:8080/MyTKP/Public/easyui/themes/default/easyui.css">
        <link type="text/css" rel="stylesheet" href="http://localhost:8080/MyTKP/Public/easyui/themes/icon.css">
         <link type="text/css" rel="stylesheet"  href="http://localhost:8080/MyTKP/Public/css/easyui.css">
        <script type="text/javascript" src="http://localhost:8080/MyTKP/Public/easyui/jquery.min.js"></script>
        <script type="text/javascript" src="http://localhost:8080/MyTKP/Public/easyui/jquery.easyui.min.js"></script>
        <script type="text/javascript" src="http://localhost:8080/MyTKP/Public/easyui/locale/easyui-lang-zh_CN.js"></script>
	<title></title>
	<style type="text/css">
       
    </style>
    <script type="text/javascript">
    $(function(){
    	$('#win').window('close'); 
        $('#dg').datagrid({    
            url:'http://localhost:8080/MyTKP/index.php/Home/Menu/loadMenuByPage?pageNo=1&pageSize=10',   
            striped:true,
            method:"get",
		    fitColumns:true, 
		    pagination:true, 
		    rownumbers:true,
		    frozenColumns:[[
                {field:'check',checkbox:true}
		    ]], 
            columns:[[    
                {field:'menuid',title:'主键id',width:100,align:'center'},    
                {field:'name',title:'菜单名称',width:100,align:'center'},    
                {field:'url',title:'菜单地址',width:100,align:'center'},
                {field:'parentName',title:'父级菜单id',width:100,align:'center'},  
                {field:'isshow',title:'是否显示',width:100,align:'center',formatter:function(value){
					if(value==1){
						return "显示";
					}else{
						return "不显示";
					}
		        }}  
     
            ]], 
        	toolbar:[{
                iconCls: 'icon-adduser',
                text:'添加',
                handler: function(){
                    //每次打开窗口前加载1 2级
                	$('#parentid').combobox({    
                	    url:'http://localhost:8080/MyTKP/index.php/Home/Menu/load12Menu?',    
                	    valueField:'menuid',    
                	    textField:'name'   
                	});  
					$('#win').window('open');
                }
             },'-',{
            	 iconCls: 'icon-delete',
  				text:'删除',
  				handler: function(){
      				var selectedRows = $("#dg").datagrid("getSelections");
      				if(selectedRows.length == 0){
 							alert("请选择需要删除行");
 							return;
      				}
      				if(window.confirm("你确定要删除选中的数据")){
          				var menuids = new Array();
 							for(var i=0;i<selectedRows.length;i++){
 								menuids.push(selectedRows[i].menuid);
 							}
 							$.post('http://localhost:8080/MyTKP/index.php/Home/Menu/deleteMenu?',{"menuids":menuids.join(",")},function(data){
 								refreshData(1,10);
 							},"text");
      				}
  				}
  			},'-',{
  				iconCls: 'icon-refresh',
  				text:'刷新',
  				handler: function(){
  					refreshData(1,10);
  				}
  			},'-',{
  				iconCls: 'icon-modify',
  				text:'修改',
  				handler: function(){
  					var selectedRow = $("#dg").datagrid("getSelections");
  					if(selectedRow.length == 0){
 							alert("请选择需要修改的数据哦");
 							return;
  					}
  					if(selectedRow.length > 1){
 							alert("对不起,只能选择一行数据哦");
 							return;
  					}
					//数据回填
  					$('#parentid').combobox({    
  					    url:'http://localhost:8080/MyTKP/index.php/Home/Menu/load12Menu?',    
  					    valueField:'menuid',    
  					    textField:'name'   
  					});
  					var row = selectedRow[0];
  					$.post("http://localhost:8080/MyTKP/index.php/Home/Menu/loadMenuById?menuid="+row.menuid,{},function(data){
  						$("#menuid").val(data.menuid);
 							$("#name").val(data.name);
 							$("#url").val(data.url);
 							$("#parentid").combobox("setValue",data.parentid);
 							$("#isshow").combobox("setValue",data.isshow);
  					});
  					$("#win").window('open');
  				}
  			}]
  		    		        
  		}); 
  		
 			//翻页功能/翻页工具
 			var pager  = $("#dg").datagrid('getPager');
 			
 			pager.pagination({
 				onSelectPage:function(pageNumber, pageSize){
 					refreshData(pageNumber,pageSize);
 				}
 			});
 		});

	
	//修改文件
	function saveOrUpdateMenu(){
		var menuid = $("#menuid").val();
		var name = $("#name").val();
		var url = $("#url").val();
		var parentid = $("#parentid").combo('getValue');
		var isshow = $("#isshow").combo('getValue');

		$.post("http://localhost:8080/MyTKP/index.php/Home/Menu/saveOrupdataMenu",{
			"menuid"	: menuid,
			"name"		: name,
			"url"		: url,
			"parentid"	: parentid,
			"isshow"	: isshow
		},function(data){
			if(data == "insertOK"){
				$.message.alert('消息','菜单添加成功','insertOk',function(){
				refreshData(1,10);
				$('#win').window('close');
				$('#ff').form('reset');
				});
				
			}else if(data == "updateOK"){
	 		$.message.alert('消息','菜单修改成功','updateOK',function(){
	 			refreshData(1,10);
		 		$('#win').window('close');
		 		$('#ff').form('reset');
		 		});
	 		


	 		}
		},"text");
		
	}


	function refreshData(pageNumber,pageSize){
		$("#dg").datagrid('loading');
//			alert('pageNumber:'+pageNumber+',pageSize:'+pageSize);
		$.getJSON("http://localhost:8080/MyTKP/index.php/Home/Menu/loadMenuByPage?pageNo="+pageNumber+"&pageSize="+pageSize,{},function(data){
			$("#dg").datagrid('loadData',{
				rows:data.rows,
				total:data.total
			});
			var pager  = $("#dg").datagrid('getPager');
			
			pager.pagination({
				pageSize:pageSize,
				pageNumber:pageNumber
			});
			$("#dg").datagrid('loaded');
		});
	}


    
    </script>

</head>

    <body >
    	<table id="dg"></table>
    	<div id="win" class="easyui-window" title="添加菜单" style="width:600px;height:400px"   
        data-options="iconCls:'icon-adduser',modal:true,collapsible:false,minimizable:false,maximizable:false,resizable:false">   
   		 <form id="ff" method="post">
   		 <input type="hidden" id="menuid"/> 
   		 	<table style="width: 60%;margin: auto;margin-top:20px;">
   		 		<tr>
   		 			<td align="right"><label for="name">菜单名称:</label> </td>
   		 			<td><input class="easyui-validatebox in" type="text" id="name" name="name" data-options="required:true" />   </td>
   		 		</tr>
   		 		<tr >
   		 			<td  align="right"><label for="url">菜单URL:</label>  </td>
   		 			<td><input class="easyui-validatebox in" type="text"  id="url"  name="url" data-options="" />     </td>
   		 		</tr>
   		 		<tr>
   		 			<td align="right"><label for="parentid">父级菜单:</label></td>
   		 			<td>
   		 				<select id="parentid" class="in" name="parentid" style="width:150px "></select>
   		 			
   		 			</td>
   		 		
   		 		</tr>
   		 		<tr>
   		 			<td align="right"><label for="isshow">是否展示:</label></td>
   		 			<td>
   		 				<select id="isshow" class="easyui-combobox in" name="isshow" style="width:150px ">
   		 					<option value="1">展示</option>
   		 					<option value="0">不展示</option>
   		 				</select>
   		 			
   		 			</td>
   		 		
   		 		</tr>
   		 		<tr>
   		 			<td align="center" colspan="2">
   		 				<a id="btn" href="javascript:saveOrUpdateMenu();" class="easyui-linkbutton" data-options="iconCls:'icon-submit'">确认</a>
<!--    		 				<a id="btn1" href="javascript:saveOrUpdateMenu();" class="easyui-linkbutton" data-options="iconCls:'icon-submit'">修改</a>    -->
   		 				
   		 			</td>
   		 			
   		 		
   		 		</tr>
   		 	</table>
        
		</form>  

   		   
		</div>  

    	
    
    </body>

 

</html>