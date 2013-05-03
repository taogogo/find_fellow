<link rel="stylesheet" href="/static/css/common.css" media="screen" />
<fieldset style="border-radius: 11px 5px 11px;border:2px solid gray;">
  <legend>:: <?php echo empty( $_SESSION['user']['username'] ) ? '您尚未登录' : '欢迎' . $_SESSION['user']['username'];?> ::</legend>
  
<div id="nav">
  <?php if( empty( $_SESSION['user']['username'] ) ){?>
<a href="create.php">注册</a> <a href="login.php">登陆</a> <a href="about.php">关于</a> 
  <?php }else{?>
<a href="arround.php">周围好友</a>  <a href="logout.php"> 退出</a>
  <?php }?>
  </div>
  <hr />
<!--
</fieldset>
-->