<?php
//引入数据库处理函数
require_once 'sql.func.php';

function _record_message($fromusername,$keyword,$date_stamp){
    //调用_query()函数
    _query("INSERT INTO tbl_customer(from_user,message,time_stamp) VALUES('$fromusername','$keyword','$date_stamp')");
}


?>
