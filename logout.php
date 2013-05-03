<?php
session_start();
session_destroy();
$_SESSION['user'] = null;
header('location:login.php');
echo '退出成功';