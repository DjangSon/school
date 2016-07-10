<?php
	//加载数据库配置文件。
	require './inc/config.php';
	//加载跳转页面函数。
	require './inc/loading.php';
	
	if (!empty($_GET['authorname'])){
		
		$datas = $database->select("chat", "*", [
				"AND" => [
						"towho" => $_GET['authorname'],
						"flag" => "1"
				]
		]);
		foreach($datas as $data){

			echo '<p><span class="msgTime">'.$data['sendtime'].'</span><span class="msgContent">'.$data['fromwho'].' 对 你 说：'.$data['message'].'</span></p>';
			$database -> update("chat", [
					"flag" => 0
			],[
					"ID" => $data['ID']
			]);
		}
		
	}
	
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$reciver = $_POST['reciver'];
		$database -> insert("chat", [
				"fromwho" => base64_decode(base64_decode($_COOKIE['username'])),
				"towho" => base64_decode(base64_decode($_COOKIE['reciverName'])),
				"message" => $_POST['input'],
				"sendtime" => date("Y/m/d H:i:s")
		]);
	}
?>