<?php
	include(dirname(__FILE__)."/common/config.php");
	include(CLASS_PATH."db.class.php");
		
	$db=new db();
	//获取总数据量
	$sql="select count(*) as amount from caoxiangyun.user";
	$result=$db->Query($sql);
	$amount=$result[0];
	//请求的页面编号
	$page = $_GET["page"];
	//请求的数据数量
	$limit = $_GET["limit"];
	$pO = Array ('code' => 0 ,'msg' => '' ,'count' => $amount); 
	if($amount){
		$sql="select * from caoxiangyun.user order by id desc limit ".($page-1)*$limit.",".$limit;
		$result=$db->Query($sql,0);
		while($row=mysqli_fetch_row($result))
		{
			$r=Array('id'=>$row[0],'name'=>$row[1],'password'=>$row[2],'root'=>$row[3],'date'=>$row[4]);
			$rowset[]=$r;
		}
		$pO=Array('data' => $rowset)+$pO;
		$pO = json_encode($pO);
		print_r($pO);
	}
?>