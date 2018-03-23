<?php
	//函数原型：string iconv ( string in_charset, string out_charset, string str )
	header("Content-type=text/html;charset=utf-8");
	if(isset($_GET["action"]))		//是否单击下载按钮
	{
		$file_name=trim($_GET["fname"]);
		$dir_name="../uploads/";
		//$file_url=$dir_name.$file_name;
		$file_url=iconv("utf-8","gbk",$dir_name.$file_name);//有中文名字的图片必须先转换为gbk编码，否则无法识别
		if(!file_exists($file_url))
		{
			
			echo "抱歉，该文件已丢失！！！";
			//echo $file_url;
			exit;
		}
		
		else
		{
			iconv("gbk","utf-8",$file_url);
			$file=fopen($file_url,"r");
			header("content-type:application/octet-stream");
			header("Accept-Ranges:bytes");
			header("Accept-Length:".filesize($file_url));
			header("Content-Disposition:attachment;filename=".$file_name);
			echo fread($file,filesize($file_url));
			fclose($file);
			
			exit;
		}
	}
?>