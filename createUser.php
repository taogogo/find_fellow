<?php
include './inc/func.php';
$username = $_POST['username'];
$password = md5($_POST['password'] . 'shitt' );
$province = (int)$_POST['province'];
$city = (int)$_POST['city'];
$area = (int)$_POST['area'];
$gender = (int)$_POST['gender'];
$phone = trim($_POST['phone']);
$qq = trim($_POST['qq']);
$weibo = trim($_POST['weibo']);
$hobby = trim($_POST['hobby']);
$birthday = trim($_POST['birthday']);
$avater = trim($_POST['avater']);
$latitude = floatval( $_POST['latitude'] );
$longitude = floatval( $_POST['longitude'] );
if( trim( $username ) == '' )errorMsg( '账号未填写' );
if( trim( $password ) == '' )errorMsg( '密码未填写' );
if( $province<=0 )errorMsg( '家乡省未填写' );
if(  $city <= 0)errorMsg( '家乡市未填写' );
if( $area <= 0 )errorMsg( '家乡区/县未填写' );
if( $gender <= 0 )errorMsg( '性别未填写' );
include './inc/conn.php';
	$sql="INSERT INTO `user` (
`user_id` ,
`username` ,
`password`,
`phone`,
`gender`,
`avater`,
`province` ,
`city` ,
`area` ,
`qq`,
`weibo`,
`hobby`,
`birthday`,
`created`
)
VALUES (
NULL ,  '{$username}',  '{$password}', '{$phone}', '{$gender}', '{$avater}', '{$province}',  '{$city}', '{$area}','{$qq}','{$weibo}', '{$hobby}','{$birthday}', '{$_SERVER['REQUEST_TIME']}'
); ";//查询数据库province表也就是省
//echo $sql;
//$userId = mysql_insert_id();
	$result=mysql_query($sql);//执行语句赋值给变量
        $userId = mysql_insert_id();
//var_dump($userId);
if( !empty( $userId  ) ){
	if( !empty( $latitude ) && !empty( $longitude) )
	{
	$sql="INSERT INTO `user_geo` (
	`user_id` ,
	`latitude` ,
	`longitude`,
	`updated`
	)
	VALUES (
	{$userId} ,  '{$latitude}',  '{$longitude}', '{$_SERVER['REQUEST_TIME']}'
	); ";
          //die($sql);
	if( !mysql_query($sql) )
        errorMsg( '地理信息插入失败' );
        ;//执行语句赋值给变量
}      
succMsg('注册成功，请登录','login.php');
}
else
{
errorMsg('注册失败，请重试');
}