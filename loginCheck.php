<?php
include './inc/func.php';
session_start();
$latitude = floatval($_POST['latitude']);
$longitude = floatval($_POST['longitude']);
$username = $_POST['username'];
$password = md5($_POST['password'] . 'shitt');
if (trim($username) == '')
    errorMsg('账号未填写');
if (trim($password) == '')
    errorMsg('密码未填写');
include './inc/conn.php';
$sql = "SELECT * FROM `user` WHERE `username`='{$username}' AND `password`='{$password}'";
$result = mysql_query($sql);
$userdata = mysql_fetch_array($result);
if (!empty($userdata['user_id'])) {
    if (!empty($latitude) && !empty($longitude)) {
        $sql = "REPLACE INTO `user_geo` (
	`user_id` ,
	`latitude` ,
	`longitude`,
	`updated`
	)
	VALUES (
	{$userdata['user_id']} ,  '{$latitude}',  '{$longitude}', '{$_SERVER['REQUEST_TIME']}'
	); ";
        if (!mysql_query($sql))
            die('地理信息插入失败');
        ; //执行语句赋值给变量
    }
    
    $_SESSION['user'] = $userdata;
    header('Location:arround.php');
}
errorMsg('用户不存在');