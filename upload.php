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
	<title>曹翔云</title>
	<link rel="shortcut icon" href="cx.ico"  type="image/x-icon"/> 
	<link rel="icon" href="cx.ico" type="image/x-icon"/>
	<link rel="bookmark" href="cx.ico" type="image/x-icon" />
	<link rel="stylesheet" type="text/css" href="layui/css/layui.css"/>
	<style>
		body{
			padding-top: 0px;
			padding:20px;
		}
	</style>
	<script type="text/javascript" src="dist/jquery.js"></script>
	<script type="text/javascript" src="layui/layui.js"></script>
</head>
<body>
	<a href="javascript:void(0)" id="typeChange">大型文件上传</a>
	<div id="smallFile">
		<fieldset class="layui-elem-field layui-field-title" style="margin-top: 30px;">
		  <legend>曹翔云：多文件上传(单个文件500mb以下)</legend>
		</fieldset> 
	 
		<div class="layui-upload">
		  <button type="button" class="layui-btn layui-btn-normal" id="testList">选择多文件</button> 
		  <div class="layui-upload-list">
		    <table class="layui-table">
		      <thead>
		        <tr><th>文件名</th>
		        <th>大小</th>
		        <th>状态</th>
		        <th>操作</th>
		      </tr></thead>
		      <tbody id="demoList"></tbody>
		    </table>
		  </div>
		  <button type="button" class="layui-btn" id="testListAction">开始上传</button>
		</div>
	</div>
	
	<div id="bigFile" style="display: none;">
		<fieldset class="layui-elem-field layui-field-title" style="margin-top: 30px;">
		  <legend>曹翔云：大型文件上传（960mb以下）</legend>
		</fieldset>
		 
		<div class="layui-upload">
		  <button type="button" class="layui-btn layui-btn-normal" id="test8">选择文件</button>
		  <button type="button" class="layui-btn" id="test9">开始上传</button>
		</div>
	</div>
	<script>
		layui.use(["upload"],function(upload){
		  //多文件列表示例
		  var demoListView = $('#demoList')
		  ,loading
		  ,uploadListIns = upload.render({
		    elem: '#testList'
		    ,url: 'php/upload.php'
		    ,accept: 'file'
		    ,size:1024*500
		    ,multiple: true
		    ,auto: false
		    ,bindAction: '#testListAction'
		    ,before: function(obj){
		    	loading=parent.layer.load(1);
		    }
		    ,choose: function(obj){   
		      var files = this.files = obj.pushFile(); //将每次选择的文件追加到文件队列
		      //读取本地文件
		      obj.preview(function(index, file, result){
		      	if(file.name.length);
		        var tr = $(['<tr id="upload-'+ index +'">'
		          ,'<td>'+ file.name +'</td>'
		          ,'<td>'+ (file.size/1014).toFixed(1) +'kb</td>'
		          ,'<td>等待上传</td>'
		          ,'<td>'
		            ,'<button class="layui-btn layui-btn-mini demo-reload layui-hide">重传</button>'
		            ,'<button class="layui-btn layui-btn-mini layui-btn-danger demo-delete">删除</button>'
		          ,'</td>'
		        ,'</tr>'].join(''));
		        
		        //单个重传
		        tr.find('.demo-reload').on('click', function(){
		          obj.upload(index, file);
		        });
		        
		        //删除
		        tr.find('.demo-delete').on('click', function(){
		          delete files[index]; //删除对应的文件
		          tr.remove();
		          uploadListIns.config.elem.next()[0].value = ''; //清空 input file 值，以免删除后出现同名文件不可选
		        });
		        
		        demoListView.append(tr);
		      });
		    }
		    ,done: function(res, index, upload){
		    	var top=window.top;
		    	top=top.contentWindow || top;
		    	top.refresh();
		    	parent.layer.close(loading);
		      if(res.code == 0){ //上传成功
		      	layer.alert("传完了，传完了",function(){
		      		parent.layer.closeAll();
		      	});
		        var tr = demoListView.find('tr#upload-'+ index)
		        ,tds = tr.children();
		        tds.eq(2).html('<span style="color: #5FB878;">上传成功</span>');
		        tds.eq(3).html(''); //清空操作
		        return delete this.files[index]; //删除文件队列已经上传成功的文件
		      }
		      this.error(index, upload);
		    }
		    ,error: function(index, upload){
		    	parent.layer.close(loading);
		    	layer.alert("跪了跪了");
		      var tr = demoListView.find('tr#upload-'+ index)
		      ,tds = tr.children();
		      tds.eq(2).html('<span style="color: #FF5722;">上传失败</span>');
		      tds.eq(3).find('.demo-reload').removeClass('layui-hide'); //显示重传
		    }
		  });
		  
		  //选完文件后不自动上传（大文件上传）
		  upload.render({
		    elem: '#test8'
		    ,url: 'php/upload.php'
		    ,auto: false
		    ,size: 1024*960
		    ,accept: "file"
		    ,bindAction: '#test9'
		    ,before:function(obj){
		    	loading=parent.layer.load(1);
		    }
		    ,done: function(res){
		    	var top=window.top;
		    	top=top.contentWindow || top;
		    	top.refresh();
		    	parent.layer.close(loading);
		    	if(res.code==0){
		    		layer.alert("传完了，传完了",function(){
		    			parent.layer.closeAll();
		    		});
		    	}else{
		    		layer.alert("你人品有点不行啊，小兄弟");
		    	}
		    }
		  });
		  
		  $("#typeChange").click(function(){
		  	var dis=$("#smallFile").css("display");
		  	if(dis==="none"){
		  		$("#smallFile").css("display","block");
		  		$("#bigFile").css("display","none");
		  		$(this).html("切换到大型文件上传");
		  	}else{
		  		$("#smallFile").css("display","none");
		  		$("#bigFile").css("display","block");
		  		$(this).html("切换到多文件上传");
		  	}
		  });
		})
	</script>
</body>
<?php
}
?> 