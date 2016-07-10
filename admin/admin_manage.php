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

	//从数据库(blog.guanli)获取所有管理员的信息
	$datas = $database->select("admin", "*");
	
	//若url中有传递参数adminName,且有action请求，则将action请求名赋予变量$act
	//若请求为删除管理员，则删除url所传递的adminName参数，并弹窗提示删除成功，跳转回本页
	if (!empty($_GET['adminName'])){
		if (!empty($_REQUEST['act'])){
			$act = $_REQUEST['act'];
			if ($act == "deleteAdmin"){
				$database -> delete("admin", [
						"adminName" => $_GET['adminName']
				]);
				alertAndLoading("删除成功", "admin_manage.php");
			}
		}
	}
	
	//若前端发来表单，则判断是否有传递action，若有，则判断是哪种请求
	//若是addAdmin，则添加管理员，并加密传递的密码，弹窗添加成功，跳转回本页
	//若是deleteCookie,则删除Cookie，并将管理员状态置0，跳转回管理员登录页
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (!empty($_REQUEST['act'])){
			$act = $_REQUEST['act'];
			if ($act == "addAdmin"){
				$database -> insert("admin", [
						"adminName" => $_POST['adminName'],
						"password" => md5($_POST['password'])
				]);
				alertAndLoading("添加成功", "admin_manage.php");
			}elseif ($act == "deleteCookie"){
				setcookie('admin',base64_encode(base64_encode($adminname)),time()-3600,'/');
				$database -> update("admin", [
						"state" => 0
				],[
						"adminName" => $adminname
				]);
				loading('index.php');
			}
		}
	}
?>

<!DOCTYPE html>
<html lang="">
<head>
	<meta charset="utf-8">
	<title>管理员用户管理</title>
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
	<h1><strong>管理员用户管理</strong></h1>

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
		<li><a href="addTeachers.php"><span style="margin-left: 15px;"></span>  教师</a></li>
		<li class="section"><a href="admin_manage.php"><span style="margin-left: 15px;"></span>  管理员管理</a></li>
	</ul>
</nav>

<section class="content" style="margin-top: 10px;">
	<section class="widget">
		<header>
			<span class="icon">&#128196;</span>
			<hgroup>
				<h1>管理员用户管理</h1>
			</hgroup>
		</header>
		<div class="content">
			<table id="myTable" border="0" width="100">
				<thead>
					<tr>
						<th>管理员账号</th>
						<th>最近登录</th>
						<th>是否在线</th>
						<th>操作</th>
						
					</tr>
				</thead>
					<tbody>
			<?php 
						//设置标识
						$flag = 0;
						//从数据库(blog.guanli)取出管理员姓名(yonghu)，最近登陆时间(zuijindenglu)
						//若管理员状态(zhuangtai)为1，则设置变量值为“在线”，否则设置为离线
						//每次取值结束时，标识+1
						foreach ($datas as $data){
							$AdminName[$flag] = $data['adminName'];
							$lastLogin[$flag] = $data['lastLogin'];
							if ($data['state'] ==1){
								$online[$flag] = "在线";
							}else {
								$online[$flag] = "离线";
							}
							$flag = $flag + 1;
						}
						//根据标识$flag，循环取出每个管理员的值
						for ($i = 0;$i < $flag;$i++){
							echo '
						<tr>
							<td><span class="article">'.$AdminName[$i].'</span></td>
							<td><span class="article">'.$lastLogin[$i].'</span></td>
							<td><span class="article">'.$online[$i].'</span></td>
							<td>
								<a href="admin_manage.php?act=deleteAdmin&adminName='.$AdminName[$i].'">删除</a>
							</td>
						</tr>
						';
						}
						?>
					</tbody>
				</table>
			<form method="post" action="admin_manage.php?act=addAdmin">
				<div class="content">
					<p class="vote2"><b>添加管理员</b></p>
					<p>管理员:<input class="vote1" type="text" name="adminName"/></p>
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