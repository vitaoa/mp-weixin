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

?>
<form>
    <table cellspacing="1" width="100%" border="1" style="text-align: center;">
        <tr><th>消息ID</th><th>发送者</th><th>消息体</th><th>消息时间</th><th>操作</th></tr>
        <?php 
            while(!!$_rows = mysqli_fetch_array($_result)){
                $_html = array();
                $_html['id'] = $_rows['id'];
                $_html['from_user'] = $_rows['from_user'];
                $_html['message'] = $_rows['message'];
                $_html['time_stamp'] = $_rows['time_stamp'];
        ?>
        <tr>
            <td><?php echo $_html['id']?></td>
            <td><?php echo $_html['from_user']?></td>
            <td><?php echo $_html['message']?></td>
            <td><?php echo $_html['time_stamp']?></td>
            <td><a href="reply.php?fromusername=<?php echo $_html['from_user']?>&message=<?php echo $_html['message']?>"><input type="button" value="回复" /></a></td>
        </tr>
        <?php 
            }
        ?>
    </table>
</form>