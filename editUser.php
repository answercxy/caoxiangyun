<!DOCTYPE html>
<?php
	session_start();
	if(isset($_SESSION["root"]))
	{	
?>
<html>
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="chorme=1,IE=edge">
	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
	<title>用户信息编辑</title>
	<link rel="shortcut icon" href="cx.ico"  type="image/x-icon"/> 
	<link rel="icon" href="cx.ico" type="image/x-icon"/>
	<link rel="bookmark" href="cx.ico" type="image/x-icon" />
	<link rel="stylesheet" type="text/css" href="layui/css/layui.css"/>
	<style>
		body{
			padding-top: 0px;
			padding:20px;
			padding-left: 0px;
		}
	</style>
	<script type="text/javascript" src="dist/jquery.js"></script>
	<script type="text/javascript" src="layui/layui.js"></script>
	<script src="dist/md5.js" type="text/javascript" charset="utf-8"></script>
</head>
<body>
	<form class="layui-form"> <!-- 提示：如果你不想用form，你可以换成div等任何一个普通元素 -->
	  <input type="hidden" id="id" name="id" value="<?php if($_GET['user']==0){echo 0;}else{echo $_GET['id'];} ?>">
	  <div class="layui-form-item">
	    <label class="layui-form-label">用户名</label>
	    <div class="layui-input-block">
	      <input <?php if($_GET['user']==1) echo 'style="border: none;" disabled'; ?> type="text" name="name" placeholder="请输入用户名" lay-verify="required" autocomplete="off" class="layui-input" value="<?php if($_GET['user']==1)echo $_GET['name']; ?>">
	    </div>
	  </div>
	  <div class="layui-form-item">
	    <label class="layui-form-label">密码</label>
	    <div class="layui-input-block">
	      <input type="text" name="password" placeholder="请输入密码" lay-verify="required" autocomplete="off" class="layui-input">
	    </div>
	  </div>
	  <div class="layui-form-item">
	    <label class="layui-form-label">权限</label>
	    <div class="layui-input-block">
	      <input style="border: none;" type="text" name="root" autocomplete="off" disabled lay-verify="required" class="layui-input" value="<?php
	      			if($_GET['user']==1 && $_GET['root']==127){
	      				echo "充钱的大佬";
	      			}else{
	      				echo "不充钱的屌丝";
	      			}
	      	?>">
	    </div>
	  </div>
	  
	  <div class="layui-input-block">
      <button class="layui-btn" lay-submit lay-filter="save">立即提交</button>
    </div>
	  
  </form>
  <script>
  	layui.use(["form","layer"],function(form,layer){
  		form.on('submit(save)', function(data){
			  console.log(data.elem) //被执行事件的元素DOM对象，一般为button对象
			  console.log(data.form) //被执行提交的form对象，一般在存在form标签时才会返回
			  console.log(data.field) //当前容器的全部表单字段，名值对形式：{name: value}
			  var edit="<?php echo($_GET['user']); ?>";
			  var d=JSON.stringify(data.field);
			  d=JSON.parse(d);
			  d.password=getstringmd5(getstringmd5(d.password));//强力加密
			  d.root=="充钱的大佬"?d.root=127:d.root=0;
			  if(edit==="0"){//新增用户
			  	$.post("php/checkUser.php",data.field,function(data){
			  		if(data === "exist"){//用户已存在
			  			layer.msg('该用户名已存在，请重新设置', {
							  icon: 2,
							  time: 2000 //2秒关闭（如果不配置，默认是3秒）
							}, function(){
							  //do something
							});   
			  		}else{//继续
			  			formSubmit(d);
			  		}
			  	})
			  }else{//修改用户密码
	  			formSubmit(d);	
			  }
			  return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
			});
			
			//表单提交
			function formSubmit(data){
				var loading=parent.layer.load(1);
				$.post("php/regist.php",data,function(data){
					var top=window.top;
		    	top=top.contentWindow || top;
		    	top.refresh();
					parent.layer.close(loading);
					if(data=="success"){
						//成功
						layer.msg('操作成功', {
							  icon: 1,
							  time: 2000 //2秒关闭（如果不配置，默认是3秒）
							}, function(){
								parent.layer.closeAll();
							  //do something
						});   
					}else{

					}
				});
			}
  	});
  </script>
</body>
<?php
	}		
?>