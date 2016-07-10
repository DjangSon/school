<!DOCTYPE html>
<html lang="">
<head>
	<meta charset="utf-8">
	<title>登录</title>
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<meta name="robots" content="" />
	<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0">
	<link rel="stylesheet" href="css/style.css" media="all" />
	<!--[if IE]><link rel="stylesheet" href="css/ie.css" media="all" /><![endif]-->
</head>
<body class="login">
	<section>
		<h1><strong>登</strong> 录</h1>
		<form method="post" >
			<input type="text" value="管理员" name="admin"/>
			<input value="Password" type="password" name="password"/>
			<button class="blue">登录</button>
		</form>
	</section>
<script src="js/jquery.min.js"></script>
<script type="text/javascript">
// Page load delay by Curtis Henson - http://curtishenson.com/articles/quick-tip-delay-page-loading-with-jquery/
$(function(){
	$('.login button').click(function(e){ 
		// Get the url of the link 
		var toLoad = $(this).attr('href');  
 
		// Do some stuff 
		$(this).addClass("loading"); 
 
			// Stop doing stuff  
			// Wait 700ms before loading the url 
			setTimeout(function(){window.location = toLoad}, 10000);	  
 
		// Don't let the link do its natural thing 
		e.preventDefault
	});
	
	$('input').each(function() {

       var default_value = this.value;

       $(this).focus(function(){
               if(this.value == default_value) {
                       this.value = '';
               }
       });

       $(this).blur(function(){
               if(this.value == '') {
                       this.value = default_value;
               }
       });

});
});
</script>
</body>
</html>
<?php 
	//加载数据库配置文件。
	require '../inc/config.php';
	//加载跳转页面函数。
	require '../inc/loading.php';
	
	//若存在cookie，则进入数据库(blog.guanli)查询是否存在该用户，若存在，则直接跳转进入管理员管理页面
	if (!empty($_COOKIE['admin'])){
		$datas = $database->select("admin", "*",[
				"yonghu" => base64_decode(base64_decode($_COOKIE['admin']))
		]);
		if (!empty($datas)){
			loading("admin_manage.php");
		}
	}
	
	//若有表单传递，则判断数据库(blog.guanli)中是否存在该用户，若存在，则判断取出用户的密码是否与输入的密码相同
	//若相同，则颁发cookie，并修改用户最近登陆时间和登录状态，跳转到管理员管理页面
	if ($_SERVER['REQUEST_METHOD'] == "POST"){
		$datas2 = $database->select("admin", "*", [
				"adminName" => $_POST['admin'],
		]);
		
		foreach ($datas2 as $data2){
			$password = $data2['password'];
		}

		if ($password == md5($_POST['password'])){
			setcookie('admin',base64_encode(base64_encode($_POST['admin'])),time()+3600,'/');
			$database -> update("admin", [
					"lastLogin" => date("Y-m-d H-i-s"),
					"state" => 1
			],[
					"adminName" => $_POST['admin']
			]);
			loading("admin_manage.php");
		}

	}
?>