<?php
function _query($_sql){
    if(!$_result = mysql_query($_sql)){
        exit('SQL执行失败'.mysql_error());
    }
    return $_result;
}


?>
