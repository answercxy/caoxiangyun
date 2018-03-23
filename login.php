<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="chorme=1,IE=edge">
	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
	<title>曹翔云-登录</title>
	<link rel="shortcut icon" href="cx.ico"  type="image/x-icon"/> 
	<link rel="icon" href="cx.ico" type="image/x-icon"/>
	<link rel="bookmark" href="cx.ico" type="image/x-icon" />
	<link rel="stylesheet" type="text/css" href="layui/css/layui.css"/>
	<link rel="stylesheet" type="text/css" href="css/login.css"/>
	<script type="text/javascript" src="dist/jquery.js" ></script>
	<script type="text/javascript" src="layui/layui.js" ></script>
	<script type="text/javascript" src="dist/jquery.cookie.js" ></script>
	<script src="dist/md5.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript" src="dist/jquery.particleground.min.js" ></script>
	<script type="text/javascript" src="dist/ban.js" ></script><!-- 直线动画 -->
</head>
<body style="margin:0;overflow:hidden;">
<canvas id="xCanvas"></canvas>
<div class="main">
	<div class="main-title">
		曹翔云
	</div>
	<div class="small-title">
		<span>用户登录</span>
		<span>User Login</span>
	</div>
	<div class="mainbox">
	  <div class="denglu">
	      <form id="loginForm" class="layui-form" action="#" method="POST">
		    <div class="dlk">
		      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
		        <tr>
		          <td colspan="3"><div class="icondiv"><img width="14" height="14" src="images/user.png"/></div><input autocomplete="off" type="name" id="userName" placeholder="用户名" class="dlinput"></td>
		        </tr>
		        <tr>
		          <td height="16" colspan="3"></td>
		        </tr>
		        <tr>
		          <td colspan="2"><div class="icondiv"><img width="14" height="14" src="images/lock.png"/></div><input type="password" id="password" placeholder="密码" class="dlinput"></td>
		        </tr>
		        <tr>
		          <td height="20"></td>
		        </tr>
		        <tr>
		        	<td>
		        		<div class="chooseBox"><input lay-skin="primary" title="曹翔云协议" type="checkbox" id="rememberMe"/></div>
		        		<div id="messageDiv" class="tipInfo form-warning-text" style="display:none;">用户不能为空!</div>
		        	</td>
		        </tr>
		        <tr>
		          <td height="20" colspan="3"></td>
		        </tr>
		        <tr>
		        	<td colspan="2"><input type="submit" value="登录"></td>
		        </tr>
	     	  </table>
		    </div>
	  	</form>
	  </div>
	</div>
</div>

<script type="text/javascript">
	browserDeal();//判断浏览器并给出相应解决方案
	$(document).ready(function(){
		bgAnima1();
		layui.use("form",function(){
			
		});
		//bgAnima2();
		function msgbox(msg,type){
			$("#messageDiv").removeClass();
			
			$("#messageDiv").addClass("form-"+type+"-text ");
			$("#messageDiv").html(msg);
			
			$("#messageDiv").show();
		}
		$("#loginForm").submit(function(){
			var userName = $("#userName").val();
			var password = getstringmd5(getstringmd5($("#password").val()));//强力加密
						
			if(userName.length==0){
				msgbox("用户名不能为空!","warning");
				return false;
			}
			
			if(password.length==0){
				msgbox("密码不能为空!","warning");
				return false;
			}
			
			if($("#rememberMe").is(":checked")){
				 $.cookie('wsjoa_userName',userName);				
			}
			else{
				$.cookie('wsjoa_userName',"");
			}

			msgbox("用户登录中，请稍后...","succeed");
			$(".loginbtn").attr("disabled","disabled");
			
			try{
				$.post("php/checkUser.php",{
					name : userName,
					login: 1
				},function(rs){
					if(rs==="exist"){
						$.post("php/login.php",{
							name: userName,
							password: password,
							login: 1
						},function(data){
							document.write(data);
							if(data==="success"){
								//跳转到首页
								msgbox("用户登录成功!正在跳转到首页!","succeed");						
								window.location.href="index.php";
							}else{
								$(".loginbtn").removeAttr("disabled");
								msgbox("密码错误","error");
							}
						});
					}
					else{
						$(".loginbtn").removeAttr("disabled");
						msgbox("用户名不存在","error");
					}
				});
			}
			catch(ex){
				//console.log(ex);
				msgbox(ex,"error");
			}
			
			return false;
		});
		
	});
	
	$(window).resize(function(){
			bgAnima1();
	}); 
	function browserDeal(){
		var name=window.navigator.appName
		,version=window.navigator.appVersion.substring(0,1);
		console.log(window.navigator);
		if(name==="Microsoft Internet Explorer"){//ok,不说了，你是ie11版本以下的ie
			//是ie就给个提示
			$("body").append('<div style="color:red;position:fixed;height:30px;top:0px;background:white;z-index:1;width:100%;line-height:30px;font-size:20px;">系统检测到您正在使用ie11以下版本的IE内核浏览器，若想获得得更好体验建议您使用非IE浏览器</div>');
			if(parseInt(version)<5){
				alert("您的的浏览器过于古老，建议您下载新的浏览器");
				window.location.href="https://www.baidu.com/s?wd=%E8%B0%B7%E6%AD%8C%E6%B5%8F%E8%A7%88%E5%99%A8%E4%B8%8B%E8%BD%BD&ie=utf-8&rsv_op=L8b36hLfhSbLeT567aPdTW5V2ZaKehQX5YO2NUYdPLh64L8b6c00LYXPN2TIfXP1PZ39IQ17T0d3UZUfe3f4ZY3ZLUW2MI2e&tn=06074089_50_pg%26ch%3D1&ch=&rsv_su=45KS1JbQWbhZNMP3a6gg374d1SgOYbLSfa82MJU726hS59Vdd3dMVYMXTSN7aW64c4dXM419fPU3T9Z2WaJ6U17bK8d7TOcN";
			}
		}
	}
</script>

<script>
//粒子背景特效
function bgAnima2(){
	if(document.getElementById("canvas")){
		var c=document.getElementById("canvas");
		c.parentNode.removeChild(c);
	}
	$('body').particleground({
	    dotColor: '#5cbdaa',
	   	lineColor: '#5cbdaa'
	});
}
//星空动画 
function bgAnima1(){//宇宙特效
	if(document.getElementById("canvas")){
		var c=document.getElementById("canvas");
		c.parentNode.removeChild(c);
	}
	var canvas=document.createElement("canvas");
	canvas.setAttribute("id", "canvas");
	document.body.appendChild(canvas);
	//var canvas = document.getElementById('canvas');
	canvas.height=0;
	canvas.width=0;
	var ctx = canvas.getContext('2d'),
	  w = canvas.width = window.innerWidth,
	  h = canvas.height = window.innerHeight,
	
	  hue = 217,
	  stars = [],
	  count = 0,
	  maxStars = 1314;//星星数量
	
	var canvas2 = document.createElement('canvas'),
	  ctx2 = canvas2.getContext('2d');
	canvas2.width = 100;
	canvas2.height = 100;
	var half = canvas2.width / 2,
	  gradient2 = ctx2.createRadialGradient(half, half, 0, half, half, half);
	gradient2.addColorStop(0.025, '#CCC');
	gradient2.addColorStop(0.1, 'hsl(' + hue + ', 61%, 33%)');
	gradient2.addColorStop(0.25, 'hsl(' + hue + ', 64%, 6%)');
	gradient2.addColorStop(1, 'transparent');
	
	ctx2.fillStyle = gradient2;
	ctx2.beginPath();
	ctx2.arc(half, half, half, 0, Math.PI * 2);
	ctx2.fill();
	
	// End cache
	
	function random(min, max) {
	  if (arguments.length < 2) {
	    max = min;
	    min = 0;
	  }
	
	  if (min > max) {
	    var hold = max;
	    max = min;
	    min = hold;
	  }
	
	  return Math.floor(Math.random() * (max - min + 1)) + min;
	}
	
	function maxOrbit(x, y) {
	  var max = Math.max(x, y),
	    diameter = Math.round(Math.sqrt(max * max + max * max));
	  return diameter / 1.5;
	  //星星移动范围，值越大范围越小，
	}
	
	var Star = function() {
	
	  this.orbitRadius = random(maxOrbit(w, h));
	  this.radius = random(60, this.orbitRadius) / 8; 
	  //星星大小
	  this.orbitX = w / 2;
	  this.orbitY = h / 2;
	  this.timePassed = random(0, maxStars);
	  this.speed = random(this.orbitRadius) / 50000000; //移动速度
	  this.alpha = random(2, 10) / 10;
	
	  count++;
	  stars[count] = this;
	}
	
	Star.prototype.draw = function() {
	  var x = Math.sin(this.timePassed) * this.orbitRadius + this.orbitX,
	    y = Math.cos(this.timePassed) * this.orbitRadius + this.orbitY,
	    twinkle = random(10);
	
	  if (twinkle === 1 && this.alpha > 0) {
	    this.alpha -= 0.05;
	  } else if (twinkle === 2 && this.alpha < 1) {
	    this.alpha += 0.05;
	  }
	
	  ctx.globalAlpha = this.alpha;
	  ctx.drawImage(canvas2, x - this.radius / 2, y - this.radius / 2, this.radius, this.radius);
	  this.timePassed += this.speed;
	}
	
	for (var i = 0; i < maxStars; i++) {
	  new Star();
	}
	
	function animation() {
	  ctx.globalCompositeOperation = 'source-over';
	  ctx.globalAlpha = 0.9; //尾巴
	  ctx.fillStyle = 'hsla(' + hue + ', 64%, 6%, 2)';
	  ctx.fillRect(0, 0, w, h)
	
	  ctx.globalCompositeOperation = 'lighter';
	  for (var i = 1, l = stars.length; i < l; i++) {
	    stars[i].draw();
	  };
	
	  window.requestAnimationFrame(animation);
	}
	
	animation();
	
}

</script>
</body>
</html>
<?php

?>
