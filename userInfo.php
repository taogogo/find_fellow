<?php
session_start();
include './inc/func.php';
if( empty( $_SESSION['user']['user_id'] )){
  header('location:login.php');
die('木有登陆');
}

$userId = intval($_GET['userId']);
?>
<html>
<head>
<title>用户信息</title>
    	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<?php
include './inc/nav.php';

include './inc/conn.php';
?>

<?php
$sql  = "SELECT * FROM `user_geo` WHERE `user_id`='{$_SESSION['user']['user_id']}'";
          $result = mysql_query($sql);
          $mygeo = mysql_fetch_array($result);
$sql  = "SELECT * FROM `user_geo` WHERE `user_id`='{$userId}'";
          $result = mysql_query($sql);
          $usergeo = mysql_fetch_array($result);
          $sql  = "SELECT * FROM `user` WHERE `user_id`='{$userId}'";
          $result = mysql_query($sql);
          $userdata = mysql_fetch_array($result);
?>
个人信息：<br />
账号：<?php echo $userdata['username'] ?><br />
性别：<?php echo getGender($userdata['gender']);?><br />
生日：<?php echo empty( $userdata['birthday'] ) ? '未填写生日' : date( 'Y-m',strtotime(  $userdata['birthday'] ) ) ?><br />

电话：<?php echo empty( $userdata['phone'] ) ? '未填写电话' : $userdata['phone'] ?><br />

爱好：<?php echo empty( $userdata['hobby'] ) ? '未填写爱好' : $userdata['hobby'] ?><br />

qq：<?php echo empty( $userdata['qq'] ) ? '未填写qq' : $userdata['qq'] ?><br />
微博：<?php echo empty( $userdata['weibo'] ) ? '未填写微博' : $userdata['weibo'] ?><br />
头像：<?php echo empty( $userdata['avater'] ) ? '无头像' : '<img src="'.$userdata['avater'] . '" />' ?><br />
距离：<?php
require ('./inc/gPoint.php');

	$myHome = new gPoint();	// Create an empty point
	$myHome->setLongLat($mygeo['longitude'], $mygeo['latitude']);	// I live in sunny California :-)
//echo "I live at: "; $myHome->printLatLong(); echo "<br>";
echo (int)$myHome->distanceFrom($usergeo['longitude'], $usergeo['latitude']);
?>米左右