<?php
	require  'medoo.php';	//调用medoo框架
	
	//
	//----------以下配置Mysql数据库----------
	//
	$database = new medoo([
			// Mysql配置
			'database_type' => 'mysql',	//数据库格式
			'database_name' => 'school',	//数据库名
			'server' => '192.168.2.5',	//数据库ip
			'username' => 'root',		//数据库用户
			'password' => '123456',		//数据库密码
			'charset' => 'utf8',		//数据库编码
	]);
?>