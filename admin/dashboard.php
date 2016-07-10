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

	$datas = $database->select("article", "*",[
			"ORDER" => "datetime DESC"
	]);
	
	//若url传递$_GET参数id，则判断是否有action请求
	//若有请求，则判断是否为删除文章的请求，若是，则删除改文章，并弹窗然后跳转回本页面
	if (!empty($_GET['id'])){
		if (!empty($_REQUEST['act'])){
			$act = $_REQUEST['act'];
			if ($act == "deleteArticle"){
				$database -> delete("article", [
						"ID" => $_GET['id']
				]);
				alertAndLoading("删除成功", "dashboard.php");
			}
		}
	}
	
?>

<!DOCTYPE html>
<html lang="">
<head>
	<meta charset="utf-8">
	<title>文章页</title>
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
	<h1><strong>文章管理</strong></h1>
	<!--<input type="text" value="查询..." />-->
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
		<li class="section"><a href="dashboard.php"><span style="margin-left: 15px;"></span> 文章</a></li>
		<li><a href="users.php"><span style="margin-left: 15px;"></span>  用户</a></li>
		<li><a href="addTeachers.php"><span style="margin-left: 15px;"></span>  教师</a></li>
		<li><a href="admin_manage.php"><span style="margin-left: 15px;"></span>  管理员管理</a></li>
	</ul>
</nav>

<section class="content" style="margin-top: 10px;">
	<section class="widget">
		<header>
			<span class="icon">&#128196;</span>
			<hgroup>
				<h1>文章管理</h1>
				<h2>欢迎来到文章页！</h2>
			</hgroup>
		</header>
		<div class="content">
			<table id="myTable" border="0" width="100">
				<thead>
					<tr>
						<th>标题</th>
						<th>作者</th>
						<th>日期</th>
						<th>操作</th>
					</tr>
				</thead>
					<tbody>
						<?php 
						//循环取出每篇文章的id，作者，发表日期，输出HTML代码，并将值插入在HTML代码中
						foreach ($datas as $data){
							echo '
							<tr>
								<td><a href="../read.php?id='.$data['ID'].'" target="_blank"><span class="article">'.$data['title'].'</span></a></td>
								<td>'.$data['title'].'</td>
								<td>'.$data['datetime'].'</td>
								<td>
									<a href="dashboard.php?act=deleteArticle&id='.$data['ID'].'">删除</a>
								</td>
							</tr>
							';
						}
						?>
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