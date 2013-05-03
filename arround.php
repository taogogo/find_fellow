<?php
session_start();
if (empty($_SESSION['user']['user_id'])) {
    header('location:login.php');
    die('木有登陆');
}

include './inc/conn.php';
include './inc/func.php';
?>
<title>周围的人</title>
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

}
// --></script>
<?php
include 'inc/nav.php';
?>
<a class="input-file" href="arround.php">周围</a>
<a class="input-file" href="arround.php?type=1">周围同省</a>
<a class="input-file" href="arround.php?type=2">周围同城</a>
<a class="input-file" href="arround.php?type=3">周围同区/县</a>
<br />
<?php
$sql = "SELECT * FROM `user_geo` WHERE `user_id`='{$_SESSION['user']['user_id']}'";
$result = mysql_query($sql);
$usergeo = mysql_fetch_array($result);
$sql = "SELECT * FROM `user` WHERE `user_id`='{$_SESSION['user']['user_id']}'";
$result = mysql_query($sql);
$userdata = mysql_fetch_array($result);
/**
 * @todo 得到地球周长
 */
function getEarthPerimeter() {
    $s = 2 * pi() * 6378.1; //圆周长公式:s=2 * pi * r
    return $s;
}

$userId = $usergeo['user_id'];
$longitude = $usergeo['longitude'];
$latitude = $usergeo['latitude'];
$range = 1;
$count = 50;
$page = 1;
//假设地球是一个规则的球体，得到地球周长
$earthPerimeter = getEarthPerimeter();
//偏移距离所产生的角度偏移量
$offsetAngle = round(360 * ($range / $earthPerimeter), 5);
//筛选范围经度最大值
$longitudeMax = $longitude + $offsetAngle;
//筛选范围经度最小值
$longitudeMin = floatval($longitude - $offsetAngle);
//筛选范围纬度最大值
$latitudeMax = $latitude + $offsetAngle;
//筛选范围纬度最小值
$latitudeMin = floatval($latitude - $offsetAngle);
$offset = ($page - 1) * $count;
$limit = $count;
$where = "WHERE `longitude` BETWEEN {$longitudeMin} AND {$longitudeMax}
				AND `latitude` BETWEEN {$latitudeMin} AND {$latitudeMax}
				";
$where .= !empty($userId) ? "AND `user_id` != {$userId}" : '';

$sql = "SELECT `user_id` FROM `user_geo` {$where}";
//老乡查询条件
switch ($_GET['type']) {
    case 1 :
        $where = " AND `province`={$userdata['province']}";
        break;
    case 2 :
        $where = " AND `province`={$userdata['province']} AND `city`={$userdata['city']}";
        break;
    case 3 :
        $where = " AND `province`={$userdata['province']} AND `city`={$userdata['city']} AND `area`={$userdata['area']}";
        break;
    default :
        $where = "";
        break;

}
$sql = "SELECT * FROM `user`,`user_geo` WHERE `user`.`user_id` IN({$sql}) {$where} AND  `user`.`user_id` = `user_geo`.`user_id`";
//die($sql);
$result = mysql_query($sql);
$markers = '';
$markerStyles = '';
$labels = '';
$labelStyles = '';
$alert = '';
while ($row = mysql_fetch_array($result)) {
    $alert .= '<a class="userHeader" href="userInfo.php?userId=' . $row['user_id'] . '">' . '<img width="50" height="50" src="' . (empty($row['avater']) ? './static/images/default.png' : $row['avater']) . '" title="' . $row['username'] . '"/><div class="center userHeaderText">' . $row['username'] . '</div>' . '</a> ';
    $labels .= $row['longitude'] . ',' . $row['latitude'] . '|';
    $labelStyles .= myUrlEncode($row['username']) . ',,16,0,0xff0000,|';
}
$labels .= $usergeo['longitude'] . ',' . $usergeo['latitude'];
$labelStyles .= '%E6%88%91,,16,0,0xffffff,|';
?>
<hr />
在你附近的人
<hr />
<?php
echo $alert;
?>
<div style="clear: both;"></div>
他们在地图上的位置
<hr />
<img style="width: 100%;"
	src="./geofix.php?longitude=<?php
echo $usergeo['longitude']?>&latitude=<?php
echo $usergeo['latitude']?>&markers=<?php
echo $markers?>&markerStyles=<?php
echo $markerStyles?>&labels=<?php
echo $labels?>&labelStyles=<?php
echo $labelStyles?>" />
<div class="alertBox" id="getYourLocation">☹正在获取你的位置...<br />
请在弹出的获取地理位置信息中选择允许，如已禁止获取，请在设置内取消禁止设置</div>