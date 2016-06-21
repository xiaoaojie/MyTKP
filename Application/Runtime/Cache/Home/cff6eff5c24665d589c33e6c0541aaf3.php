<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
	<title></title>
</head>
    <body >
    	reg模板<br/>
    	<?php echo ($ttt); ?><br/>
    	<?php echo ($arr[1]); ?><br/>
    	<?php echo ($arr2["aa"]); ?>--<?php echo ($arr2[bb]); ?><br/>
    	<?php echo ($data["0"]["cid"]); ?>--<?php echo ($data[0]["name"]); ?><br/>
    	<?php echo ($_SERVER['HTTP_USER_AGENT']); ?><br/>
    	<?php echo (md5($str)); ?><br/>
    	<?php echo (substr($str,0,3)); ?>---<?php echo (substr($str,0,5)); ?><br/>
    	<?php echo ($i+$j); ?>--<?php echo ($i++); ?>
    	<br/>
    	<br/>
    	<br/>
    	<br/>
    	<table border="1" bordercolor="blue" width="100%" cellspacing="0">
    	<tr>
    		<td>编号</td>
    		<td>名称</td>
    		<td>类型</td>
    		<td>创建时间</td>
    		<td>开班时间</td>
    		<td>结业时间</td>
    		<td>班主任</td>
    		<td>项目经理</td>
    		<td>人数</td>
    		<td>状态</td>
    		<td>备注</td>
    	</tr>
    	
    	<?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "$msg" ;else: foreach($__LIST__ as $key=>$class): $mod = ($i % 2 );++$i; if(($mod) == "0"): ?><tr style="background-color:gray">
	    		<td><?php echo ($class["cid"]); ?></td>
	    		<td><?php echo ($class["name"]); ?></td>
	    		<td><?php if($class["classtype"] == 1): ?>常规班
	    		<?php elseif($class["classtype"] == 2): ?>
	    		快速班
	    		<?php elseif($class["classtype"] == 3): ?>
	    		flash班
	    		<?php else: ?>
	    		php班<?php endif; ?></td>
	    		
	    		<td><?php echo ($class["createtime"]); ?></td>
	    		<td><?php echo ($class["begintime"]); ?></td>
	    		<td><?php echo ($class["endtime"]); ?></td>
	    		<td><?php echo ($class["headerid"]); ?></td>
	    		<td><?php echo ($class["manageid"]); ?></td>
	    		<td><?php echo ($class["stucount"]); ?></td>
	    		<td><?php echo ($class["status"]); ?></td>
	    		<td><?php echo ($class["remark"]); ?></td>
    		</tr><?php endif; ?>
    	<?php if(($mod) == "1"): ?><tr style="background-color:red">
	    		<td><?php echo ($class["cid"]); ?></td>
	    		<td><?php echo ($class["name"]); ?></td>
	    		<td><?php if($class["classtype"] == 1): ?>常规班
	    		<?php elseif($class["classtype"] == 2): ?>
	    		快速班
	    		<?php elseif($class["classtype"] == 3): ?>
	    		flash班
	    		<?php else: ?>
	    		php班<?php endif; ?></td>
	    		
	    		<td><?php echo ($class["createtime"]); ?></td>
	    		<td><?php echo ($class["begintime"]); ?></td>
	    		<td><?php echo ($class["endtime"]); ?></td>
	    		<td><?php echo ($class["headerid"]); ?></td>
	    		<td><?php echo ($class["manageid"]); ?></td>
	    		<td><?php echo ($class["stucount"]); ?></td>
	    		<td><?php echo ($class["status"]); ?></td>
	    		<td><?php echo ($class["remark"]); ?></td>
    		</tr><?php endif; endforeach; endif; else: echo "$msg" ;endif; ?>
    	
    	<!-- 
    	<?php if(is_array($data)): foreach($data as $i=>$class): if(($i%2) == "0"): ?><tr style="background-color:gray">
	    		<td><?php echo ($class["cid"]); ?></td>
	    		<td><?php echo ($class["name"]); ?></td>
	    		<td><?php echo ($class["classtype"]); ?></td>
	    		<td><?php echo ($class["createtime"]); ?></td>
	    		<td><?php echo ($class["begintime"]); ?></td>
	    		<td><?php echo ($class["endtime"]); ?></td>
	    		<td><?php echo ($class["headerid"]); ?></td>
	    		<td><?php echo ($class["manageid"]); ?></td>
	    		<td><?php echo ($class["stucount"]); ?></td>
	    		<td><?php echo ($class["status"]); ?></td>
	    		<td><?php echo ($class["remark"]); ?></td>
    		</tr><?php endif; ?>
    	<?php if(($i%2) == "1"): ?><tr style="background-color:red">
	    		<td><?php echo ($class["cid"]); ?></td>
	    		<td><?php echo ($class["name"]); ?></td>
	    		<td><?php echo ($class["classtype"]); ?></td>
	    		<td><?php echo ($class["createtime"]); ?></td>
	    		<td><?php echo ($class["begintime"]); ?></td>
	    		<td><?php echo ($class["endtime"]); ?></td>
	    		<td><?php echo ($class["headerid"]); ?></td>
	    		<td><?php echo ($class["manageid"]); ?></td>
	    		<td><?php echo ($class["stucount"]); ?></td>
	    		<td><?php echo ($class["status"]); ?></td>
	    		<td><?php echo ($class["remark"]); ?></td>
    		</tr><?php endif; endforeach; endif; ?>
    	-->
    	 <?php $__FOR_START_14686__=0;$__FOR_END_14686__=$arrayLength;for($i=$__FOR_START_14686__;$i < $__FOR_END_14686__;$i+=1){ ?><!-- <for start="$arrayLength-1" end="0" step="-1" comparison="egt" name="i" >
    	 <?php if(($i%2) == "0"): ?><tr style="background-color:yellow">
	    		<td><?php echo ($data["$i"]["cid"]); ?></td>
	    		<td><?php echo ($data["$i"]["name"]); ?></td>
	    		<td><?php echo ($data["$i"]["classtype"]); ?></td>
	    		<td><?php echo ($data["$i"]["createtime"]); ?></td>
	    		<td><?php echo ($data["$i"]["begintime"]); ?></td>
	    		<td><?php echo ($data["$i"]["endtime"]); ?></td>
	    		<td><?php echo ($data["$i"]["headerid"]); ?></td>
	    		<td><?php echo ($data["$i"]["manageid"]); ?></td>
	    		<td><?php echo ($data["$i"]["stucount"]); ?></td>
	    		<td><?php echo ($data["$i"]["status"]); ?></td>
	    		<td><?php echo ($data["$i"]["remark"]); ?></td>
    		</tr><?php endif; ?>
    	<?php if(($i%2) == "1"): ?><tr style="background-color:green">
	    		<td><?php echo ($data["$i"]["cid"]); ?></td>
	    		<td><?php echo ($data["$i"]["name"]); ?></td>
	    		<td><?php echo ($data["$i"]["classtype"]); ?></td>
	    		<td><?php echo ($data["$i"]["createtime"]); ?></td>
	    		<td><?php echo ($data["$i"]["begintime"]); ?></td>
	    		<td><?php echo ($data["$i"]["endtime"]); ?></td>
	    		<td><?php echo ($data["$i"]["headerid"]); ?></td>
	    		<td><?php echo ($data["$i"]["manageid"]); ?></td>
	    		<td><?php echo ($data["$i"]["stucount"]); ?></td>
	    		<td><?php echo ($data["$i"]["status"]); ?></td>
	    		<td><?php echo ($data["$i"]["remark"]); ?></td>
    		</tr><?php endif; } ?>
    	  --> 
    	</table>
    	
    	
    	<?php if($j < 3): ?>hehe
    	<?php elseif($j == 3): ?>
    		gege
    	<?php else: ?>
    		haha<?php endif; ?>
    </body>
</html>