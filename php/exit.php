<?php
	session_start();
	if(isset($_SESSION["c_root"]))
	{
		//session_destroy();
		session_unset();//退出登录
		header("Location: ../login.php");
	}
	else
	{
		header("Location: ../index.php");
	}
?>