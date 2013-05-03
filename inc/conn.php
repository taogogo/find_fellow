<?php
$conn=mysql_connect(SAE_MYSQL_HOST_M.':'. SAE_MYSQL_PORT, SAE_MYSQL_USER, SAE_MYSQL_PASS);//链接数据库
          	mysql_select_db(SAE_MYSQL_DB);//选择数据库
          mysql_query("set names 'utf8'");//设定字符