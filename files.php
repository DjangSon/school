<?php
	//加载数据库配置文件
	require './inc/config.php';
	require './inc/loading.php';
	
	
	if (empty($_COOKIE['username'])){
		alertAndLoading("请先登录", "index.php");
	}else{
		$username = base64_decode(base64_decode($_COOKIE['username']));
		$path="uploads/";        //上传路径
		$datas = $database -> select("users", "*",[
				"username" => base64_decode(base64_decode($_COOKIE['username']))
		]);
		
		foreach ($datas as $data){
			$flag = $data['flag'];
		}
		
		if(!file_exists($path)){
			//检查是否有该文件夹，如果没有就创建，并给予最高权限
			mkdir("$path", 0700);
		}
	    if(!empty($_FILES)){
	    	if($_FILES["file"]["error"] == 0){
	    		//将文件名字改为当前路径+上传时间+用户名+原文件名
	    		if($_FILES["file"]["name"]){
	    			$file1=$_FILES["file"]["name"];
	    			$able = pathinfo($file1)['extension'];
	    			$basename = pathinfo($file1)['basename'];
	    			$file2 = $path.date("Ymdhisa").'.'.$able;
	    			
	    		}
	    		if (!empty($_POST['title'])&&!empty($_POST[content])){
		    		move_uploaded_file($_FILES["file"]["tmp_name"],$file2);
	    			$database -> insert("article", [
	    					"author" => $username,
	    					"title" => $_POST['title'],
	    					"content" => $_POST['content'],
	    					"datetime" => date("Y/m/d H:i:s"),
	    					"flag" => $flag,
	    					"files" => $file2,
	    					"filename" => $basename
	    			]);
		    		alertAndLoading("上传成功", "index.php");
	    		}
	    	}else {
	    		if (!empty($_POST['title'])&&!empty($_POST[content])){
		    		$database -> insert("article", [
	    					"author" => $username,
	    					"title" => $_POST['title'],
	    					"content" => $_POST['content'],
	    					"datetime" => date("Y/m/d H:i:s"),
	    					"flag" => $flag,
	    			]);
		    		alertAndLoading("发布成功", "index.php");
	    		}
	    	}
	    }
	}
?>
<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="UTF-8" />
		<title>逸学·你的专属学习网站</title>
		<link rel="stylesheet" href="index.css" />
		<script src="jquery-1.7.2.min.js"></script>
		<script>
			$(function() {
				$('.login').click(function(event) {
					$('.bg').fadeIn(200);
					$('.case').fadeIn(400);
				});
				$('.close').click(function(event) {
					$('.bg').fadeOut(800);
					$('.case').fadeOut(800);
				});
				$('.teabtn').click(function(event) {
					$('.bg').fadeIn(200);
					$('.teacase').fadeIn(400);
				});
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
				$('.teabtn').click(function(event) {
					$('.bgs').fadeIn(200);
					$('.teacases').fadeIn(400);
				});
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
			})
		</script>
	</head>

	<body>
		<div class="header">
			<div class="header-cen">
				<!--<a href="register.html" class="register">注册</a>-->
			<?php 
			
				echo '
				<label style="margin-left:300px;">欢迎，'.$username.'登录！</label>
				<a href="index.php?act=deleteCookie">退出</a>';
			?>
				<!--注册-->
				<div class="bgs"></div>
				<div class="cases">
					<div class="close"></div>
					<form action="" method="" class="form">
						<h3>用户名</h3>
						<input type="text" name="" class="log-input" />
						<h3>邮 &nbsp;&nbsp;&nbsp;箱 </h3>
						<input type="text" name="" class="log-input" />
						<h3>密 &nbsp;&nbsp;&nbsp;码</h3>
						<input type="password" name="" class="log-input" />
						<input type="submit" value="注&nbsp;&nbsp;&nbsp;册" class="log-btn" />
					</form>
				</div>

				<!--登录-->
				<div class="bg"></div>
				<div class="case">
					<div class="close"></div>
					<form action="" method="" class="form">
						<h3>用户名</h3>
						<input type="text" name="" class="log-input" />
						<h3>密 &nbsp;&nbsp;&nbsp;码</h3>
						<input type="password" name="" class="log-input" />
						<h3>角 &nbsp;&nbsp;&nbsp;色</h3>
						<select name="" id="" class="log-input">
							<option value="">管理员</option>
							<option value="">教师</option>
							<option value="">学生</option>
						</select>
						<input type="submit" value="登&nbsp;&nbsp;&nbsp;录" class="log-btn" />
					</form>
					<a href="register.html" class="lo-re">没有账号？立即注册</a>
				</div>

				<h1></h1>
				<p>你</p>
				<p>的</p>
				<p>专</p>
				<p>属</p>
				<p>学</p>
				<p>习</p>
				<p>网</p>
				<p>站</p>
			</div>
		</div>
	<form method="post" action="" enctype="multipart/form-data">
		<div style="text-align: center;color: #FFFFFF;background: url(img/banner1.png) no-repeat;filter:Alpha(opacity=50);margin-left: 100px;height: 800px;padding-top: 80px;">
			<div style="width: 600px;height: 300px;background-color: #FFFFFF;margin:auto;padding-top: 50px;color: #444;">
			<label>请填写标题:</label>
				<input type="text" name="title" style="width: 274px;height: 22px;" />
			<div>
				<label class="teacase-dis teacase-tex">内容:</label>
				<textarea name="content" id="" cols="43" rows="7"></textarea>
			</div>
			<div class="teaup">
				<label class="teacase-dis" style="margin-left: 3em;">上传:</label>
			
			 	<input type="file" name="file" id="filename" class="student-img1" />
			</div>
			<input type="submit" value="发&nbsp;&nbsp;&nbsp;布" style="border: 1px solid #99D3F5;border-radius: 4px;width: 60px;height: 28px;background-color: #D0EEFF;color: #1E88C7;" />
			</div>
		</div>
	</form>
</body>

</html>
