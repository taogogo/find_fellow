<?php
session_start();
?>

<html>
<head>
<title>注册</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport"
	content="width=device-width, initial-scale=1, maximum-scale=1">
<!--------------------------------------------------------------
--省的字段是：province
--市的字段是：city
--县的字段是：area
--------------------------------------------------------------------------->
<script type="text/javascript">
var alertFlag = 0;
var xmlHttp;//声明变量
var requestType="";//声明初始类型为空
function createXMLHttpRequest()//定义创建一个跨浏览器函数的开头
{
	if(window.ActiveXObject)//ActiveXObject对象到找到的时候返回的是真，否则是假
	{
		xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");//这个是使用IE的方法创建XmlHttp
	}
	else if(window.XMLHttpRequest)
	{
		xmlHttp=new XMLHttpRequest();//这个是使用非IE的方法创建XmlHttp
	}
}
/***************
*判断服务器响应的事件，如果返回是4则说明交互完成，判断标示头，
*
*************************************************/
function handleStateChange(){//判断返回的一个函数，来确定执行那个的函数

	if(true||xmlHttp.readystate==4)
        
		{//4说明是执行交互完毕0 (未初始化)1 (正在装载)2 (装载完毕) 3 (交互中)4 (完成)
                  //alert('see'+type);
                  //alert(xmlHttp.status);
		if(xmlHttp.status==200)
			{//http的一个报头说明成功找到
			if(type=="city"){//判断查询的类型
                        
								showcity();//返回响应的显示
							}
			else if(type="area"){//判断响应的查询的类型
									showarea();//返回响应的显示
								}
			}
		}
}
/*************************
*城市的一个查询函数
*
*********************************************************/
function queryCity(citycode){//执行程序查询，查询城市的
	createXMLHttpRequest();//调用创建XmlHttp的函数
	type="city";//表示类型，查询城市处理显示的时候需要用到
	var url='diquapi.php?provincecode='+citycode+'&n='+Math.random();//设定URL传值方法同时防止缓存
	xmlHttp.open("GET",url,true);//建立服务器连接，异步传输tree
	xmlHttp.onreadystatechange=handleStateChange;//处理这个响应所需要的函数
        
	xmlHttp.send(null);//执行程序函数这里的中间的参数是因为GET原因
}
/*********************
*县区的一个查询函数
***********************************************************/
function queryArea(citycode){//查询程序
	createXMLHttpRequest();//调用创建XmlHttp的函数
	type="area";//查询县的
	var url="diquapi.php?citycode="+citycode+'&n='+Math.random();//设定URL传值方法同时防止缓存
	xmlHttp.open("GET",url,true);
	xmlHttp.onreadystatechange=handleStateChange;//处理响应的函数名
	xmlHttp.send(null);//执行程序函数这里的中间的参数是因为GET原因
}
/********************
*一个显示函数
**********************************************************/
function showcity(){//显示函数
	document.getElementById("city").innerHTML=xmlHttp.responseText;//捕获ID显示返回的数据
}
function showarea(){
	document.getElementById("area").innerHTML=xmlHttp.responseText;//捕获ID显示返回的数据
}


function getLocation()
{
            if (navigator.geolocation)
            {
                    navigator.geolocation.getCurrentPosition(showPosition,showError);
            }
            else
            {
            document.getElementById('getYourLocation').innerHTML="浏览器不支持HTML5定位";
                    detailsDiv.innerHTML="浏览器不支持HTML5定位";
            }
}
function showPosition(position)
{

        document.getElementById('longitude').value=position.coords.longitude;
        document.getElementById('latitude').value=position.coords.latitude;
        document.getElementById('getYourLocation').innerHTML="✔已经获取您的地理位置";
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
  document.getElementById("province").options[0].selected=true; 
}
// --></script>
</head>
<body>
  <?php
include 'inc/nav.php';
?>
<?php

include 'inc/conn.php';
$sql = "select * from province"; //查询数据库province表也就是省
$result = mysql_query($sql); //执行语句赋值给变量
?>
 
	<form id='form1' action="createUser.php" method="post"><!--输出表单头--> 账号:<input
	name="username"><br />
密码:<input name="password" type="password"><br />
性别: <input type="radio" name="gender" value="1" checked>男 <input
	type="radio" name="gender" value="2"> 女<br />
          
          
          <?php
        if (strpos($_SERVER["HTTP_USER_AGENT"], "iPod") || strpos($_SERVER["HTTP_USER_AGENT"], "iPhone") || strpos($_SERVER["HTTP_USER_AGENT"], "iPad")) {
            ?>
          头像:
          <span id="picUrl"><img height="30"
	src="./static/images/iphoneAvater.png" /></span>(IOS浏览器无法更换)
<div style="clear: both;"></div>
<input type="hidden" id="avater" name="avater"
	value="./static/images/iphoneAvater.png">
          <?php
        } else {
            ?>
          
          <iframe src="./helper/upload.php"
	style="border: 0; padding: 0px; margin: 0px; width: 100%; height: 30px; overflow: hidden; line-height: 28px; display: inline; float: left;"></iframe>
<div style="clear: both;"></div>
<span id="picUrl"><img height="30" src="./static/images/default.png" /></span>
<div style="clear: both;"></div>
<input type="hidden" id="avater" name="avater" value="">
          <?php
        }
        ?>
          
          家乡:
	<!--输出下拉列表框，并设定onchange响应事件，把省值传递过去--> <select id='province'
	name="province"
	onchange='queryCity(this.options[this.selectedIndex].value)'>
	<!--输出下拉列表项值-->
	<option value='-1' selected>省份</option>
	<?php
while ($row = mysql_fetch_row($result)) {
    //循环循环查询显示省输出数据显示
    echo "<option value='$row[1]'>$row[2]</option>/n";
}
?>
	</select><!--下拉列表项尾数--> <span id='city'></span><!--显示数据的城市的位置--> <span
	id='area'></span><!--显示数据的城市的位置--> <br />
生日:<input name="birthday" type="date" value="1985-01-01"><br />
电话:<input name="phone"><br />
QQ:<input name="qq"><br />
微博:<input name="weibo"><br />
爱好:<input name="hobby"><br />
<input type="hidden" id="longitude" name="longitude"> <input
	type="hidden" id="latitude" name="latitude"> <input class="subbtn"
	type="submit" value="注册找老乡" /></form>
<!--表单项结尾-->
<div class="alertBox" id="getYourLocation">☹正在获取你的位置...<br />
请在弹出的获取地理位置信息中选择允许，如已禁止获取，请在设置内取消禁止设置</div>
</body>
</html>