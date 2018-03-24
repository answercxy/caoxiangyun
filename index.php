<!DOCTYPE html>
<?php
	session_start();
	if(isset($_SESSION["c_root"]))
	{	
		
?>
<html>
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="chorme=1,IE=edge">
	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
	<title>曹翔云</title>
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
		<div class="layui-logo">曹翔云</div>
    <ul class="layui-nav layui-layout-right">
      <li class="layui-nav-item">
        <a href="javascript:;">
          <img src="cx.png" class="layui-nav-img"/>
          <?php echo($_SESSION["name"])?>
        </a>
        <dl class="layui-nav-child">
          <dd><a id="showUploadBox" href="javascript:void(0)">上传文件</a></dd>
          <?php
          	//曹翔无敌黄金老会员专属服务
          	if($_SESSION["c_root"]==127){
          		echo '<dd><a href="admin.php">用户管理</a></dd>';
          	}
          ?>
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
			    ,url: 'php/info.php' //数据接口
			    ,size:'lg'
			    ,even:true
			    ,skin:'row'
			    ,text: {
			    	none:'暂无相关数据'
			    }
			    ,cols: [[ //表头
			    	{field: 'numbers',type: 'numbers',title: '序号', sort:true, width:70, fixed: 'left'}
			      //,{field: 'id', title: 'ID',  sort: true}
			      ,{field: 'name', title: '文件名', sort:true}
			      ,{field: 'showName', title: '显示文件名', sort:true}
			      ,{field: 'userName', title: '上传用户',sort: true}
			      ,{field: 'size', title: '文件大小', sort:true,templet: function(d){
        			if(d.size==0){
        				return "<1MB";
        			}else{
        				return d.size+"MB";
        			}
      			}} 
			      ,{field: 'date', title: '时间', sort:true}
			      ,{field:'right',title:'操作',width:200,align:'center',toolbar: '#barOperating',fixed:"right"}
			    ]]
			    ,page: true//开启分页
				});
				
				//监听工具条
				table.on('tool(dg)', function(obj){ //注：tool是工具条事件名，test是table原始容器的属性 lay-filter="对应的值"
				  var data = obj.data; //获得当前行数据
				  var layEvent = obj.event; //获得 lay-event 对应的值（也可以是表头的 event 参数对应的值）
				  var tr = obj.tr; //获得当前行 tr 的DOM对象
				  if(layEvent === 'download'){ //下载
				  	//console.log(obj.data);
				  	window.open("php/download.php?action=download&fname="+obj.data.showName);
				  }else if(layEvent === 'deleteFile'){//删除文件
				  	$.post("php/deleteFile.php",{
				  		id:obj.data.id,
				  		showName:obj.data.showName
				  	},function(data){
				  		refresh();
				  		if(data==="success"){
				  			layer.msg("删除成功");
				  		}else{
				  			layer.msg("文件不存在或以经删除");
				  		}
				  	});
				  }
				});
				
				//上传
				$("#showUploadBox").click(function(){
					var index = layer.open({
					  type:2,
					  content:"upload.php",
					  title:"文件上传",
					  area:["500px","500px"]
					});
				})
		});
		
		//页面刷新
		function refresh(){
			$(".layui-laypage-btn").trigger("click");	
		}
	</script>
	<script type="text/html" id="barOperating">
		<a class="layui-btn layui-btn-sm procInstView" lay-event="download"><i class="layui-icon">&#xe601;</i>下载</a>
		<?php if($_SESSION["c_root"]==127){ ?>
		<a class="layui-btn layui-btn-sm layui-btn-danger procInstView" lay-event="deleteFile"><i class="layui-icon">&#xe640;</i>删除</a>
		<?php }?>
	</script>
</body>
<?php
}else{
	Header("Location: login.php");
}
?>