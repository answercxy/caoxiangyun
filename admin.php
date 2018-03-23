<!DOCTYPE html>
<?php
	session_start();
	if(isset($_SESSION["root"]) && $_SESSION["root"]==127)
	{	
		
?>
<html>
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="chorme=1,IE=edge">
	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
	<title>用户管理</title>
	<link rel="shortcut icon" href="cx.ico"  type="image/x-icon"/> 
	<link rel="icon" href="cx.ico" type="image/x-icon"/>
	<link rel="bookmark" href="cx.ico" type="image/x-icon" />
	<link rel="stylesheet" type="text/css" href="layui/css/layui.css"/>
	<style type="text/css">
		.layui-layer.layui-layer-iframe{
			max-width: 100%;
		}
	</style>
	<script type="text/javascript" src="dist/jquery.js" ></script>
	<script type="text/javascript" src="layui/layui.js" ></script>
</head>
<body>
	<div class="layui-layout layui-layout-admin">
	<div class="layui-header pc-header layui-bg-black">
		<div class="layui-logo">用户管理</div>
    <ul class="layui-nav layui-layout-right">
      <li class="layui-nav-item">
        <a href="javascript:;">
          <img src="cx.png" class="layui-nav-img"/>
          <?php echo($_SESSION["name"])?>
        </a>
        <dl class="layui-nav-child">
          <dd><a id="addUser" href="javascript:void(0)">新增用户</a></dd>
          <dd><a href="index.php">返回首页</a></dd>
          <dd><a href="php/exit.php">退出</a></dd>
        </dl>
      </li>
    </ul>
  </div>
	<!--<a href="php/exit.php">退出</a>-->
	<table id="dg" lay-filter="dg">
	</table>
	</div>
	<script>
		layui.use(["table","element","layer","upload"],function(table,element,layer,upload){
			table.render({
				elem: '#dg'
			    ,height: 'full-80' 
			    ,cellMinWidth: 100
			    ,url: 'php/user.php' //数据接口
			    ,size:'lg'
			    ,even:true
			    ,skin:'row'
			    ,text: {
			    	none:'暂无相关数据'
			    }
			    ,cols: [[ //表头
			    	{field: 'numbers',type: 'numbers',title: '序号', sort:true, width:70, fixed: 'left'}
			      ,{field: 'id', title: 'ID', sort:true}
			      ,{field: 'name', title: '用户名', sort:true}
			      ,{field: 'root', title: '用户权限',sort: true,templet: function(d){
				        if(d.root==127){
				        	return "充钱的大佬";
				        }else{
				        	return "不充钱的屌丝";
				        }
				      }}
			      ,{field: 'date', title: '创建时间',sort:true}
			      ,{field:'right',title:'操作',width:200,align:'center',toolbar: '#barOperating',fixed:"right"}
			    ]]
			    ,page: true//开启分页
				});
				
				//监听工具条
				table.on('tool(dg)', function(obj){ //注：tool是工具条事件名，test是table原始容器的属性 lay-filter="对应的值"
				  var data = obj.data; //获得当前行数据
				  var layEvent = obj.event; //获得 lay-event 对应的值（也可以是表头的 event 参数对应的值）
				  var tr = obj.tr; //获得当前行 tr 的DOM对象
				  if(layEvent === 'editUser'){ //修改
				  	//console.log(obj.data);
				  	var index = layer.open({
						  type:2,
						  content:"editUser.php?user=1&id="+obj.data.id+"&name="+obj.data.name+"&root="+obj.data.root,
						  title:obj.data.name+"密码修改",
						  area:["500px","500px"]
						});
				  }else if(layEvent === 'deleteUser'){//删除
				  	var a=layer.alert("你确定要删除这个小兄弟吗",function(){
				  		layer.close(a);
				  		$.post("./php/deleteUser.php",{
				  			id:obj.data.id
				  		},function(data){
				  			if(data==="success"){
				  				layer.msg("小兄弟永久的离开了我们");
				  			}else{
				  				layer.msg("这个小兄弟比较特殊，你删不掉他");
				  			}
				  			refresh();
				  		});
				  	})
				  }
				});
				
				$("#addUser").click(function(){
					var index = layer.open({
					  type:2,
					  content:"editUser.php?user=0",
					  title:"用户新增",
					  area:["500px","500px"]
					});
				});
		});
		
		//页面刷新
		function refresh(){
			$(".layui-laypage-btn").trigger("click");	
		}
	</script>
	
	<script type="text/html" id="barOperating">
		<a class="layui-btn layui-btn-sm layui-btn-normal procInstView" lay-event="editUser"><i class="layui-icon">&#xe642;</i>修改</a>
		{{# if(d.root!="127"){ }}
		<a class="layui-btn layui-btn-sm layui-btn-danger procInstView" lay-event="deleteUser"><i class="layui-icon">&#xe640;</i>删除</a>
		{{# } }}
	</script>
</body>
<?php
}
?>