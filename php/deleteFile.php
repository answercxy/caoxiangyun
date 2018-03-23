<?php
	if(isset($_POST['id']))
	{
		$id=$_POST["id"];
		$fileName="../uploads/".$_POST["showName"];
		/*if(!is_numeric($phone))
		{
			echo "unexist";
			return;
		}*/
		include(dirname(__FILE__)."/common/config.php");
		include(CLASS_PATH."db.class.php");		
		
		$db=new db();
		$strsql="DELETE FROM file WHERE id = '".$id."' ";
		$result=$db->Query($strsql,0);
		if($result)
		{//到这里数据库已经成功删除了
			if(file_exists($fileName))//判断文件是否已经存在
			{
				unlink($fileName);
				echo "success";
			}
		}
		else
		{
			echo "false";
		}
	}
	else
	{
		echo "文件不存在";
	}
?>