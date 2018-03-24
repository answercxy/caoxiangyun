<?php
	if(isset($_POST["login"]))
	{
		include(dirname(__FILE__)."/common/config.php");
		include(CLASS_PATH."db.class.php");
		
		$db=new db();
		$name=$_POST["name"];
		$password=$_POST["password"];
		$strsql_1="select password from user where name='".$name."'";
		$strsql_2="select id from user where name='".$name."'";
		$strsql_3="select root from user where name='".$name."'";
		$result_1=$db->Query($strsql_1);
		$result_2=$db->Query($strsql_2);
		$result_3=$db->Query($strsql_3);
		if($result_1[0][0]==$password)
		{
			session_start();
			$_SESSION["c_root"]=$result_3[0][0];
			$_SESSION["name"]=$name;	
			$_SESSION["user_id"]=$result_2[0][0];
			echo "success";
		}
		else
		{
			echo "false";
		}
	}
	else
	{
		echo "黑客竟敢入侵我登录页面";
	}
?>