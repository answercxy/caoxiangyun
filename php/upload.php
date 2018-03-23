<?php
	session_start();
	//if(($_FILES["file"]["type"]=="image/gif")||($_FILES["file"]["type"]=="image/jpg")||($_FILES["file"]["type"]=="image/jpeg")||($_FILES["file"]["type"]=="image/png"))//判断文件是否为以上几种格式的图片
		//{
			if($_FILES["file"]["error"]>0)//发生错误
			{
				echo '{"error":"上传文件出现错误"}';//输出错误信息
			}
			else
			{
				include(dirname(__FILE__)."/common/config.php");
				include(CLASS_PATH."db.class.php");
		
				$db=new db();
				//文件上传
				$name=$_FILES["file"]["name"];//上传文件名称
				$type=$_FILES["file"]["type"];//上传文件类型
				$size=($_FILES["file"]["size"]/1024/1024)."";//上传文件大小mb
				$showName=$_FILES["file"]["tmp_name"];//上传文件别名
				if(file_exists("../uploads/".$_FILES["file"]["name"]))//判断文件是否已经存在
				{
					echo '{"error":'.$size.'}';
				}
				else 
				{
					if(!file_exists("../uploads/"))
					{
						mkdir("../uploads");
					}
					$now=date("YmdHis",time());
					$date=substr($now,0,4)."-".substr($now,4,2)."-".substr($now,6,2)." ".substr($now,8,2).":".substr($now,10,2).":".substr($now,12,2);
					$end=substr($_FILES["file"]["name"],strrpos($_FILES["file"]["name"],"."));
					$xiyu="xiyu".rand(0,100).$now;
					list($nneed,$need)=explode(".",$_FILES["file"]["name"]);
					move_uploaded_file($_FILES["file"]["tmp_name"],"../uploads/".$xiyu.$end);//上传开始
					//rename("uploads/".$_FILES["file"]["name"],$xiyu);
					
					//信息存入数据库
					$strsql="insert into file(name,userId,date,size,showName) values('".$name."',".$_SESSION["user_id"].",'".$date."',".$size.",'".$xiyu.$end."')";
					//$strsql="insert into file(name,userId,date,size,showName) values('123',1,'1999-08-09 03:07:20',123,'123')";
					$result=$db->Query($strsql,0);	
					
					if($result)
					{
						echo '{
						  "code": 0
						  ,"msg": ""
						  ,"data": {
						    "src": "caoxiangyun/uploads/'.$xiyu.$end.'"
						  }
						}';
					}
					else
					{
						echo "{'error':12}";
					}			
				}
			}
		//}
?>