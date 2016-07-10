<?php 
	//加载数据库配置文件。
	require '../inc/config.php';
	//加载跳转页面函数。
	require '../inc/loading.php';
	//验证管理员cookie
	if (empty($_COOKIE['admin'])){
		alertAndLoading("非管理员，请正确登录", "index.php");
	}
	//从Cookie获取admin的name，将其赋予变量$adminname
	$adminname = base64_decode(base64_decode($_COOKIE['admin']));
	
	//若前端发来表单，则判断是否有传递action，若有，则判断是哪种请求
	//若是addAdmin，则添加管理员，并加密传递的密码，弹窗添加成功，跳转回本页
	//若是deleteCookie,则删除Cookie，并将管理员状态置0，跳转回管理员登录页
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (!empty($_REQUEST['act'])){
			$act = $_REQUEST['act'];
			if ($act == "addTeacher"){
				$database -> insert("users", [
						"username" => $_POST['username'],
						"email" => $_POST['email'],
						"password" => md5($_POST['password']),
						"flag" => 1
				]);
				alertAndLoading("添加成功", "addTeachers.php");
			}
		}
	}
?>

<!DOCTYPE html>
<html lang="">
<head>
	<meta charset="utf-8">
	<title>教师管理</title>
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<meta name="robots" content="" />
	<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0">
	<link rel="stylesheet" href="css/style.css" media="all" />
	<!--[if IE]><link rel="stylesheet" href="css/ie.css" media="all" /><![endif]-->
</head>
<body>
<div class="testing">
<header class="main">
	<h1><strong>教师管理</strong></h1>

</header>
<section class="user" style="padding-top: 20px;">
	<div class="profile-img" style="float: left;">
		<p>欢迎回来<?php echo $adminname;?>！</p>
	</div>
	<form action="admin_manage.php?act=deleteCookie" method="post">
    	<button class="red" >安全退出</button>
    </form>
</section>
</div>
<nav>
	<ul>
		<li><a href="dashboard.php"><span style="margin-left: 15px;"></span>  文章</a></li>
		<li><a href="users.php"><span style="margin-left: 15px;"></span>  用户</a></li>
		<li class="section"><a href="addTeachers.php"><span style="margin-left: 15px;"></span>  教师</a></li>
		<li><a href="admin_manage.php"><span style="margin-left: 15px;"></span>  管理员管理</a></li>
	</ul>
</nav>

<section class="content" style="margin-top: 10px;">
	<section class="widget">
		<header>
			<span class="icon">&#128196;</span>
			<hgroup>
				<h1>教师管理</h1>
			</hgroup>
		</header>
		<div class="content">
			<form method="post" action="addTeachers.php?act=addTeacher">
				<div class="content">
					<p class="vote2"><b>添加教师</b></p>
					<p>用户名:<input class="vote1" type="text" name="username"/></p>
					<p>邮箱:<input class=""email"" type="email" name="email"/></p>
					<p>密&nbsp&nbsp&nbsp&nbsp码:<input class="vote1" type="password" name="password"/></p>
					<button class="blue vote-bt" type="submit">添&nbsp&nbsp&nbsp&nbsp加</button>
				</div>	
			</form>
		</div>
	</section>
</section>
<script src="js/jquery.min.js"></script>
<script src="js/jquery.wysiwyg.js"></script>
<script src="js/custom.js"></script>
<script src="js/cycle.js"></script>
<script src="js/jquery.checkbox.min.js"></script>
<script src="js/flot.js"></script>
<script src="js/flot.resize.js"></script>
<script src="js/flot-graphs.js"></script>
<script src="js/flot-time.js"></script>
<script src="js/cycle.js"></script>
<script src="js/jquery.tablesorter.min.js"></script>
</body>
</html>