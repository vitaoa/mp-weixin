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

//根据全局access_token和openid查询用户信息
//$get_user_info_url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$ACC_TOKEN.'&openid='.$_POST['tousername'].'&lang=zh_CN';
//$userinfo = json_decode(file_get_contents($get_user_info_url));

//打印用户信息
//print_r($userinfo);
//print_r($userinfo->openid);

//_record_message("$fromusername","$keyword","$date_stamp");

$_result = _query("SELECT * FROM tbl_customer ORDER BY id");

?>
<form action="http://127.0.0.1/customerService.php" method="POST">
    <table cellspacing="1" width="100%" border="1" style="text-align: center;">
        <tr><th>消息ID</th><th>发送者</th><th>消息体</th><th>操作</th></tr>
        <?php
            while(!!$_rows = mysqli_fetch_array($_result)){
                $_html = array();
                $_html['id'] = $_rows['id'];
                $_html['from_user'] = $_rows['from_user'];
                $_html['message'] = $_rows['message'];
        ?>
        <tr>
            <td><?php echo $_html['id']?></td>
            <td><input type="text" name="tousername" class="text" value="<?php echo $_html['from_user'] ?>" /></td>
            <td><input type="text" name="message" class="text" value="<?php echo $_html['message'] ?>" /></td>
            <td><input type="submit" value="回复" /></td>
        </tr>
        <?php
            }
        ?>
    </table>
</form>
<?php
$xmlstring = <<<XML
<?xml version="1.0" encoding="ISO-8859-1"?>
<note>
<to>George</to>
<from>John</from>
<heading>Reminder</heading>
<body>Don't forget the meeting!</body>
</note>
XML;

$xml = simplexml_load_string($xmlstring);

var_dump($xml);

echo "<br/>";
echo $xml->to;
?>