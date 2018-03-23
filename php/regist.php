<?php
	if(isset($_POST["id"])){
		include(dirname(__FILE__)."/common/config.php");
		include(CLASS_PATH."db.class.php");
		
		$db=new db();
		$now=date("YmdHis",time());
		$date=substr($now,0,4)."-".substr($now,4,2)."-".substr($now,6,2)." ".substr($now,8,2).":".substr($now,10,2).":".substr($now,12,2);
		if($_POST["id"]==0){//新增用户
			$strsql="insert into user(name,password,root,date) values('".$_POST["name"]."','".$_POST["password"]."',0,'".$date."')";
		}else{//修改用户
			$strsql="UPDATE user SET password = '".$_POST["password"]."' WHERE id = ".$_POST["id"];
		}
		$result=$db->Query($strsql,0);
		if($result){
			echo "success";
		}else{
			echo "false";
		}
	}else{
		echo "信息错误";
	}
?>