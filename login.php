<?php
session_start();
?>
<html>
<head>
<title>登陆</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport"
	content="width=device-width, initial-scale=1, maximum-scale=1">
<script type="text/javascript">

var alertFlag = 0;
function getLocation()
{
            if (navigator.geolocation)
            {
                    navigator.geolocation.getCurrentPosition(showPosition,showError);
            }
            else
            {
            	document.getElementById('getYourLocation').innerHTML="浏览器不支持HTML5定位";
            }
}
  

function showPosition(position)
{
        document.getElementById('longitude').value=position.coords.longitude;
        document.getElementById('latitude').value=position.coords.latitude;
        document.getElementById('getYourLocation').innerHTML="✔已经获取您的地理位置";
		showAlert();
}
function showError(error)
{
	var errorMsg = '';
	switch(error.code) 
	{
		case error.PERMISSION_DENIED:
			errorMsg="用户不允许浏览器获取地理位置信息"
			break;
		case error.POSITION_UNAVAILABLE:
			errorMsg="位置信息无法获取"
			break;
		case error.TIMEOUT:
			errorMsg="获取用户位置信息超时"
			break;
		case error.UNKNOWN_ERROR:
			errorMsg="未知错误"
			break;
	}
        
         errorMsg = errorMsg+"\n请使用chrome或safari浏览器，在弹出的允许获取地理位置提示时，点击允许。";
        if(alertFlag==0)alert(errorMsg);
        alertFlag=1;
}
onload = function(){
  getLocation();
   window.setInterval(getLocation,10000);

}
// --></script>
</head>
<body>
 <?php
include 'inc/nav.php';
?>
  <div class="alertBox">《找老乡》是一款基于LBS的找朋友软件，如果您没有账号，请<a
	href="create.php">注册</a>。</div>

<form id='form1' action="loginCheck.php" method="post"><!--输出表单头--> 账号:<input
	name="username"><br />
密码:<input type="password" name="password"><br />
<input type="hidden" id="longitude" name="longitude"> <input
	type="hidden" id="latitude" name="latitude"> <input class="subbtn"
	type="submit" value="登陆找老乡" /></form>
<!--表单项结尾-->
<div class="alertBox" id="getYourLocation">☹正在获取你的位置...<br />
请在弹出的获取地理位置信息中选择允许，如已禁止获取，请在设置内取消禁止设置</div>
</body>
</html>