<?php 
	//加载数据库配置文件。
	require '../inc/config.php';
	//加载跳转页面函数。
	require '../inc/loading.php';
	//验证管理员cookie
	if (empty($_COOKIE['admin'])){
		alertAndLoading("非管理员，请正确登录", "index.php");
	}
	$adminname = base64_decode(base64_decode($_COOKIE['admin']));
	//在数据库(blog.yonghu)中查询数据，并按注册时间排序
	$datas = $database->select("users", "*",[
			"ORDER" => "regTime DESC"
	]);
	
	//若url有传递参数，则判断是否有action，若有，则将action名赋予变量$act，若action为删除用户
	//则从数据库(blog.yonghu)删除该用户，提示删除成功，跳转回本页；
	//若action为添加黑名单，则将数据库(blog.yonghu)的zhuangtai置1，提示并跳转回本页
	//若action为添加白名单，则将数据库(blog.yonghu)的zhuangtai置0，提示并跳转回本页
	if (!empty($_GET['username'])){
		if (!empty($_REQUEST['act'])){
			$act = $_REQUEST['act'];
			if ($act == "delete"){
				$database -> delete("users", [
						"username" => $_GET['username']
				]);
				alertAndLoading("删除成功", "users.php");
			}
		}
	}
?>

<!DOCTYPE html>
<html lang="">
<head>
	<meta charset="utf-8">
	<title>用户管理</title>
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
	<h1><strong>用户管理</strong></h1>
	<!--<input type="text" value="查询" />-->
</header>
<section class="user" style="padding-top: 20px;">
	<div class="profile-img" style="float: left;">
 		<p>欢迎回来<?php echo $adminname;?>！</p>						<!--将JOHN修改成当前登入用户 -->
	</div>
    <form action="admin_manage.php?act=deleteCookie" method="post">
    	<button class="red" >安全退出</button>
    </form>		<!--删除cookies -->
</section>
</div>
<nav>
	<ul>
		<li><a href="dashboard.php"><span style="margin-left: 15px;"></span>  文章</a></li>
		<li class="section"><a href="users.php"><span style="margin-left: 15px;"></span>  用户</a></li>
		<li><a href="addTeachers.php"><span style="margin-left: 15px;"></span>  教师</a></li>
		<li><a href="admin_manage.php"><span style="margin-left: 15px;"></span>  管理员管理</a></li>
	</ul>
</nav>
<section class="content" style="margin-top: 20px;">
	<section class="widget">
		<header>
			<span class="icon">&#128100;</span>
			<hgroup>
				<h1>用户管理</h1>
				<h2>欢迎来到用户管理页！</h2>
			</hgroup>
		</header>
		<div class="content">
			<table id="myTable" border="0" width="100">
				<thead>
					<tr>
						<th class="avatar">名字</th>
						<th>邮箱</th>
						<th>注册时间</th>
						<th>身份</th>
						<th>操作</th>
					</tr>
				</thead>
					<tbody>
						<tr>
					<?php 
						if (!empty($datas)){
							//循环取出数据库(blog.yonghu)中的用户的资料，输出HTML代码，并插入HTML中
							foreach ($datas as $data){
								if ($data['flag'] == 0){
									$identity = "学生";
								}else{
									$identity = "教师";
								}
								echo '<tr>
										<td class="avatar"><img src="images/uiface1.png" alt="" height="40" width="40" />'.$data['username'].'</td>
										<td>'.$data['email'].'</td>
										<td>'.$identity.'</td>
										<td>'.$data['regTime'].'</td>
										<td>
											<a href="users.php?act=delete&username='.$data['username'].'">删除</a>
										</td>
									 </tr>';
							}
						}
					?>
						</tr>
					</tbody>
				</table>
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