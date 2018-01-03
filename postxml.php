<?php

//引入数据库操作文件
require_once 'infiles/conn.php';
require_once 'pages/json.php';

// require_once 'sql.func.php';
function _query($_sql){
    if(!$_result = mysqli_query($GLOBALS['mysqli'],$_sql)){
        exit('SQL执行失败'.mysql_error());
    }
    return $_result;
}

// require_once 'record_message.func.inc.php';
function _record_message($fromusername,$keyword,$date_stamp){
    _query("INSERT INTO tbl_customer(from_user,message,time_stamp) VALUES('$fromusername','$keyword','$date_stamp')");
}


//_record_message("$fromusername","$keyword","$date_stamp");

$_result = _query("SELECT * FROM tbl_customer ORDER BY id");
while(!!$_rows = mysqli_fetch_array($_result)){
    $_html = array();
    $_html['id'] = $_rows['id'];
    $_html['from_user'] = $_rows['from_user'];
    $_html['message'] = $_rows['message'];
}

//首先检测是否支持curl
if (!extension_loaded("curl")) {
	trigger_error("对不起，请开启curl功能模块！", E_USER_ERROR);
}

//构造xml
$xmldata="<?xml version='1.0' encoding='UTF-8'?><note><ToUserName>".$_html['from_user']."</ToUserName><FromUserName>".$_html['from_user']."</FromUserName><Content>".$_html['message']."</Content></note>";



//初始一个curl会话
$curl = curl_init();

//设置url
curl_setopt($curl, CURLOPT_URL,"http://zhouweivita.cn/customerService.php");

//设置发送方式：post
curl_setopt($curl, CURLOPT_POST, true);

//设置发送数据
curl_setopt($curl, CURLOPT_POSTFIELDS, $xmldata);

//抓取URL并把它传递给浏览器
curl_exec($curl);

//关闭cURL资源，并且释放系统资源
curl_close($curl);
?>
