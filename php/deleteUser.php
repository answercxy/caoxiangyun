<?php
	if(isset($_POST['id']))
	{
		include(dirname(__FILE__)."/common/config.php");
		include(CLASS_PATH."db.class.php");		
		
		$db=new db();
		$id=$_POST["id"];
		/*if(!is_numeric($phone))
		{
			echo "unexist";
			return;
		}*/
		$strsql="DELETE FROM user WHERE id = '".$id."' ";
		$result=$db->Query($strsql,0);
		if($result)
		{
			echo "success";
		}
		else
		{
			echo "false";
		}
	}
	else
	{
		echo "用户不存在";
	}
?>