<?php session_start();?>
<html>
<head>
<title>登陆</title>
    	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<script type="text/javascript">

var alertFlag = 0;
function getLocation()
{
            if (navigator.geolocation)
            {
                    navigator.geolocation.getCurrentPosition(showPosition,showError);
              //navigator.geolocation.watchPosition(showPosition,showError);
            }
            else
            {
            	document.getElementById('getYourLocation').innerHTML="浏览器不支持HTML5定位";
                
              //detailsDiv.innerHTML="浏览器不支持HTML5定位";
            }
}
  
  
  /////////////////////////////////////


function showPosition(position)
{
	
  //alert('getok');
  //distance = getDistance(position.coords.latitude,position.coords.longitude,homeLatitude,homeLongitude);
  //alert( position.coords.latitude );
        document.getElementById('longitude').value=position.coords.longitude;
        document.getElementById('latitude').value=position.coords.latitude;
        document.getElementById('getYourLocation').innerHTML="✔已经获取您的地理位置";
  //return true;
  //document.getElementById('geoDetail').innerHTML="纬度: " + position.coords.latitude + 
  //	"经度: " + position.coords.longitude;
        
        
  //document.getElementById('geoImage').innerHTML="<img src=\"http://api.map.baidu.com/staticimage?width=200&height=150&center="+position.coords.longitude+","+position.coords.latitude+"&zoom=17\" />";
  //document.getElementById('geoImage').style.backgroundImage="url(http://api.map.baidu.com/staticimage?width=400&height=200&center="+position.coords.longitude+","+position.coords.latitude+"&zoom=17)"; //改变背景图片  
         //"<br />距离(<span id=\"currentPlace\">"+( currentPlace ? currentPlace : "地心")+"</span>): <span id=\"distance\">" + distance+"</span>公里";
  //latitudeInput.value=position.coords.latitude;
  //	longitudeInput.value=position.coords.longitude;
  //	if(  distance<= ALERT_DISTANCE && alertSwitch == false )
  //	{
		showAlert();
		//alert('到了哦');
  //	}
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
  //getLocation();
 //getLocation();
onload = function(){
  //	select();
  getLocation();
   window.setInterval(getLocation,10000);

}
// --></script>
</head>
<body>
 <?php include 'inc/nav.php';?>
  <div class="alertBox">《找老乡》是一款基于LBS的找朋友软件，如果您没有账号，请<a href="create.php">注册</a>。</div>
 
	<form id='form1' action="loginCheck.php" method="post"><!--输出表单头-->
          账号:<input name="username"><br />
          密码:<input type="password" name="password"><br />
          <input type="hidden" id="longitude" name="longitude">
          <input type="hidden" id="latitude" name="latitude">
          <input class="subbtn" type="submit" value="登陆找老乡" />
	</form><!--表单项结尾-->
        <div class="alertBox" id="getYourLocation">☹正在获取你的位置...<br />请在弹出的获取地理位置信息中选择允许，如已禁止获取，请在设置内取消禁止设置</div>
        <!--
        <hr />
  <div style="font-size:12px;">位置:<span id="geoDetail">无法获取</span></div>
  <div style="width:100%;height:200px;" id="geoImage"></div>
  -->
</body>
</html>