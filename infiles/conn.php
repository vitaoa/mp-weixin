<?php
//
//	header("Content-type: text/html; charset=utf-8");
	$mysql_server_name='localhost:3306';

	$mysql_username='root';

	$mysql_password='';

	$db_name  = 'q1';

    $mysqli = new mysqli($mysql_server_name, $mysql_username, $mysql_password, $db_name); //数据库连接
    /* check connection */
    if ($mysqli->connect_errno) {
        printf("Connect failed: %s\n", $mysqli->connect_error);
        exit();
    }


	//选定数据库
    mysqli_select_db($mysqli,$db_name);	//选择数据库

  	//设置字符集，如utf8和gbk等，根据数据库的字符集而定
	mysqli_query($mysqli,"set names 'utf8'");

?>