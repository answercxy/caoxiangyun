<?php
	
	include(dirname(__FILE__)."/common/config.php");
	include(CLASS_PATH."db.class.php");
		
	$db=new db();
	//获取总数据量
	$sql="select count(*) as amount from caoxiangyun.file";
	$row=$db->Query($sql);
	$amount=$row[0];
	//请求的页面编号
	$page = $_GET["page"];
	//请求的数据数量
	$limit = $_GET["limit"];
	$pO = Array ('code' => 0 ,'msg' => '' ,'count' => $amount); 
	if($amount){
		$sql="select * from caoxiangyun.file order by id desc limit ".($page-1)*$limit.",".$limit;
		$result=$db->Query($sql,0);
		while($row=mysqli_fetch_row($result))
		{
			$sql="select name from caoxiangyun.user where id=".$row[2];
			$userName=$db->Query($sql,1)[0];
			$r=Array('id'=>$row[0],'name'=>$row[1],'userId'=>$row[2],'date'=>$row[3],'size'=>$row[4],'showName'=>$row[5],'userName'=>$userName);
			$rowset[]=$r;
		}
		$pO=Array('data' => $rowset)+$pO;
		$pO = json_encode($pO);
		print_r($pO);
	}
?>