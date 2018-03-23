<?php
	if(isset($_POST['login']) || isset($_POST['name']))
	{
		include(dirname(__FILE__)."/common/config.php");
		include(CLASS_PATH."db.class.php");
		
		$db=new db();
		$phone=$_POST["name"];
		/*if(!is_numeric($phone))
		{
			echo "unexist";
			return;
		}*/
		$strsql="select * from user where name='".$phone."'";
		$row=$db->Query($strsql);
		if($row)
		{
			echo "exist";
		}
		else
		{
			echo "unexist";
		}
	}
	else
	{
		echo "用户不存在";
	}
?>