<?php
	//加载数据库配置文件
	require './inc/config.php';
	require './inc/loading.php';
	
	//教师文章
	$datas3 = $database -> select("article", "*",[
			"flag" => 1,
			"ORDER" => "datetime DESC"
	]);
	
	//学生文章
	$datas4 = $database -> select("article", "*",[
			"flag" => 0,
			"ORDER" => "datetime DESC"
	]);
	
	if (!empty($_COOKIE['username'])){
		$datas5 = $database -> select("users", "*" );
		foreach ($datas5 as $data5){
			if ($data5['username'] == base64_decode(base64_decode($_COOKIE['username']))){
				$flag = $data5['message'];
				break;
			}
		}
		if ($flag == 1){
			$datas6 = $database -> select("chat", "*",[
					"AND" => [
							"towho" => base64_decode(base64_decode($_COOKIE['username'])),
							"flag" => 1
					]
			]);
			
		}
		
	}
	
	if (!empty($_REQUEST['act'])){
		$act = $_REQUEST['act'];
		if ($act == "deleteCookie"){
			setcookie('username',base64_decode(base64_decode($_COOKIE['username'])), time()-3600, '/' );
			if (!empty($_COOKIE['reciverName'])){
				setcookie('reciverName',base64_decode(base64_decode($_COOKIE['reciverName'])), time()-3600, '/' );
			}
			alertAndLoading("退出成功", "index.php");
		}
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			if ($act == "register"){
				$database->insert("users",[
						"username" => $_POST['username'],
						"email" => $_POST['email'],
						"password" => md5($_POST['password']),
						"regTime" => date("Y/m/d H:i:s")
				]);
				alertAndLoading("注册成功", "index.php");
			}elseif ($act == "login"){
				if ($_POST['Loginidentity'] == "1"){
					$Loginidentity = 1;
				}elseif ($_POST['Loginidentity'] == "0"){
					$Loginidentity = 0;
				}
				$datas = $database -> select("users", "*",[
						"AND" => [
								"username" => $_POST['username'],
								"flag" => $Loginidentity
						]
				]);
				if (empty($datas)){
					alertAndLoading("不存在该用户", "index.php");
				}
				foreach ($datas as $data){
					$password = $data['password'];
				}
				if ($password == md5($_POST['password'])){
					$database -> update("users",[
							"online" => 1
					],[
							"username" => $_POST['username']
					]);
					setcookie('username',base64_encode(base64_encode($_POST['username'])), time()+3600, '/' );
					alertAndLoading("登陆成功", "index.php");
				}else {
					alertAndLoading("密码错误，请重新登陆", "index.php");
				}
			}
		}
	}
	
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<title>
			逸学·你的专属学习网站
		</title>
		<link rel="stylesheet" href="index.css" />
		<script src="jquery-1.7.2.min.js"></script>
		<script>$(function() {
	$('.login').click(function(event) {
		$('.bg').fadeIn(200);
		$('.case').fadeIn(400);
	});
	$('.close').click(function(event) {
		$('.bg').fadeOut(800);
		$('.case').fadeOut(800);
	});
// 	$('.teabtn').click(function(event) {
// 		$('.bg').fadeIn(200);
// 		$('.teacase').fadeIn(400);
// 	});
	$('.teaclose').click(function(event) {
		$('.bg').fadeOut(800);
		$('.teacase').fadeOut(800);
	});
	$('.stubtn').click(function(event) {
		$('.bg').fadeIn(200);
		$('.stucase').fadeIn(400);
	});
	$('.stuclose').click(function(event) {
		$('.bg').fadeOut(800);
		$('.stucase').fadeOut(800);
	});
})
$(function() {
	$('.registers').click(function(event) {
		$('.bgs').fadeIn(200);
		$('.cases').fadeIn(400);
	});
	$('.close').click(function(event) {
		$('.bgs').fadeOut(800);
		$('.cases').fadeOut(800);
	});
// 	$('.teabtn').click(function(event) {
// 		$('.bgs').fadeIn(200);
// 		$('.teacases').fadeIn(400);
// 	});
	$('.teaclose').click(function(event) {
		$('.bgs').fadeOut(800);
		$('.teacases').fadeOut(800);
	});
	$('.stubtn').click(function(event) {
		$('.bgs').fadeIn(200);
		$('.stucases').fadeIn(400);
	});
	$('.stucloses').click(function(event) {
		$('.bgs').fadeOut(800);
		$('.stucases').fadeOut(800);
	});
})</script>
	</head>
	<body>
		<div class="header">
			<div class="header-cen">
				<!--<a href="register.html" class="register">注册</a>-->
				<?php
				if (!empty($_COOKIE['username'])){
				$datas2  = $database -> select("users", "*",[
				"username" => base64_decode(base64_decode($_COOKIE['username']))
				]);
				foreach ($datas2 as $data2){
				$identity = $data2['flag'];
				}
				echo '<label style="margin-left:300px;">欢迎，<b style="vertical-align: top;">'.base64_decode(base64_decode($_COOKIE['username'])).'</b>！</lable>
					<lable style="display:inline-block;vertical-align: top;">
					<ul class="massage">';
				if (!empty($datas6)){
					echo '<li> <a href="" style="color:red;">您有新消息！</a> 
						<ul class="massage1">';
					foreach ($datas6 as $data6){
						echo '
							<li>
							<a href="chat.php?authorname='.$data6['fromwho'].'">来自'.$data6['fromwho'].'的消息</a>
							</li>';
					}
				}else{
					echo '<li> <a href="" style="color:#000;">暂无消息！</a> ';
				}
				echo '
					</ul>
					</li>
					</ul>
					</label>
					<a href="index.php?act=deleteCookie">退出</a>';
				}else {
				echo '<button class="registers" style="background-color: #396717;color: #FFFFFF;">注册</button>
				<button class="login">登录</button>';
				}
				?>
				<!--注册-->
				<div class="bgs">
				</div>
				<div class="cases">
					<div class="close">
					</div>
					<form action="index.php?act=register" method="post" class="form">
						<h3>
							用户名
						</h3>
						<input type="text" name="username" class="log-input" />
						<h3>
							邮 &nbsp;&nbsp;&nbsp;箱
						</h3>
						<input type="email" name="email" class="log-input" />
						<h3>
							密 &nbsp;&nbsp;&nbsp;码
						</h3>
						<input type="password" name="password" class="log-input" />
						<input type="submit" value="注&nbsp;&nbsp;&nbsp;册" class="log-btn"/>
					</form>
				</div>
				<!--登录-->
				<div class="bg">
				</div>
				<div class="case">
					<div class="close">
					</div>
					<form action="index.php?act=login" method="post" class="form">
						<h3>
							用户名
						</h3>
						<input type="text" name="username" class="log-input"  />
						<h3>
							密 &nbsp;&nbsp;&nbsp;码
						</h3>
						<input type="password" name="password" class="log-input"  />
						<h3>
							角 &nbsp;&nbsp;&nbsp;色
						</h3>
						<select name="Loginidentity" id="" class="log-input" >
							<option value="1">
								教师
							</option>
							<option value="0">
								学生
							</option>
						</select>
						<input type="submit" value="登&nbsp;&nbsp;&nbsp;录" class="log-btn" />
					</form>
				</div>
				<!-- <ul class="nav">
				<li class="current"><a href="">网站首页</a></li>
				<li><a href="">教学互动</a></li>
				<li><a href="">学生天地</a></li>
				</ul> -->
				<h1>
				</h1>
				<p>
					你
				</p>
				<p>
					的
				</p>
				<p>
					专
				</p>
				<p>
					属
				</p>
				<p>
					学
				</p>
				<p>
					习
				</p>
				<p>
					网
				</p>
				<p>
					站
				</p>
				<div style="clear:both;"></div>
			</div>
		</div>
		<div class="banner">
		</div>
		<div class="teach">
			<h2>
				·教学内容·
			</h2>
			<div class="content">
				<?php
				if (!empty($datas3)) {
					$flag2 = 0;
					foreach ($datas3 as $data3) {
						$datetime[$flag2] = $data3['datetime'];
						$ID[$flag2] = $data3['ID'];
						$title[$flag2] = $data3['title'];
						$flag2++;
					}
				}
				if (empty($_GET['teacherpage'])){
					for ($i = 0;$i < 5;$i ++){
						if ($flag2<=$i){
							break;
						}
						echo '<p><span>' . $datetime[$i] . '</span><a href="article.php?id='.$ID[$i].'">' . $title[$i] . '</a></p>';
					}
				}elseif ($_GET['teacherpage']==2){
					if ($flag2>5){
						for ($i = 5;$i < 10;$i ++){
							if ($flag2<=$i){
								break;
							}
							echo '<p><span>' . $datetime[$i] . '</span><a href="article.php?id='.$ID[$i].'">' . $title[$i] . '</a></p>';
						}
					}else {
						echo '暂无文章';
					}
				}elseif ($_GET['teacherpage']==3){
					if ($flag2>10){
						for ($i = 10;$i < 15;$i ++){
							if ($flag2<=$i){
								break;
							}
							echo '<p><span>' . $datetime[$i] . '</span><a href="article.php?id='.$ID[$i].'">' . $title[$i] . '</a></p>';
						}
					}else {
						echo '暂无文章';
					}
				}
				?>
			</div>
			<?php 
				if (!empty($_COOKIE['username'])){
					if ($identity == 1){
						echo '<a href="files.php" class="teabtn" target="_blank" style="line-height: 28px;">
							发布/上传更多内容
							</a>';
					}
				}
			?>
			
			<div class="page">
            <a href=""><span class="last"><<</span></a>
            <ul class="number">
                <li class="num-cen"><a href="index.php">1</a></li>
                <li class="num-cen"><a href="index.php?teacherpage=2">2</a></li>
                <li class="num-cen"><a href="index.php?teacherpage=2">3</a></li>
            </ul>
            <a href=""><span class="next">>></span></a>
        </div>
		</div>
		
		<div class="teach" style="background: url(img/student.jpg) no-repeat;">
			<h2 style="color: #FFFFFF;">
				·学生天地·
			</h2>
			<div class="content" style="color: #FFFFFF;">
				<?php
				if (!empty($datas4)) {
					$flag3 = 0;
					foreach ($datas4 as $data4) {
						$datetime2[$flag3] = $data4['datetime'];
						$ID2[$flag3] = $data4['ID'];
						$title2[$flag3] = $data4['title'];
						$flag3++;
						
					}
					if (empty($_GET['studentpage'])){
						for ($i = 0;$i < 5;$i ++){
							if ($flag3<=$i){
								break;
							}
							echo '<p><span>' . $datetime2[$i] . '</span><a href="article.php?id='.$ID2[$i].'" style="color: #FFFFFF;">' . $title2[$i] . '</a></p>';
						}
					}elseif ($_GET['studentpage']==2){
						if ($flag3>5){
							for ($i = 5;$i < 10;$i ++){
								if ($flag3<=$i){
									break;
								}
								echo '<p><span>' . $datetime2[$i] . '</span><a href="article.php?id='.$ID2[$i].'" style="color: #FFFFFF;">' . $title2[$i] . '</a></p>';
							}
						}else {
							echo '暂无文章';
						}
					}elseif ($_GET['studentpage']==3){
						if ($flag3>10){
							for ($i = 10;$i < 15;$i ++){
								if ($flag3<=$i){
									break;
								}
								echo '<p><span>' . $datetime2[$i] . '</span><a href="article.php?id='.$ID2[$i].'" style="color: #FFFFFF;">' . $title2[$i] . '</a></p>';
							}
						}else {
							echo '暂无文章';
						}
					}
				}
				?>
				<p>
			</div>
			<?php 
			if (!empty($_COOKIE['username'])){
				if ($identity == 0){
					echo '<a href="files.php" class="teabtn" target="_blank" style="line-height: 28px;">
						发布/上传更多内容
						</a>';
				}
			}
			?>
			<div class="page">
            <a href=""><span class="last"><<</span></a>
            <ul class="number">
                <li class="num-cen"><a href="index.php">1</a></li>
                <li class="num-cen"><a href="index.php?studentpage=2">2</a></li>
                <li class="num-cen"><a href="index.php?studentpage=2">3</a></li>
            </ul>
            <a href=""><span class="next">>></span></a>
        </div>
		</div>
		</div>
		</div>
		</div>
		<div class="copy">
			<p>
				Copyright © 2012-2016 YIXUE 逸学网<span>豫ICP备12002058号</span>
			</p>
		</div>
	</body>
</html>
