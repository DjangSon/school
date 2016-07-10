<?php
	//加载数据库配置文件。
	require './inc/config.php';
	//加载跳转页面函数。
	require './inc/loading.php';
	
	if (empty($_COOKIE['username'])){
		alertAndLoading("请先登录", "index.php");
	}
	$username = base64_decode(base64_decode($_COOKIE['username']));
	if (empty($_COOKIE['reciverName'])){
		setcookie('reciverName',base64_encode(base64_encode($_GET['authorname'])),time()+3600,'/');
	}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no"/>
    <title>chat</title>
    <style type="text/css">
    	#message {border:1px #ccc solid;overflow-y:auto; overflow-x:hidden; position:relative;height:500px;width:100%}
    	input{width:100%; height:30px; padding:2px; line-height:20px; outline:none; border:solid 1px #CCC;}
    	button{float:right; width:80px; height:35px; font-size:18px;}
    	
    </style>
	    <script type="text/javascript" src="//cdn.bootcss.com/jquery/2.2.1/jquery.js"></script>
		<script type="text/javascript">
			updateMsg();
			function getNowFormatDate() {
			    var date = new Date();
			    var seperator1 = "-";
			    var seperator2 = ":";
			    var month = date.getMonth() + 1;
			    var strDate = date.getDate();
			    if (month >= 1 && month <= 9) {
			        month = "0" + month;
			    }
			    if (strDate >= 0 && strDate <= 9) {
			        strDate = "0" + strDate;
			    }
			    var currentdate = date.getFullYear() + seperator1 + month + seperator1 + strDate
			            + " " + date.getHours() + seperator2 + date.getMinutes()
			            + seperator2 + date.getSeconds();
			    return currentdate;
			}
            function updateMsg() {  
                $.get("chats.php?authorname=<?php echo $username;?>",function(result){$("span.msgContent:last").after(result)});
                setTimeout("updateMsg()", 5000);
            }

			$(document).ready(function(){
				$("button").click(function(){
					$("span.msgContent:last").after("<p><span class='msgTime'>" + getNowFormatDate() + "</span><span class='msgContent'> 我对 <?php echo $_GET['authorname'];?> 发送：" + $(".inputtext").val() + "</span></p>");
					$.post("chats.php",$("input").serialize());
					$("input").val("");
				});
			});
			
		</script>
</head>

<body>
	<div id="message">
	    <div id="chat">
	    	<p><span class='msgContent'>在下面输入框输入聊天内容！</span></p>
	    	
	    	
	    </div>
	</div>
	

		<div class="input">
		    <p><input name="input" class="inputtext" value="" ></p>
		    <button id="sendbtn">发送</button>
		</div>

</body>
</html>