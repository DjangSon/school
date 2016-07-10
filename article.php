<?php
	//加载数据库配置文件
	require './inc/config.php';
	require './inc/loading.php';
	
	if (empty($_COOKIE['username'])){
		alertAndLoading("请先登录", "index.php");
	}
	$username = base64_decode(base64_decode($_COOKIE['username']));
	if (!empty($_GET['id'])){
		$datas = $database -> select("article", "*",[
				"ID" => $_GET['id']
		]);
		if (!empty($datas)){
			foreach ($datas as $data){
				$author = $data['author'];
				$title = $data['title'];
				$content = $data['content'];
				$datetime = $data['datetime'];
				$files = $data['files'];
				$filename = $data['filename'];
			}
		}
	}else {
		alertAndLoading("请选择文章", "index.php");
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
				<?php 
			
				echo '<label style="margin-left:300px;line-height:64px;">欢迎，<b>'.base64_decode(base64_decode($_COOKIE['username'])).'</b>！</label>
				<a href="index.php?act=deleteCookie">退出</a>';
			?>
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
	    <div style="text-align: center;background: url(img/banner1.png) no-repeat;height: 800px;margin-left: 100px;padding-top: 100px;">
	    	<div style="width: 800px;padding:15px;background-color: #fff;margin:0 auto;">
	    	<?php 
	    	if (!empty($filename)){
		    	echo '
		    		<label style="font-size: 18px;font-weight: 800;">'.$title.'</label>
			    	<p style="padding: 10px;color: #FF6A6A;"><a href="chat.php?authorname='.$data['author'].'" style="margin-right: 30px;color: #FF6A6A;">'.$author.'</a>'.$datetime.'</p>
			    	<p style="text-indent: 2em;height: 360px;">'.$content.'
					</p><b>资料下载：</b><a href="'.$files.'"><span style="text-decoration:underline">'.$filename.'</span></a>';
	    	}else {
	    		echo '
		    		<label style="font-size: 18px;font-weight: 800;">'.$title.'</label>
			    	<p style="padding: 10px;color: #FF6A6A;"><a href="chat.php?authorname='.$data['author'].'" style="margin-right: 30px;color: #FF6A6A;">'.$author.'</a>'.$datetime.'</p>
			    	<p style="text-indent: 2em;height: 360px;">'.$content;
	    	}
		    ?>
	    	
	    	</div>
	    </div>
</body>
</html>