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
            url:'http://localhost:8080/MyTKP/index.php/Home/Class/loadClassByPage?pageNo=1&pageSize=10',   
            striped:true,
            method:"get",
		    fitColumns:true, 
		    pagination:true, 
		    rownumbers:true,
		    frozenColumns:[[
                {field:'check',checkbox:true}
		    ]], 
            columns:[[    
                {field:'cid',hidden:true},    
                {field:'name',title:'名称',width:100,align:'center'},    
                {field:'classtype',title:'类型',width:100,align:'center'},
                {field:'createtime',title:'创建时间',width:100,align:'center'},
                {field:'begintime',title:'开班时间',width:100,align:'center'},
                {field:'endtime',title:'结业时间',width:100,align:'center'},
                {field:'headername',title:'班主任',width:100,align:'center'},
                {field:'managename',title:'项目经理',width:100,align:'center'},
                {field:'stucount',title:'人数',width:100,align:'center'},
                {field:'status',title:'状态',width:100,align:'center'},  
                {field:'remark',title:'备注',width:100,align:'center'}  
     
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
  					//加载下拉列表选项数据 
  					loadComboboxData();
                	
  					$("#tr_status").show();
					$('#win').window('open');
  					var row = selectedRow[0];
					//数据回填
  					$.getJSON("http://localhost:8080/MyTKP/index.php/Home/Class/loadClassById?uid="+row.uid,{},function(data){
  						$("#cid").val(data.cid);
  						$("#classType").combobox('select',data.classType);
  						$("#beginTime").val(data.beginTime);
  						$("#endTime").val(data.endTime);
  						$("#headerid").combobox('select',data.headerid);
  						$("#manageid").combobox('select',data.manageid);
  						$("#stucount").val(data.stucount);
  						$("#status").combobox('select',data.status);
  						$("#remark").val(data.remark);
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
	function saveOrUpdateUser(){
		var r = $("#ff").form("validate");
		if(r){
			var cid = $("#cid").val();
			var classType = $("#classType").combo('getValue');
			var beginTime = $("#beginTime").val();
			var endTime = $("#endTime").val();
			var headerid = $("#headerid").combo('getValue');
			var manageid = $("#manageid").combo('getValue');
			var stucount = $("#stucount").val();
			var status = $("#status").combo('getValue');
			var remark = $("#remark").val();
			$.post("http://localhost:8080/MyTKP/index.php/Home/Class/saveOrUpdataClass",{
				"cid":cid,
				"classType" : classType,
				"beginTime": beginTime ,
				"endTime"     : endTime ,
				"headerid":headerid ,
				"manageid"	:manageid,
				"stucount" :stucount,
				"status"  : status,
				"remark":remark,
			},function(data){
				if(data == "insertOK"){
					$.messager.alert('消息','用户添加成功','info',function(){
					refreshData(1,10);
					$('#win').window('close');
					$('#ff').form('reset');
					});
					
				}else if(data == "updateOK"){
		 			$.messager.alert('消息','用户修改成功','info',function(){
		 			refreshData(1,10);
			 		$('#win').window('close');
			 		$('#ff').form('reset');
			 		});
		 		}
			},"text");
		}
	}


	
	//搜索班级
	function searchClass(){
		$.post("http://localhost:8080/MyTKP/index.php/Home/Class/loadClassByPage",{
			'pageNo':1,
			'pageSize':10,
			'className':$("#search_className").val(),
			'createtime1':$("#search_createtime1").combo("getValue"),
			'createtime2':$("#search_createtime2").combo("getValue"),
			'begintime1':$("#search_begintime1").combo("getValue"),
			'begintime2':$("#search_begintime2").combo("getValue"),
			'endtime1':$("#search_endtime1").combo("getValue"),
			'endtime2':$("#search_endtime2").combo("getValue"),
			'headerName':$("#search_headerName").val(),
			'managerName':$("#search_managerName").val(),
			'status':$("#search_status").combo("getValue")
		},function(data){
			$("#dg").datagrid('loadData',{
				rows:data.rows,
				total:data.total
			});
		},'json');
	}
    
	//班级合并
	/*
	1.至少选两个班级进行合并
	2.所选班级其中状态必须是正常的
	3.所选班级今天不能有考试
	
	*/
	
	function combineClass(){
		var selectedRow = $("#dg").datagrid("getSelections");
		if(selectedRow.length < 2){
				alert("对不起，至少选中两个班级才能进行合并");
				return;
		}
		var b = true;
		for(var i=0;i<selectedRow.length;i++){
			if(selectedRow[i].status !=1){
				b = false;
				break;
			}
			
		}
		if(!b){
			alert("对不起，所选班级必须全部是正常的");
			return;
		}
		//获取已选中的班级id
		var cids = new Array();
		var options = new Array;
		options.push({name:'请指定合并后的班级',cid:'-1'});
		for(var i=0;i<selectedRow.length;i++){
			cids.push(selectedRow[i].cid);
			options.push({"name":selectedRow[i].name,"cid":selectedRow[i].cid});
		}
		
		
		
		$.post("http://localhost:8080/MyTKP/index.php/Home/Class/checkExamToday",{"cids":cids.join(",")},function(data){

			if(data=="ok"){
				//加载选择班级名称
				$("#combinedClassid").combobox({
					valueField:'cid',    
				    textField:'name' ,
				    data:options,
				    value:'-1'
				});
				
				//加载选择班主任名称
				
				$("#combinedHeaderid").combobox({
					url:'http://localhost:8080/MyTKP/index.php/Home/User/loadAllHeader',
					valueField:'uid',    
				    textField:'truename' ,
				    value:'-1'
				});
				//加载选择项目经理名称
				$("#combinedManageid").combobox({
					url:'http://localhost:8080/MyTKP/index.php/Home/User/loadAllManager',
					valueField:'uid',    
				    textField:'truename' ,
				    value:'-1'
				});
				
				$('#win').window('open');
			}else{
				alert(data)
			}
			
		},"text");
		
	}
	
	function hebingeClass(){
		var cids = new Array();
		var selectedRow = $("#dg").datagrid("getSelections");
		
		for(var i=0;i<selectedRow.length;i++){
			cids.push(selectedRow[i].cid);
		}
		$.post("http://localhost:8080/MyTKP/index.php/Home/Class/hebingeClass",{
			"cids":cids.join(","),
			"combinedClassid":$("#combinedClassid").combo('getValue'),
		"combinedHeaderid":$("#combinedHeaderid").combo('getValue'),
		"combinedManageid":$("#combinedManageid").combo('getValue')
			
		},function(data){
			$('#win').window('close');
			$("#dg").datagrid('loadData',{
				rows:data.rows,
				total:data.total
			});
			
		},"josn");
		
	}
	
	function refreshData(pageNumber,pageSize){
		$("#dg").datagrid('loading');
//			alert('pageNumber:'+pageNumber+',pageSize:'+pageSize);
		$.getJSON("http://localhost:8080/MyTKP/index.php/Home/Class/loadClassByPage?pageNo="+pageNumber+"&pageSize="+pageSize,{},function(data){
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
    	<div id="tb">
    		<form action="" id="searchForm">
    			<table>
    				<tr>
    					<td>
    						<label>班级名称：</label>
    						<input type="text"  class="easyui-validatebox in" placeholder="班级模糊查询" id="search_className"/>
    					</td>
    					<td>
    						<label>创建时间</label>
    						<input type="text" class="easyui-datebox in" id="search_createtime1" />
    					</td>
    					<td>
    						<label>至</label>
    						<input type="text" class="easyui-datebox in" id="search_createtime2"/>
    					</td>
    				</tr>
    				<tr>
    					<td>
    						<label>班&nbsp;主&nbsp;任&nbsp;：</label>
    						<input type="text"  class="easyui-validatebox in" placeholder="班主任模糊查询" id="search_headerName"/>
    					</td>
    					<td>
    						<label>开班时间</label>
    						<input type="text" class="easyui-datebox in" id="search_begintime1"/>
    					</td>
    					<td>
    						<label>至</label>
    						<input type="text" class="easyui-datebox in" id="search_begintime2"/>
    					</td>
    				</tr>
    				
    				<tr>
    					<td>
    						<label>项目经理：</label>
    						<input type="text"  class="easyui-validatebox in" placeholder="项目经理模糊查询" id="search_managerName"/>
    					</td>
    					<td>
    						<label>结业时间</label>
    						<input type="text" class="easyui-datebox in" id="search_endtime1"/>
    					</td>
    					<td>
    						<label>至</label>
    						<input type="text" class="easyui-datebox in" id="search_endtime2"/>
    					</td>
    				</tr>
    				<tr>
    					<td colspan="3">
    						<label>状&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;态：</label>
			    			<select class="easyui-combobox in" id="search_status">
			    				<option value="-1">按状态查询</option>
			    				<option value="1">正常</option>
			    				<option value="2">被合并</option>
			    				<option value="3">已结业</option>
			    				<option value="4">已废除</option>
			    			</select>
    			
    						<a href="javascript:searchClass();" class="easyui-linkbutton" data-options="iconCls:'icon-search',plain:true">搜索</a>
    						<a href="javascript:combineClass();" class="easyui-linkbutton" data-options="iconCls:'icon-collect',plain:true">合并</a>
    					</td>
    				</tr>
    			</table>
    		</form>
    	</div>
    	<table id="dg"></table>
    	<div id="win" class="easyui-window" title="合并班级" style="width:600px;height:460px"   
        data-options="iconCls:'icon-collect',modal:true,collapsible:false,minimizable:false,maximizable:false,resizable:false">   
	   		 <form id="ff" method="post">
	   		 	<input type="hidden" id="cid"/> 
	   		 	<table style="width: 60%;margin: auto;margin-top:20px;">
	   		
	   		 		<tr>
	   		 			<td align="right"><label for="combinedClassid">合并后班级名称:</label></td>
	   		 			<td>
	   		 				<select id="combinedClassid" class="easyui-combobox in" style="width:150px;"></select>
	   		 			</td>
	   		 		</tr>
	   		 		<tr>
	   		 			<td align="right"><label for="combinedHeaderid">合并后班主任名称:</label></td>
	   		 			<td>
	   		 				<select id="combinedHeaderid" class="easyui-combobox in" style="width:150px;"></select>
	   		 			</td>
	   		 		</tr>
	   		 		<tr>
	   		 			<td align="right"><label for="combinedManageid">合并后项目经理名称:</label></td>
	   		 			<td>
	   		 				<select id="combinedManageid" class="easyui-combobox in" style="width:150px;"></select>
	   		 			</td>
	   		 		</tr>
	   		 		<tr>
	   		 			<td align="center" colspan="2">
	   		 				<a id="btn" href="javascript:hebingeClass();" class="easyui-linkbutton" data-options="iconCls:'icon-submit'">合并后班级</a>
	   		 			</td>
	   		 		</tr>
	   		 	</table>
	        
			</form>  

		</div>  
    
    </body>

 

</html>